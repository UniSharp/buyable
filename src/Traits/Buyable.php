<?php
namespace UniSharp\Buyable\Traits;

use UniSharp\Buyable\Models\Spec;
use InvalidArgumentException;

trait Buyable
{
    protected $specAttributes = ['spec', 'price', 'stock', 'sku'];
    protected $orignialSpec;
    protected $spec;
    protected $specified = false;

    public static function bootBuyable()
    {
        static::created(function ($model) {
            if ($model->isSpecDirty()) {
                $model->specs()->create($model->getSpecDirty());
            }
        });

        static::updated(function ($model) {
            if ($model->isSpecDirty()) {
                $model->specs()->updateOrCreate(['name' => $model->getSpecDirty()['name']], $model->getSpecDirty());
            }
        });

        static::deleted(function ($model) {
            if ($model->isSpecDirty()) {
                $model->specs()->delete();
            }
        });
    }

    public function specs()
    {
        return $this->morphMany(Spec::class, 'buyable');
    }

    public function setSpec($key, $value)
    {
        if (!in_array($key, $this->specAttributes)) {
            throw new InvalidArgumentException();
        }

        $key = $key == 'spec' ? 'name' : $key;
        $this->spec[$key] = $value;

        $this->specified = true;
    }

    public function getSpec($key)
    {
        if (!($this->specified || $this->isSingleSpec())) {
            throw new InvalidArgumentException("Didn't specify a spec or it's not a single spec buyable model");
        }

        $key = $key == 'spec' ? 'name' : $key;
        if ($this->isSingleSpec()) {
            $this->originalSpec = $this->specs->first();
        }

        return $this->spec[$key] ?? $this->originalSpec[$key];
    }

    public function fill(array $attributes)
    {
        if (isset($attributes['price'])) {
            $this->setSpec('spec', 'default');
            foreach (array_only($attributes, $this->specAttributes) as $key => $value) {
                $this->setSpec($key, $value);
            }
        }

        array_forget($attributes, $this->specAttributes);
        return parent::fill($attributes);
    }

    public function getSpecDirty()
    {
        return $this->spec;
    }

    public function isSingleSpec()
    {
        return $this->specs->count() == 1;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->specAttributes)) {
            $this->spec[$key] = $value;
            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->specAttributes)) {
            return $this->getSpec($key);
        }

        return parent::getAttribute($key);
    }

    public function isSpecDirty()
    {
        return is_array($this->getSpecDirty()) && count($this->getSpecDirty()) > 0;
    }

    public function save(array $options = [])
    {
        if (!parent::save($options)) {
            return false;
        }

        if ($this->exists && $this->isSpecDirty()) {
            $this->fireModelEvent('saved', false);
            $this->fireModelEvent('updated', false);
        }

        return true;
    }

    public function specify($spec)
    {
        switch (true) {
            case $spec instanceof Model:
                $this->originalSpec = $spec;
                break;
            case is_numeric($spec):
                $this->originalSpec = $this->specs->where('id', $spec)->first();
                break;
            case is_string($spec):
                $this->originalSpec = $this->specs->where('name', $spec)->first();
                break;
        }

        $this->specified = true;
        return $this;
    }
}

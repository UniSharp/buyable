<?php
namespace UniSharp\Buyable\Traits;

use UniSharp\Buyable\Models\Spec;
use InvalidArgumentException;

trait Buyable
{
    protected $specAttributes = ['spec', 'price', 'stock'];
    protected $orignialSpec;
    protected $spec;

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
        parent::fill($attributes);
    }

    public function getSpecDirty()
    {
        return $this->spec;
    }

    public function isSingleSpec()
    {
        return $this->spec()->count() == 1;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->specAttributes)) {
            $this->spec[$key] = $value;
            return $this;
        }

        return parent::setAttribute($key, $value);
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
    }
}

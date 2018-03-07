<?php
namespace UniSharp\Buyable\Traits;

use UniSharp\Buyable\Models\Spec;

trait Buyable
{
    protected $originaleSpecs = [];
    protected $specs = [];

    public static function bootBuyable()
    {
        static::created(function ($model) {
            $model->specs()->createMany($model->getSpecsDirty());
        });
    }

    public function specs()
    {
        return $this->morphMany(Spec::class, 'buyable');
    }

    public function setSpec($name, $price, $stock)
    {
        $this->specs[] = [
            'name' => $name,
            'price' => $price,
            'stock' => $stock
        ];
    }

    public function fill(array $attributes)
    {
        if (isset($attributes['price'])) {
            $this->setSpec(
                $attributes['spec'] ?? 'default',
                $attributes['price'],
                $attributes['stock'] ?? 0
            );
        }

        array_forget($attributes, ['spec', 'price', 'stock']);
        parent::fill($attributes);
    }

    public function getSpecsDirty()
    {
        return $this->specs;
    }

    public function isSingleSpec()
    {
        return $this->spec()->count() == 1;
    }
}

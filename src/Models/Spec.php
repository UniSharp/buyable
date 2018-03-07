<?php

namespace UniSharp\Buyable\Models;

use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    protected $fillable = ['name', 'price', 'stock'];
}

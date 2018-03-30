<?php

namespace UniSharp\Buyable\Models;

use Illuminate\Database\Eloquent\Model;
use UniSharp\Buyable\Contracts\BuyableModelContract;

class Buyable extends Model implements BuyableModelContract
{
    protected $fillable = ['vendor'];
}

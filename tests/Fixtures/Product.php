<?php
namespace UniSharp\Buyable\Tests\Fixtures;

use UniSharp\Buyable\Traits\Buyable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Buyable;
    protected $fillable = ['name'];
}

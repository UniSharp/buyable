<?php
namespace UniSharp\Buyable\Tests\Feature;

use UniSharp\Buyable\Tests\TestCase;
use UniSharp\Buyable\Tests\Fixtures\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\Relation;

class BuyableTest extends TestCase
{
    use RefreshDatabase;
    public function setUp()
    {
        parent::setUp();
        Relation::morphMap([
            'product' => Product::class
        ]);
    }

    public function testCreateBuyableModel()
    {
        $product = Product::create([
            'name' => 'product A',
        ]);

        $product->specs()->create([
            'name'  => '黑色',
            'price' =>  1,
            'stock' => 0,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'product A'
        ]);

        $this->assertDatabaseHas('specs', [
            'buyable_type' => 'product',
            'buyable_id' => $product->id,
            'price' =>  1,
            'stock' => 0,
        ]);
    }

    public function testCreateBuyableModelWithDefaultSpec()
    {
        $product = Product::create([
            'name' => 'product A',
            'price' => 20,
            'stock' => 5,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'product A'
        ]);

        $this->assertDatabaseHas('specs', [
            'buyable_type' => 'product',
            'buyable_id' => $product->id,
            'name' => 'default',
            'price' =>  20,
            'stock' => 5,
        ]);
    }

    public function testCreateBuyableModelWithSpecifiedSpec()
    {
        $product = Product::create([
            'name' => 'product A',
            'spec' => '黑色',
            'price' => 20,
            'stock' => 5,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'product A'
        ]);

        $this->assertDatabaseHas('specs', [
            'buyable_type' => 'product',
            'buyable_id' => $product->id,
            'name' => '黑色',
            'price' =>  20,
            'stock' => 5,
        ]);
    }
}

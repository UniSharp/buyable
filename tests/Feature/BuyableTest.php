<?php
namespace UniSharp\Buyable\Tests\Feature;

use InvalidArgumentException;
use UniSharp\Buyable\Models\Spec;
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
            'sku' => 'B-1',
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
            'sku' => 'B-1',
        ]);
    }

    public function testUpdateBuyableModel()
    {
        $product = Product::create([
            'name' => 'product A',
            'price' => 20,
            'stock' => 5,
        ]);

        $product->price = 1;
        $product->stock = 1;
        $product->sku = 'B-2';
        $product->save();

        $this->assertDatabaseHas('specs', [
            'buyable_type' => 'product',
            'buyable_id' => $product->id,
            'price' =>  1,
            'stock' => 1,
            'sku' => 'B-2'
        ]);
    }

    public function testUpdateBuyableModelByUpdateQueryBuilder()
    {
        $product = Product::create([
            'name' => 'product A',
        ]);

        $product->update([
            'spec' => '黑',
            'price' => 1,
            'stock' => 1,
            'sku' => 'B-1',
        ]);

        $product->update([
            'spec' => '白',
            'price' => 2,
            'stock' => 2,
            'sku' => 'W-1',
        ]);

        $this->assertDatabaseHas('specs', [
            'buyable_type' => 'product',
            'buyable_id' => $product->id,
            'name' => '黑',
            'price' =>  1,
            'stock' => 1,
            'sku' => 'B-1',
        ]);

        $this->assertDatabaseHas('specs', [
            'buyable_type' => 'product',
            'buyable_id' => $product->id,
            'name' => '白',
            'price' =>  2,
            'stock' => 2,
            'sku' => 'W-1',
        ]);
    }

    public function testGetBuyableModelAttributeWithSingleSpec()
    {
        $product = Product::create([
            'name' => 'product A',
            'price' => 20,
            'stock' => 5,
        ]);

        $this->assertEquals(20, Product::find($product->id)->price);
    }

    public function testGetBuyableModelAttributeWithoutSpecifySpec()
    {
        $this->expectException(InvalidArgumentException::class);

        $product = Product::create([
            'name' => 'product A',
        ]);

        $product->update([
            'spec' => '黑',
            'price' => 1,
            'stock' => 1,
        ]);

        $product->update([
            'spec' => '白',
            'price' => 2,
            'stock' => 2,
        ]);

        $this->assertEquals(2, Product::find($product->id)->price);
    }

    public function testGetBuyableModelAttributeWithSpecifySpec()
    {
        $product = Product::create([
            'name' => 'product A',
        ]);

        $product->update([
            'spec' => '黑',
            'price' => 1,
            'stock' => 1,
        ]);

        $product->update([
            'spec' => '白',
            'price' => 2,
            'stock' => 2,
        ]);

        $this->assertEquals(1, Product::find($product->id)->specify('黑')->price);
        $this->assertEquals(2, Product::find($product->id)->specify(Spec::whereName('白')->first()->id)->price);
    }

    public function testDelete()
    {
        $product = Product::create([
            'name' => 'product A',
            'spec' => '黑',
            'price' => 1,
            'stock' => 1,
        ]);

        $this->assertDatabaseHas('specs', [
            'name' => '黑',
            'price' => 1,
            'stock' => 1,
        ]);

        $product->delete();

        $this->assertDatabaseMissing('specs', [
            'name' => '黑',
            'price' => 1,
            'stock' => 1,
        ]);
    }
}

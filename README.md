# UniSharp Buyable

Let laravel model buyable

## Installation

- Install package

    ```composer require unisharp/buyable dev-master```

- Migrate tables

    ```php artisan migrate```

## Usages

Use trait in model

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use UniSharp\Buyable\Traits;

class Product extends Model
{
    use Buyable;
}
```

Create model and model's specs at the same time

```php
Product::create([
    'name' => 'product A',
    'spec' => 'Black',
    'price' => 20,
    'stock' => 5,
    'sku' => 'B-1',
    'sold_qty' => 2
]);
```

Change one of model's spec

```php
$product->price = 1;
$product->stock = 1;
$product->sku = 'B-2';
$product->sold_qty = 2;
$product->save();
```

Specified one of model's specs

```php
$spec = Spec::where('name', 'Black')->first();

$product->specify($spec);

$product->specify($spec->id);

$product->specify('Black');
```

Get all of model's specs

```php
$product->specs
```

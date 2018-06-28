# UniSharp Buyable

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

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

[ico-version]: https://img.shields.io/packagist/v/UniSharp/buyable.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/UniSharp/buyable/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/UniSharp/buyable.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/UniSharp/buyable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/UniSharp/buyable.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/unisharp/buyable
[link-travis]: https://travis-ci.org/UniSharp/buyable
[link-scrutinizer]: https://scrutinizer-ci.com/g/UniSharp/buyable/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/UniSharp/buyable
[link-downloads]: https://packagist.org/packages/UniSharp/buyable
[link-author]: https://github.com/UniSharp
[link-contributors]: ../../contributors

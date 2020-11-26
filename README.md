<p align="center">
  <img height="400" src="logo.jpeg" alt="logo" />
</p>
<br>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mouadziani/laravel-model-trackable.svg?style=flat-square)](https://packagist.org/packages/mouadziani/laravel-model-trackable)
[![Total Downloads](https://img.shields.io/packagist/dt/mouadziani/laravel-model-trackable.svg?style=flat-square)](https://packagist.org/packages/mouadziani/laravel-model-trackable)

A laravel package that allows you to track and log nested changes applied on your (models, and their relations) using a **single Trait** 

## Installation

You can install the package via composer:

```bash
composer require mouadziani/laravel-model-trackable
```

## Simple Usage

``` php

use LaravelModelTrackable\Traits\Trackable;

class ModelName extends Model
{
    use Trackable;

    //
}
```

##### Then you can get array of changed attribute after every update
``` php
$model = ModelName::update([
    ...
]);

// Get list of changed attributes
$model->getChangedAttributes();
 ```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mouad.ziani1997@gmail.com instead of using the issue tracker.

## Credits

- [Mouad ZIANI](https://github.com/mouadziani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

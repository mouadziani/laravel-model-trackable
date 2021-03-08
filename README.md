<p align="center">
  <img src="logo.jpeg" alt="logo" />
</p>
<br>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mouadziani/laravel-model-trackable.svg?style=flat-square)](https://packagist.org/packages/mouadziani/laravel-model-trackable)

A laravel package that allows you to track and log nested changes applied on your (models, and their relations) using a **single Trait** 

## Installation

You can install the package via composer:

```bash
composer require mouadziani/laravel-model-trackable
```

## Simple Usage

- Firstly you have to apply trackable trait on your model

``` php

use LaravelModelTrackable\Traits\Trackable;

class ModelName extends Model
{
    use Trackable;

    //
}
```

- In case you want to track the changes applied on your model's relationships, you need to add an attribute in your model called `$toBeLoggedRelations` which must contain an array of relationships like the example below
``` php

use LaravelModelTrackable\Traits\Trackable;

class ModelName extends Model
{
    use Trackable;

    public $toBeLoggedRelations = ['relation1', 'relation2'];
}
```


- Then, you can get an array that should contains all changes applied on your model after every update
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

feautred_repository

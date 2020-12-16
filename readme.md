# Laravel Redshift

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Redshift is compatible with Postgresql.
However, not everything in Postgresql is compatible, and there are some data types that cannot be used.
This library exists to absorb them and make it possible to handle Redshift on Laravel cleanly.

## Installation

Via Composer

``` bash
$ composer require yuk1/laravel-redshift
```

## Usage

Add the Redshift driver to `config/database.php`.

```config/database.php
'connections' => [
  'redshift' => [
    'driver' => 'redshift',
      'host' => env('AWS_REDSHIFT_HOST', '127.0.0.1'),
      'port' => env('AWS_REDSHIFT_PORT', '5439'),
      'database' => env('AWS_REDSHIFT_DATABASE', 'redshit'),
      'username' => env('AWS_REDSHIFT_USERNAME', 'root'),
      'password' => env('AWS_REDSHIFT_PASSWORD', ''),
    ],
  ],
]
```

Then, write the connection information in the .env file.

```.env
DB_CONNECTION=redshift
AWS_REDSHIFT_HOST=
AWS_REDSHIFT_PORT=
AWS_REDSHIFT_DATABASE=
AWS_REDSHIFT_USERNAME=
AWS_REDSHIFT_PASSWORD=
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [YuK1Game][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/yuk1/laravel-redshift.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/yuk1/laravel-redshift.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/yuk1/laravel-redshift/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/yuk1/laravel-redshift
[link-downloads]: https://packagist.org/packages/yuk1/laravel-redshift
[link-travis]: https://travis-ci.org/yuk1/laravel-redshift
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/yuk1
[link-contributors]: ../../contributors

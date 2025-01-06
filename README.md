# Esi Integration for EVE Online

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nicolaskion/esi.svg?style=flat-square)](https://packagist.org/packages/nicolaskion/esi)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/nicolaskion/esi/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nicolaskion/esi/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/nicolaskion/esi/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/nicolaskion/esi/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/nicolaskion/esi.svg?style=flat-square)](https://packagist.org/packages/nicolaskion/esi)

This package integrates EVE's API into a laravel application.

## Installation

You can install the package via composer:

```bash
composer require nicolaskion/esi
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="esi-config"
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

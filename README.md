<img src="https://banners.beyondco.de/Laravel%20Beekeeper.png?theme=light&packageManager=composer+require&packageName=codebar-ag%2Flaravel-beekeeper&pattern=circuitBoard&style=style_1&description=An+opinionated+way+to+integrate+Beekeeper+with+Laravel&md=1&showWatermark=0&fontSize=175px&images=photograph">



[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-beekeeper.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-beekeeper)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-beekeeper.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-beekeeper)
[![GitHub-Tests](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/run-tests.yml)
[![GitHub Code Style](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/fix-php-code-style-issues.yml)
[![PHPStan](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/phpstan.yml/badge.svg)](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/phpstan.yml)
[![Dependency Review](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/dependency-review.yml/badge.svg)](https://github.com/codebar-ag/laravel-beekeeper/actions/workflows/dependency-review.yml)

This package was developed to give you a quick start to communicate with the
Beekeeper Api. It is used to query the most common endpoints.

## Navigation
<!-- TOC -->
  * [Navigation](#navigation)
  * [🛠 Requirements](#-requirements)
  * [Installation](#installation)
  * [Usage](#usage)
  * [DTO Showcase](#dto-showcase)
  * [Testing](#testing)
  * [Changelog](#changelog)
  * [Contributing](#contributing)
  * [Security Vulnerabilities](#security-vulnerabilities)
  * [Credits](#credits)
  * [License](#license)
<!-- TOC -->

## 🛠 Requirements

| Version | PHP Version | Laravel Version |
|---------|-------------|-----------------|
| v12.0.0 | ^8.2 - ^8.4 | ^12.*           |

## Installation

You can install the package via composer:

```bash
composer require codebar-ag/laravel-beekeeper
```

Then:

```bash
php artisan beekeeper:install
```


Or:

You can publish the config file with:

```bash
php artisan vendor:publish --tag="beekeeper-config"
```

This is the contents of the published config file:

```php
<?php

return [

];
```

You should finally add the following to your .env file:

```env
BEEKEEPER_CLIENT_ID=your-client-id
BEEKEEPER_CLIENT_SECRET=your-client-secret
BEEKEEPER_CACHE_STORE=beekeeper
```

## Usage

## DTO Showcase

```php



## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rhys Lees](https://github.com/RhysLees)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

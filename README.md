<img src="https://banners.beyondco.de/Laravel%20Beekeeper.png?theme=light&packageManager=composer+require&packageName=codebar-ag%2Flaravel-beekeeper&pattern=architect&style=style_1&description=An+opinionated+way+to+integrate+Beekeeper+with+Laravel&md=1&showWatermark=0&fontSize=100px&images=cloud">



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
    * [Get the connector](#get-the-connector)
    * [Get The Status Of The Authenticated User](#get-the-status-of-the-authenticated-user)
    * [List Artifacts](#list-artifacts)
    * [Upload A File](#upload-a-file)
    * [Create A Child To An Artifact](#create-a-child-to-an-artifact)
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

### Get the connector

```php
use CodebarAg\LaravelBeekeeper\Connectors\BeekeeperConnector;

// Using the env variables
$connector = new BeekeeperConnector;

// Passing the credentials manually
$connector = new BeekeeperConnector(
    apiToken: $yourApiToken,
    endpointPrefix: 'foobar.us',
);
```

### Get The Status Of The Authenticated User

```php
use CodebarAg\LaravelBeekeeper\Requests\GetStatusOfAuthenticatedUserRequest;

$response = $connector->send(new GetStatusOfAuthenticatedUserRequest);
````

### List Artifacts

```php
use CodebarAg\LaravelBeekeeper\Requests\ListArtifacts;

$response = $connector->send(new ListArtifacts(
    type: Type::FOLDER,
    sort: Sort::NAME_ASC,
    limit: 20,
));
```

### Upload A File

```php
use CodebarAg\LaravelBeekeeper\Requests\UploadAFileRequest;

$fileContent = file_get_contents('path-to/foobar.pdf');
$fileName = 'foobar.pdf';

$response = $connector->send(new UploadAFileRequest(
    fileContent: $fileContent,
    fileName: $fileName,
));
```

### Create A Child To An Artifact

```php
use CodebarAg\LaravelBeekeeper\Requests\CreateAChildToAnArtifact;
use CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type;

$response = $connector->send(new CreateAChildToAnArtifact(
    artifactId: '12345678-abcd-efgh-9012-de00edbf7b0b',
    name: 'foobar.pdf',
    type: Type::FILE,
    parentId: '12345678-abcd-efgh-9012-de00edbf7b0b',
    metadata: [
        'mimeType' => 'image/png',
        'url' => 'https://foobar.us.beekeeper.io/api/2/files/key/12345678-abcd-efgh-9012-de00edbf7b0b',
        'userId' => '12345678-abcd-efgh-9012-de00edbf7b0b',
        'key' => '12345678-abcd-efgh-9012-de00edbf7b0b',
        'id' => 12345678,
        'size' => 123456,
    ],
    adjustArtifactName: false,
    expand: []
));
```

## DTO Showcase

```php
CodebarAg\LaravelBeekeeper\Data\Artifacts\Artifact {
    +id: "12345678-abcd-efgh-9012-de00edbf7b0b"                         // string
    +tenantId: "12345"                                                  // string
    +name: "Documents"                                                  // string
    +type: CodebarAg\LaravelBeekeeper\Enums\Artifacts\Type              // Type
    +parentId: null                                                     // string|null
    +metadata: Illuminate\Support\Collection                            // Collection
    +createdAt: Carbon\CarbonImmutable                                  // CarbonImmutable
    +updatedAt: Carbon\CarbonImmutable                                  // CarbonImmutable
    +breadcrumbs: Illuminate\Support\Collection                         // Collection
    +children: Illuminate\Support\Collection                            // Collection
    +acl: Illuminate\Support\Collection                                 // Collection
    +filterData: Illuminate\Support\Collection                          // Collection
}
```

```php
CodebarAg\LaravelBeekeeper\Data\Configs\AuthenticatedUserStatus {
    +maxFileSize: 262144000                                             // int|null
    +maxFilesOnPost: 8                                                  // int|null
    +maxPhotoSize: 15728640                                             // int|null
    +maxMediaOnPost: 50                                                 // int|null
    +maxVideoSize: 524288000                                            // int|null
    +maxVideoSizeForAdmins: 2147483648                                  // int|null
    +maxVoiceRecordingLength: 900                                       // int|null
    +maxUsersInGroupChat: 200                                           // int|null
    +reactions: Illuminate\Support\Collection                           // Collection|null
    +featureFlags: Illuminate\Support\Collection                        // Collection|null
    +integrations: Illuminate\Support\Collection                        // Collection|null
    +styling: Illuminate\Support\Collection                             // Collection|null
    +tracking: Illuminate\Support\Collection                            // Collection|null   
    +general: CodebarAg\LaravelBeekeeper\Data\Configs\General           // General|null
}
```

```php
CodebarAg\LaravelBeekeeper\Data\Configs\General {
    +id: 12345                                                          // int
    +companyAccount: "12345678-abcd-efgh-9012-de00edbf7b0b"             // string
    +name: "foobar"                                                     // string
    +language: "en"                                                     // string
    +created: Carbon\CarbonImmutable                                    // CarbonImmutable
    +url: "https://foobar.us.beekeeper.io/"                             // string
    +tagline: "Welcome to Beekeeper!"                                   // string
    +fqdn: "foobar.us.beekeeper.io"                                     // string
    +supportEmail: ""                                                   // string
    +isDataSecurityContactSet: false                                    // bool
    +timezone: "Europe/London"                                          // string    
    +subdomain: "foobar"                                                // string
}
```

```php
CodebarAg\LaravelBeekeeper\Data\Configs\Reaction {
    +cldrShortName: "thumbs up"                                         // string
    +name: "Like"                                                       // string
    +emoji: "👍"                                                        // string
}
```

```php
CodebarAg\LaravelBeekeeper\Data\Files\File {
    +name: "test-1.pdf"                                                                               // string
    +status: CodebarAg\LaravelBeekeeper\Enums\Files\Status                                            // Status|null
    +created: Carbon\CarbonImmutable                                                                  // CarbonImmutable
    +updated: Carbon\CarbonImmutable                                                                  // CarbonImmutable
    +url: "https://foobar.us.beekeeper.io/api/2/files/key/12345678-abcd-efgh-9012-de00edbf7b0b"       // string
    +userId: "12345678-abcd-efgh-9012-de00edbf7b0b"                                                   // string
    +height: null                                                                                     // int|null
    +width: null                                                                                      // int|null
    +key: "12345678-abcd-efgh-9012-de00edbf7b0b"                                                      // string
    +duration: null                                                                                   // int|null
    +mediaType: "application/pdf"                                                                     // string
    +usageType: CodebarAg\LaravelBeekeeper\Enums\Files\UsageType                                      // UsageType
    +id: 22268153                                                                                     // int                                 
    +size: 8570                                                                                       // int
    +versions: Illuminate\Support\Collection                                                          // Collection
}
```

```php
CodebarAg\LaravelBeekeeper\Data\Files\FileVersion {
    +name: "test-1.pdf"                                                                               // string
    +url: "https://foobar.us.beekeeper.io/api/2/files/key/12345678-abcd-efgh-9012-de00edbf7b0b"      // string
    +height: null                                                                                     // int|null
    +width: null                                                                                      // int|null
}
```
    


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

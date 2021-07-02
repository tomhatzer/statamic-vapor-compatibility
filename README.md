# A package to make Statamic deployable on Laravel Vapor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tomhatzer/statamic-vapor-compatibility.svg?style=flat-square)](https://packagist.org/packages/tomhatzer/statamic-vapor-compatibility)
[![Total Downloads](https://img.shields.io/packagist/dt/tomhatzer/statamic-vapor-compatibility.svg?style=flat-square)](https://packagist.org/packages/tomhatzer/statamic-vapor-compatibility)

This package adds functionality to be able to run Statamic on Laravel Vapor using a container image.

## Installation

### Install the package via composer:

```bash
composer require tomhatzer/statamic-vapor-compatibility
```

### Publish the config file with:
```bash
php artisan vendor:publish --provider="StatamicVaporCompatibility\StatamicVaporCompatibilityServiceProvider" --tag="statamic-vapor-compatibility-config"
```

### Create a new personal access token on github for your account or organization

This is necessary to be able to pull and push from your private repository.

### Add a new private repository to your github account.

Please be sure to use a private repository as all your files including user files will be stored in this repository.

### Extend your stages environment variables on Laravel Vapor with the following variables:

```bash
STATAMIC_FILES_REPOSITORY=https://<personal-access-token-you-created-earlier>@github.com/<your-username-or-organization>/<name-of-private-repository-you-created-earlier>.git
STATAMIC_FILES_REPOSITORY_NAME=<name-of-the-folder-where-you-want-to-store-your-files>
STATAMIC_GIT_NAME=<your-git-user-name>
STATAMIC_GIT_EMAIL=<your-git-user-email>
```

### Execute the following command to update your Dockerfiles:

```bash
php artisan statamic-vapor:check-dockerfile
```

Please check your Dockerfile manually afterwards to see if there are any incompatible changes.

## Statamic addon compatibility

You can add Events and Listeners to your addon and ask your users to add them to our config file manually.

Please refer to the Events section in the [Statamic docs](https://statamic.dev/extending/events), the [Listeners](src/Listeners) folder and the [events config item](config/statamic-vapor-compatibility.php#L42) of this package to see how it's done.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tom Hatzer](https://github.com/tomhatzer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

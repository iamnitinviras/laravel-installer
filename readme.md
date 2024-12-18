# Laravel Web Installer | A Web Installer [Package](https://packagist.org/packages/iamnitinviras/laravel-installer)

[![Total Downloads](https://poser.pugx.org/iamnitinviras/laravel-installer/d/total.svg)](https://packagist.org/packages/iamnitinviras/laravel-installer)
[![Latest Stable Version](https://poser.pugx.org/iamnitinviras/laravel-installer/v/stable.svg)](https://packagist.org/packages/iamnitinviras/laravel-installer)
[![License](https://poser.pugx.org/iamnitinviras/laravel-installer/license.svg)](https://packagist.org/packages/iamnitinviras/laravel-installer)

- [About](#about)
- [Requirements](#requirements)
- [Installation](#installation)
- [Routes](#routes)
- [Usage](#usage)
- [Contributing](#contributing)
- [Help](#help)
- [Screenshots](#screenshots)
- [License](#license)

## About

Do you want your clients to be able to install a Laravel project just like they do with WordPress or any other CMS?
This Laravel package allows users who don't use Composer, SSH etc to install your application just by following the setup wizard.
The current features are :

- Check For Server Requirements.
- Check For Folders Permissions.
- Ability to set database information.
	- .env text editor
	- .env form wizard
- Migrate The Database.
- Seed The Tables.

## Requirements

* [Laravel 11.x](https://laravel.com/docs/11.x/installation)

## Installation

1. From your projects root folder in terminal run:

```bash
    composer require iamnitinviras/laravel-installer
```

2. Register the package

* Laravel 11.x
Register the package with laravel in `bootstrap/providers.php` add the following:

```php
	IamNitinViras\LaravelInstaller\Providers\LaravelInstallerServiceProvider::class
```

3. Publish the packages views, config file, assets, and language files by running the following from your projects root folder:

```bash
    php artisan vendor:publish --tag=laravelinstaller
```

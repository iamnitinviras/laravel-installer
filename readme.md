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

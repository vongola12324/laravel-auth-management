# laravel-auth-management
An advanced auth management mechanism for laravel 5.6.

## Feature
- Force logout all device for specify user
- An user can only have one session at the same time (No multiple login)
- Logging login/logout event

## Install
First, add dependence to your project.
```bash
composer require vongola12324/laravel-auth-management
```
Then, publish config file to your project.  
```bash
php artisan vendor:publish --provider="Vongola\Auth\Providers\AuthManagementServiceProvider"
```

## License
This project is license by MIT.

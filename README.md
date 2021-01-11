# Laravel Auth

Module for authenticate a user before accessing the application.

## Installation

This package can be installed through Composer.

``` bash
composer require akkurate/laravel-auth
```

Optionally, you can: 

Publish the views with this command:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelAuth\LaravelAuthServiceProvider" --tag="views"
```

Publish as well the config file with this command:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelAuth\LaravelAuthServiceProvider" --tag="config"
```

Publish the sass with this command:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelAuth\LaravelAuthServiceProvider" --tag="sass"
```

## Utilisation

You can customize the email address verification by an insert of this method inside your User model.

```
public function sendEmailVerificationNotification()
{
    $this->notify(new \Akkurate\LaravelAuth\Notifications\VerifyEmailNotification());
}
```


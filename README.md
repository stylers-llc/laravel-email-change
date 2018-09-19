[![Build Status](https://travis-ci.org/stylers-llc/laravel-email-change.svg?branch=master)](https://travis-ci.org/stylers-llc/laravel-email-change)

# Laravel Email Change (non-released)

## TODO
- [ ] Release
- [ ] Publish on [Packagist](https://packagist.org/)

## Requirements
- PHP >= 7.1.3
- Laravel ~5.x
- stylers/laravel-email-verification

## Installation
```bash
composer require stylers/laravel-email-change
```

## Publish the config of email verification package
```bash
php artisan vendor:publish --provider="Stylers\EmailVerification\Frameworks\Laravel\ServiceProvider"
```

## Run the migrations
```bash
php artisan migrate
```

## Usage

### Set up the abstraction
```php
use Illuminate\Database\Eloquent\Model;
use Stylers\EmailVerification\NotifiableInterface;
use Illuminate\Notifications\Notifiable;
use Stylers\EmailVerification\EmailVerifiableInterface;
use Stylers\EmailVerification\Frameworks\Laravel\Models\Traits\EmailVerifiable;
use Stylers\EmailChange\Contracts\EmailChangeableInterface;
use Stylers\EmailChange\Models\Traits\EmailChangeable;

class User extends Model implements NotifiableInterface, EmailVerifiableInterface, EmailChangeableInterface
{
    use Notifiable;
    use EmailVerifiable;
    use EmailChangeable;
    ...
    
    public function getName(): string
    {
        return (string)$this->name;
    }
}
```

### Create change request 
```php
$emailChangeableUser = User::first();
$changeRequestInstance = $emailChangeableUser->createEmailChangeRequest($newEmail);
```

### Finish change request

This package requires __Laravel Email Verification__ package and the ChangeEmail listener handle it's VerificationSuccess event. If you want to finish change request, you have to implement email-verification route. Read more: https://github.com/stylers-llc/laravel-email-verification#example-of-verification

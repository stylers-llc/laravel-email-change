<?php

namespace Stylers\EmailChange;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;
use Stylers\EmailChange\Models\EmailChangeRequest;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        Event::listen(
            'Stylers\EmailChange\Events\EmailChangeRequestCreated',
            'Stylers\EmailChange\Listeners\SendEmailVerificationEmail'
        );
        Event::listen(
            'Stylers\EmailVerification\Frameworks\Laravel\Events\VerificationSuccess',
            'Stylers\EmailChange\Listeners\ChangeEmail'
        );
    }

    public function register()
    {
        $this->app->bind(EmailChangeRequestInterface::class, EmailChangeRequest::class);
    }
}

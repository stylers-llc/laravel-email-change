<?php

namespace Stylers\EmailChange\Tests;

use Mockery;
use Stylers\EmailVerification\EmailVerificationServiceInterface;
use Stylers\EmailVerification\Frameworks\Laravel\Models\EmailVerificationRequest;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(EmailVerificationServiceInterface::class, function ($app) {
            $verificationRequest = new EmailVerificationRequest();
            $mock = Mockery::mock(EmailVerificationServiceInterface::class);
            $mock->shouldReceive('createEmailVerificationRequest')
                ->andReturn($verificationRequest);
            $mock->shouldReceive('sendNotification')
                ->andReturnUndefined();
            return $mock;
        });
    }
}

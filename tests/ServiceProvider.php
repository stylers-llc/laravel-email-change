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
            $verificationRequest->setToken('test-token');
            $mock = Mockery::mock(EmailVerificationServiceInterface::class);
            $mock->shouldReceive('createRequest')
                ->andReturn($verificationRequest);
            $mock->shouldReceive('sendEmail')
                ->andReturnUndefined();
            return $mock;
        });
    }
}

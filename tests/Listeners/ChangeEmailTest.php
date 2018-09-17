<?php

namespace Stylers\EmailChange\Tests\Listeners;

use Stylers\EmailChange\Listeners\ChangeEmail;
use Stylers\EmailChange\Models\EmailChangeRequest;
use Stylers\EmailChange\Models\User;
use Stylers\EmailChange\Tests\BaseTestCase;
use Stylers\EmailVerification\Frameworks\Laravel\Events\VerificationSuccess;
use Stylers\EmailVerification\Frameworks\Laravel\Models\EmailVerificationRequest;

class ChangeEmailTest extends BaseTestCase
{
    /** @test */
    public function it_can_handle_the_event()
    {
        $oldEmail = 'old@mail.com';
        $expectedNewEmail = 'new@mail.com';

        $user = factory(User::class)->create(['email' => $oldEmail]);
        /** @var EmailChangeRequest $emailChangeRequest */
        $emailChangeRequest = factory(EmailChangeRequest::class)->make(['email' => $expectedNewEmail]);
        $emailChangeRequest->emailChangeable()->associate($user)->save();

        $verificationRequest = new EmailVerificationRequest();
        $verificationRequest->setEmail($expectedNewEmail);
        $verificationRequest->setType($emailChangeRequest->getVerificationType());

        /** @var ChangeEmail $listener */
        $listener = app(ChangeEmail::class);
        $listener->handle(new VerificationSuccess($verificationRequest));
        $user->refresh();

        $this->assertEquals($expectedNewEmail, $user->email);
    }
}

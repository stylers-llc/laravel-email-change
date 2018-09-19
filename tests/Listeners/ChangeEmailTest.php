<?php

namespace Stylers\EmailChange\Tests\Listeners;

use PHPUnit\Framework\MockObject\MockObject;
use Stylers\EmailChange\Listeners\ChangeEmail;
use Stylers\EmailChange\Models\EmailChangeRequest;
use Stylers\EmailChange\Models\User;
use Stylers\EmailChange\Tests\BaseTestCase;
use Stylers\EmailVerification\Frameworks\Laravel\Events\VerificationSuccess;
use Stylers\EmailVerification\Frameworks\Laravel\Models\EmailVerificationRequest;
use Stylers\EmailVerification\EmailVerifiableInterface;

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

        $verificationRequest = $this->mockVerificationRequest($expectedNewEmail, $emailChangeRequest);

        /** @var ChangeEmail $listener */
        $listener = app(ChangeEmail::class);
        $listener->handle(new VerificationSuccess($verificationRequest));
        $user->refresh();

        $this->assertEquals($expectedNewEmail, $user->email);
    }

    /**
     * @param $expectedNewEmail
     * @param $emailChangeRequest
     * @return MockObject|EmailVerificationRequest
     */
    private function mockVerificationRequest(
        string $expectedNewEmail,
        EmailVerifiableInterface $emailChangeRequest
    ): MockObject
    {
        $mockRequest = $this->createMock(EmailVerificationRequest::class);
        $mockRequest->method('getEmail')->willReturn($expectedNewEmail);
        $mockRequest->method('getType')->willReturn($emailChangeRequest->getVerificationType());
        $mockRequest->method('save')->willReturn(true);
        return $mockRequest;
    }

}

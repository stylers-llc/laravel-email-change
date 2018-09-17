<?php

namespace Stylers\EmailChange\Listeners;

use Stylers\EmailChange\Events\EmailChangeRequestCreated;
use Stylers\EmailVerification\EmailVerificationServiceInterface;
use Stylers\EmailVerification\Frameworks\Laravel\EmailVerificationService;

class SendEmailVerificationEmail
{
    /**
     * @param EmailChangeRequestCreated $event
     * @throws \Stylers\EmailVerification\Exceptions\AlreadyVerifiedException
     */
    public function handle(EmailChangeRequestCreated $event)
    {
        $emailChangeRequest = $event->getEmailChangeRequest();
        $changeable = $emailChangeRequest->emailChangeable()->first();

        /** @var EmailVerificationService $verificationService */
        $verificationService = app(EmailVerificationServiceInterface::class);
        $verificationRequest = $verificationService
            ->createRequest($emailChangeRequest->email, $emailChangeRequest->getVerificationType());
        $verificationService->sendEmail($verificationRequest->getToken(), $changeable);
    }
}

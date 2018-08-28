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
        /** @var EmailVerificationService $verificationService */
        $verificationService = app(EmailVerificationServiceInterface::class);
        $verificationRequest = $verificationService->createEmailVerificationRequest($emailChangeRequest);
        $verificationService->sendNotification($verificationRequest);
    }
}

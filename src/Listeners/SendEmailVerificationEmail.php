<?php

namespace Stylers\EmailChange\Listeners;

use Stylers\EmailChange\Events\EmailChangeRequestCreating;
use Stylers\EmailVerification\EmailVerificationServiceInterface;
use Stylers\EmailVerification\Frameworks\Laravel\EmailVerificationService;

class SendEmailVerificationEmail
{
    /**
     * @param EmailChangeRequestCreating $event
     * @throws \Stylers\EmailVerification\Exceptions\AlreadyVerifiedException
     */
    public function handle(EmailChangeRequestCreating $event)
    {
        $emailChangeRequest = $event->getEmailChangeRequest();
        /** @var EmailVerificationService $verificationService */
        $verificationService = app(EmailVerificationServiceInterface::class);
        $verificationRequest = $verificationService->createEmailVerificationRequest($emailChangeRequest);
        $verificationService->sendNotification($verificationRequest);
    }
}

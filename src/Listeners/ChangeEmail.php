<?php

namespace Stylers\EmailChange\Listeners;

use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;
use Stylers\EmailVerification\EmailVerificationRequestInterface;
use Stylers\EmailVerification\Frameworks\Laravel\Events\VerificationSuccess;

class ChangeEmail
{
    /**
     * @param $event
     */
    public function handle(VerificationSuccess $event)
    {
        /** @var EmailVerificationRequestInterface $verificationRequest */
        $verificationRequest = $event->getVerificationRequest();

        /** @var EmailChangeRequestInterface $emailChangeRequest */
        $emailChangeRequest = $verificationRequest->getVerifiable();
        if ($emailChangeRequest instanceof EmailChangeRequestInterface) {
            $emailChangeRequest->persistChangeableEmail();
        }
    }
}

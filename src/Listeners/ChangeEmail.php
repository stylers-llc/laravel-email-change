<?php

namespace Stylers\EmailChange\Listeners;

use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;
use Stylers\EmailChange\Models\EmailChangeRequest;
use Stylers\EmailVerification\EmailVerificationRequestInterface;
use Stylers\EmailVerification\Frameworks\Laravel\Events\VerificationSuccess;

class ChangeEmail
{
    /**
     * @var EmailChangeRequestInterface
     */
    private $changeRequestDAO;

    public function __construct()
    {
        $this->changeRequestDAO = app(EmailChangeRequestInterface::class);
    }

    /**
     * @param $event
     */
    public function handle(VerificationSuccess $event)
    {
        /** @var EmailVerificationRequestInterface $verificationRequest */
        $verificationRequest = $event->getVerificationRequest();

        /** @var EmailChangeRequest[] $emailChangeRequests */
        $emailChangeRequests = $this->changeRequestDAO->where('email', $verificationRequest->getEmail())->get();
        foreach ($emailChangeRequests as $emailChangeRequest) {
            if ($verificationRequest->getType() === $emailChangeRequest->getVerificationType()) {
                $emailChangeRequest->persistChangeableEmail();
            }
        }
    }
}

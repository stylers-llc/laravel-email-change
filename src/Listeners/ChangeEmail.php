<?php

namespace Stylers\EmailChange\Listeners;

use Stylers\EmailChange\Models\EmailChangeRequest;
use Stylers\EmailVerification\EmailVerifiableInterface;
use Stylers\EmailVerification\EmailVerificationRequestInterface;
use Stylers\EmailVerification\EmailVerificationServiceInterface;
use Stylers\EmailVerification\Frameworks\Laravel\Events\VerificationSuccess;

class ChangeEmail
{
    /**
     * @var EmailChangeRequest
     */
    private $changeRequestDAO;
    /**
     * @var EmailVerificationServiceInterface
     */
    private $emailVerificationService;

    public function __construct(
        EmailChangeRequest $emailChangeRequestDAO,
        EmailVerificationServiceInterface $emailVerificationService
    )
    {
        $this->changeRequestDAO = $emailChangeRequestDAO;
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * @param $event
     */
    public function handle(VerificationSuccess $event)
    {
        /** @var EmailVerificationRequestInterface $verificationRequest */
        $verificationRequest = $event->getVerificationRequest();

        /** @var EmailChangeRequest[] $emailChangeRequests */
        $emailChangeRequests = $this->changeRequestDAO
            ->where('email', $verificationRequest->getEmail())
            ->get();
        foreach ($emailChangeRequests as $emailChangeRequest) {
            if ($verificationRequest->getType() === $emailChangeRequest->getVerificationType()) {
                /** @var EmailVerifiableInterface $emailChangeable */
                $emailChangeable = $emailChangeRequest->emailChangeable()->first();
                if ($emailChangeable) {
                    $this->emailVerificationService->invalidateRequest(
                        $emailChangeable->email,
                        $emailChangeable->getVerificationType()
                    );
                    $verificationRequest->setType($emailChangeable->getVerificationType());
                    $verificationRequest->save();
                    $emailChangeRequest->persistChangeableEmail();
                }
            }
        }
    }
}

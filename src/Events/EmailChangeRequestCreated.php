<?php

namespace Stylers\EmailChange\Events;

use Illuminate\Queue\SerializesModels;
use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;

class EmailChangeRequestCreated
{
    use SerializesModels;

    /**
     * @var EmailChangeRequestInterface
     */
    private $emailChangeRequest;

    public function __construct(EmailChangeRequestInterface $emailChangeRequest)
    {
        $this->emailChangeRequest = $emailChangeRequest;
    }

    /**
     * @return EmailChangeRequestInterface
     */
    public function getEmailChangeRequest(): EmailChangeRequestInterface
    {
        return $this->emailChangeRequest;
    }
}

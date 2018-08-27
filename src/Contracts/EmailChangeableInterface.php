<?php

namespace Stylers\EmailChange\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface EmailChangeableInterface
{
    /**
     * @return MorphMany
     */
    public function emailChangeRequests(): MorphMany;

    /**
     * @param string $newEmail
     * @return EmailChangeRequestInterface
     */
    public function createEmailChangeRequest(string $newEmail): EmailChangeRequestInterface;
}
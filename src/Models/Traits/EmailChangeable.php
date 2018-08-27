<?php

namespace Stylers\EmailChange\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;

trait EmailChangeable
{
    /**
     * @return MorphMany
     */
    public function emailChangeRequests(): MorphMany
    {
        return $this->morphMany(app(EmailChangeRequestInterface::class), 'email_changeable');
    }

    /**
     * @param string $newEmail
     * @return EmailChangeRequestInterface|Model
     */
    public function createEmailChangeRequest(string $newEmail): EmailChangeRequestInterface
    {
        return $this->emailChangeRequests()->create(['email' => $newEmail]);
    }
}
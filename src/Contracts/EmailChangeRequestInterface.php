<?php

namespace Stylers\EmailChange\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Stylers\EmailVerification\Frameworks\Laravel\Contracts\EmailVerifiableInterface;

interface EmailChangeRequestInterface extends EmailVerifiableInterface
{
    /**
     * @return MorphTo
     */
    public function emailChangeable(): MorphTo;

    public function persistChangeableEmail(): void;
}
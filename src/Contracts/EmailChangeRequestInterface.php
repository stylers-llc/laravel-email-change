<?php

namespace Stylers\EmailChange\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface EmailChangeRequestInterface
{
    /**
     * @return MorphTo
     */
    public function emailChangeable(): MorphTo;

    public function persistChangeableEmail(): void;

    public function getVerificationType(): ?string;
}
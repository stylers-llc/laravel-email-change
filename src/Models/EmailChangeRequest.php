<?php

namespace Stylers\EmailChange\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;
use Stylers\EmailChange\Events\EmailChangeRequestCreating;
use Stylers\EmailVerification\Frameworks\Laravel\Models\Traits\EmailVerifiable;

class EmailChangeRequest extends Model implements EmailChangeRequestInterface
{
    use EmailVerifiable;

    protected $fillable = [
        'email'
    ];

    protected $dispatchesEvents = [
        'creating' => EmailChangeRequestCreating::class
    ];

    public function emailChangeable(): MorphTo
    {
        return $this->morphTo('email_changeable');
    }

    public function persistChangeableEmail(): void
    {
        $changeable = $this->emailChangeable()->first();
        $changeable->email = $this->email;
        $changeable->save();
    }
}
<?php

namespace Stylers\EmailChange\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stylers\EmailChange\Contracts\EmailChangeRequestInterface;
use Stylers\EmailChange\Events\EmailChangeRequestCreated;
use Stylers\EmailVerification\EmailVerifiableInterface;
use Stylers\EmailVerification\Frameworks\Laravel\Models\Traits\EmailVerifiable;

class EmailChangeRequest extends Model implements EmailChangeRequestInterface, EmailVerifiableInterface
{
    use EmailVerifiable;
    use SoftDeletes;

    protected $fillable = [
        'email'
    ];

    protected $dispatchesEvents = [
        'created' => EmailChangeRequestCreated::class
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

    public function getVerifiableName(): string
    {
        return $this->emailChangeable()->first()->name;
    }

    public function getVerificationType(): ?string
    {
        return self::class . '#' . $this->id;
    }
}

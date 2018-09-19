<?php

namespace Stylers\EmailChange\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Stylers\EmailChange\Contracts\EmailChangeableInterface;
use Stylers\EmailChange\Models\Traits\EmailChangeable;
use Stylers\EmailVerification\EmailVerifiableInterface;
use Stylers\EmailVerification\Frameworks\Laravel\Models\Traits\EmailVerifiable;
use Stylers\EmailVerification\NotifiableInterface;

class User extends Model implements EmailChangeableInterface, NotifiableInterface, EmailVerifiableInterface
{
    use Notifiable;
    use EmailChangeable;
    use EmailVerifiable;

    public function getName(): string
    {
        return (string)$this->name;
    }
}
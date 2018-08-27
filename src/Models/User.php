<?php

namespace Stylers\EmailChange\Models;

use Illuminate\Database\Eloquent\Model;
use Stylers\EmailChange\Contracts\EmailChangeableInterface;
use Stylers\EmailChange\Models\Traits\EmailChangeable;

class User extends Model implements EmailChangeableInterface
{
    use EmailChangeable;
}
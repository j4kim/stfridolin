<?php

namespace App\Exceptions;

use Exception;

class NoGuestException extends Exception
{
    protected $message = "Vous n'êtes pas authentifié";
}

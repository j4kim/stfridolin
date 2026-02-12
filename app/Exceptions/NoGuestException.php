<?php

namespace App\Exceptions;

use Exception;

class NoGuestException extends Exception
{
    protected $message = "On ne sait pas qui vous êtes. Veuillez re-scanner votre carte.";
}

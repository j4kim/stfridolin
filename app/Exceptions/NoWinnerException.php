<?php

namespace App\Exceptions;

use Exception;

class NoWinnerException extends Exception
{
    protected $message = "Il n'y a pas de vainqueur";
}

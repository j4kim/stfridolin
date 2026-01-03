<?php

namespace App\Exceptions;

use Exception;

class NoWinnerException extends Exception
{
    protected $message = "No winner";
}

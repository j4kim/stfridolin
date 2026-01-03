<?php

namespace App\Exceptions;

use Exception;

class FightEndedException extends Exception
{
    protected $message = "This fight is ended";
}

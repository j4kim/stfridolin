<?php

namespace App\Exceptions;

use Exception;

class FightNotEndedException extends Exception
{
    protected $message = "Current fight is not ended";
}

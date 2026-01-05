<?php

namespace App\Exceptions;

use Exception;

class NoCurrentFightException extends Exception
{
    protected $message = "Il n'y a pas combat en cours";
}

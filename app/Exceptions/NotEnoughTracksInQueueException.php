<?php

namespace App\Exceptions;

use Exception;

class NotEnoughTracksInQueueException extends Exception
{
    protected $message = "There are no 2 candidates";
}

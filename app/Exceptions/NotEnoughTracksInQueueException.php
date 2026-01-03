<?php

namespace App\Exceptions;

use Exception;

class NotEnoughTracksInQueueException extends Exception
{
    protected $message = "Il n'y a pas assez de morceaux en file d'attente";
}

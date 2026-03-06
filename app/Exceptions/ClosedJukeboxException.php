<?php

namespace App\Exceptions;

use Exception;

class ClosedJukeboxException extends Exception
{
    protected $message = "Le Jukeboxe est fermé, pas de nouvelle chanson possible";
}

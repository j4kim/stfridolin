<?php

namespace App\Exceptions;

use Exception;

class FightEndedException extends Exception
{
    protected $message = "Le combat est terminé";
}

<?php

namespace App\Exceptions;

use Exception;

class FightNotEndedException extends Exception
{
    protected $message = "Le combat n'est pas terminé";
}

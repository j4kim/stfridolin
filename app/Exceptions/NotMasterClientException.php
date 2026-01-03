<?php

namespace App\Exceptions;

use Exception;

class NotMasterClientException extends Exception
{
    protected $message = "Le client n'est pas master";
}

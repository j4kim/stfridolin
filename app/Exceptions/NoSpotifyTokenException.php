<?php

namespace App\Exceptions;

use Exception;

class NoSpotifyTokenException extends Exception
{
    protected $message = "Il n'y a pas de token Spotify";
}

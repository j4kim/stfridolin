<?php

namespace App\Exceptions;

use Exception;

class NoSpotifyTokenException extends Exception
{
    protected $message = 'No Spotify Token, you must first login to Spotify';
}

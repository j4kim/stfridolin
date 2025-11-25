<?php

namespace App\Exceptions;

use Exception;

class NoSpotifyPlaybackException extends Exception
{
    protected $message = 'Playback not available or active';
}

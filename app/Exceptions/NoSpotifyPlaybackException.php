<?php

namespace App\Exceptions;

use Exception;

class NoSpotifyPlaybackException extends Exception
{
    protected $message = "Il n'y a pas de playback Spotify actif";
}

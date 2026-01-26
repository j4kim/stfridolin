<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function get(string $key)
    {
        $guest = Guest::where('key', $key)->firstOrFail();
        return $guest;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return Guest::all();
    }

    public function get(string $key)
    {
        $guest = Guest::where('key', $key)->firstOrFail();
        return $guest;
    }

    public function storeMany(Request $request)
    {
        $guests = collect();
        foreach ($request->names as $name) {
            $guests->push(Guest::create(['name' => $name]));
        }
        return $guests;
    }
}

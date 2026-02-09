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
        $guests = [];
        foreach ($request->names as $name) {
            $guests[] = Guest::create([
                'name' => $name,
                'key' => str()->random(4),
                'tokens' => 20,
            ]);
        }
        return $guests;
    }
}

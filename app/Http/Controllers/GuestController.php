<?php

namespace App\Http\Controllers;

use App\Enums\MovementType;
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
        if (!$guest->authenticated_at) {
            $guest->authenticated_at = now();
            $guest->save();
        }
        return $guest;
    }

    public function movements()
    {
        $guest = Guest::fromRequest();
        return $guest->movements()->latest()->get();
    }

    public function storeMany(Request $request)
    {
        $names = $request->collect('names');
        $guests = $names->map(fn(string $name) => Guest::create(['name' => $name]));
        return $guests;
    }

    public function spend(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|gt:0',
            'currency' => 'required|in:tokens,points'
        ]);
        $currency = $request->currency;
        $amount = +$request->amount;
        $guest = Guest::fromRequest();
        if ($guest->$currency < $amount) {
            abort(400, "Vous n'avez pas assez de " . __($currency));
        }
        return $guest->createMovement([
            $currency => -$amount,
            'type' => MovementType::Manual,
            'meta' => ['source' => 'self-service'],
        ]);
    }
}

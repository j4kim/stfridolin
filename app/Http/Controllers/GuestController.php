<?php

namespace App\Http\Controllers;

use App\Enums\ArticleType;
use App\Enums\GuestType;
use App\Enums\MovementType;
use App\Models\Article;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return Guest::where('type', '!=', GuestType::Patron)->orderBy('name')->get();
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

    public function movements(Request $request)
    {
        $guest = Guest::fromRequest();
        return $guest->movements()
            ->with($request->input('with', []))
            ->latest()
            ->get();
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
        $article = $request->articleId ? Article::findOrFail($request->articleId) : null;
        $type = $article?->type === ArticleType::Participation ? MovementType::GameParticipation : MovementType::Manual;
        return $guest->createMovement([
            $currency => -$amount,
            'type' => $type,
            'article_id' => $request->articleId,
            'game_id' => $article?->game_id,
            'meta' => ['source' => 'self-service'],
        ]);
    }
}

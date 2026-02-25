<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Competitor;
use App\Models\Guest;
use App\Models\Occurrence;
use Illuminate\Http\Request;

class OccurrenceController extends Controller
{
    public function bet(Occurrence $occurrence, Competitor $competitor, Request $request)
    {
        $request->validate([
            "articleName" => "required|string",
        ]);
        $article = Article::where('name', $request->articleName)->firstOrFail();
        $guest = Guest::fromRequest();
        $movement = $guest->betOn($occurrence, $competitor, $article);
        return [
            "movement" => $movement,
            "message" => "Pari placé",
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\OccurrenceStatus;
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
        if ($occurrence->status !== OccurrenceStatus::Open) {
            abort(400, "Les paris sont fermés pour cette course");
        }
        $article = Article::where('name', $request->articleName)->firstOrFail();
        $guest = Guest::fromRequest();
        $movement = $guest->betOn($occurrence, $competitor, $article);
        return [
            "movement" => $movement,
            "message" => "Pari placé",
        ];
    }

    public function start(Occurrence $occurrence, Request $request)
    {
        if ($occurrence->status !== OccurrenceStatus::Open) {
            abort(400, "La course doit être ouverte");
        }
        $occurrence->status = OccurrenceStatus::Started;
        $occurrence->save();
        return [
            "occurrence" => $occurrence,
            "message" => "Course démarrée",
        ];
    }

    public function setRanking(Occurrence $occurrence, Request $request)
    {
        $request->validate([
            "ranking" => "required|array",
            "ranking.*" => "required|integer",
        ]);
        if ($occurrence->status !== OccurrenceStatus::Started) {
            abort(400, "La course doit être commencée");
        }
        $occurrence->ranking = $request->ranking;
        $occurrence->status = OccurrenceStatus::Ranked;
        $occurrence->save();
        return [
            "occurrence" => $occurrence,
            "message" => "Classement enregistré",
        ];
    }
}

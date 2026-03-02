<?php

namespace App\Http\Controllers;

use App\Enums\MovementType;
use App\Enums\OccurrenceStatus;
use App\Models\Article;
use App\Models\Competitor;
use App\Models\Game;
use App\Models\Guest;
use App\Models\Occurrence;
use Illuminate\Http\Request;

class OccurrenceController extends Controller
{
    public function get(Occurrence $occurrence, Request $request)
    {
        $bets = $occurrence->bets()->with('guest')->get();
        foreach ($occurrence->competitors as $competitor) {
            $competitor->bettors = $bets->where('competitor_id', $competitor->id)
                ->map(fn($bet) => $bet->guest->name)
                ->values();
        }
        if ($request->withBets) {
            $occurrence->bets = $bets;
        }
        return $occurrence;
    }

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

    public function participate(Occurrence $occurrence, Request $request)
    {
        $request->validate([
            "articleName" => "required|string",
        ]);
        /** @var OccurrenceStatus $status */
        $status = $occurrence->status;
        if ($status->isClosed()) {
            abort(400, "Ce jeu est " . $status->getLabel());
        }
        $article = Article::where('name', $request->articleName)->firstOrFail();
        $guest = Guest::fromRequest();
        if ($article->meta && $article->meta['participationLimit']) {
            $existingParticipations = $guest->movements()
                ->where('type', MovementType::GameParticipation)
                ->where('article_id', $article->id)
                ->where('occurrence_id', $occurrence->id);
            if ($existingParticipations->count() >= $article->meta['participationLimit']) {
                abort(400, "Tu as atteins la limite de participations");
            }
        }
        $movement = $guest->createMovement([
            'article_id' => $article->id,
            'game_id' => $occurrence->game_id,
            'occurrence_id' => $occurrence->id,
            'type' => MovementType::GameParticipation,
            'tokens' => -$article->price,
            'meta' => $request->meta,
        ]);
        return [
            "movement" => $movement,
            "message" => "Pari placé",
        ];
    }

    public function open(Occurrence $occurrence, Request $request)
    {
        $occurrence->status = OccurrenceStatus::Open;
        $occurrence->save();
        return [
            "occurrence" => $occurrence,
            "message" => "Paris ouverts",
        ];
    }

    public function startAll(int $gameId)
    {
        $game = Game::findOrFail($gameId);
        foreach ($game->occurrences as $occurrence) {
            $occurrence->status = OccurrenceStatus::Started;
            $occurrence->save();
        }
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
        $points = @$occurrence->meta['points'];
        if (!$points) {
            abort(500, "Le nombre de points à distribuer n'est pas spécifié dans les métadonnées de l'occurrence");
        }
        $occurrence->ranking = $request->ranking;
        $betMvmts = $occurrence->bets()->with('guest');
        foreach ($occurrence->ranking as $competitorId => $rank) {
            if ($rank !== 1) continue;
            $bets = $betMvmts->where('competitor_id', $competitorId)->get();
            if (!$bets->count()) continue;
            $pointsPerEach = ceil($points / $bets->count());
            foreach ($bets as $bet) {
                $bet->points = $pointsPerEach;
                $bet->save();
                $bet->guest->recomputeTokensAndPoints()->save();
            }
        }
        $occurrence->status = OccurrenceStatus::Ranked;
        $occurrence->save();
        return [
            "occurrence" => $occurrence,
            "message" => "Classement enregistré",
        ];
    }

    public function finish(Occurrence $occurrence, Request $request)
    {
        $occurrence->meta = array_merge(
            $occurrence->meta,
            $request->input('meta', []),
        );
        $occurrence->status = OccurrenceStatus::Finished;
        $occurrence->save();
        return [
            "occurrence" => $occurrence,
            "message" => "Jeu terminé",
        ];
    }
}

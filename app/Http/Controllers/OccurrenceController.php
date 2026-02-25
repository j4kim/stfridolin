<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\Occurrence;
use Illuminate\Http\Request;

class OccurrenceController extends Controller
{
    public function bet(Occurrence $occurrence, Competitor $competitor)
    {
        sleep(1);
        return compact("occurrence", "competitor");
    }
}

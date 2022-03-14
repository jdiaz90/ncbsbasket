<?php

namespace App\Http\Controllers;

use App\Models\PlayoffRound;
use Illuminate\Http\Request;

class PlayoffRoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consult = PlayoffRound::select('Season')
        ->orderByDesc('Season', 'desc')
        ->limit(1)
        ->get();

        $year = $consult[0]->Season;

        $season = ['Year' => $year];

        $seasons = PlayoffRound::select('Season')
        ->distinct()
        ->get()
        ->sortByDesc('Season');

        $r1w = PlayoffRound::where('Season', $year)
        ->where('Round', 1)
        ->where('HomeConf', 2)
        ->get()
        ->sortBy('HomeSeed');

        $r2w = PlayoffRound::where('Season', $year)
        ->where('Round', 2)
        ->where('HomeConf', 2)
        ->get()
        ->sortBy('HomeSeed');

        $r3w = PlayoffRound::where('Season', $year)
        ->where('Round', 3)
        ->where('HomeConf', 2)
        ->get()
        ->sortBy('HomeSeed');

        $r1e = PlayoffRound::where('Season', $year)
        ->where('Round', 1)
        ->where('HomeConf', 1)
        ->get()
        ->sortBy('HomeSeed');

        $r2e = PlayoffRound::where('Season', $year)
        ->where('Round', 2)
        ->where('HomeConf', 1)
        ->get()
        ->sortBy('HomeSeed');

        $r3e = PlayoffRound::where('Season', $year)
        ->where('Round', 3)
        ->where('HomeConf', 1)
        ->get()
        ->sortBy('HomeSeed');

        $final = PlayoffRound::where('Season', $year)
        ->where('Round', 4)
        ->get()
        ->sortBy('HomeSeed');

        $season = ['Year' => $year];

        $seasons = PlayoffRound::select('Season')
        ->distinct()
        ->get()
        ->sortByDesc('Season');

        return view("playoffrounds", compact(
        "r1w",
        "r2w",
        "r3w",
        "r1e",
        "r2e",
        "r3e",
        "final",
        "season", 
        "seasons"));
    }

    public function show($year)
    {
        $r1w = PlayoffRound::where('Season', $year)
        ->where('Round', 1)
        ->where('HomeConf', 2)
        ->get()
        ->sortBy('HomeSeed');

        $r2w = PlayoffRound::where('Season', $year)
        ->where('Round', 2)
        ->where('HomeConf', 2)
        ->get()
        ->sortBy('HomeSeed');

        $r3w = PlayoffRound::where('Season', $year)
        ->where('Round', 3)
        ->where('HomeConf', 2)
        ->get()
        ->sortBy('HomeSeed');

        $r1e = PlayoffRound::where('Season', $year)
        ->where('Round', 1)
        ->where('HomeConf', 1)
        ->get()
        ->sortBy('HomeSeed');

        $r2e = PlayoffRound::where('Season', $year)
        ->where('Round', 2)
        ->where('HomeConf', 1)
        ->get()
        ->sortBy('HomeSeed');

        $r3e = PlayoffRound::where('Season', $year)
        ->where('Round', 3)
        ->where('HomeConf', 1)
        ->get()
        ->sortBy('HomeSeed');

        $final = PlayoffRound::where('Season', $year)
        ->where('Round', 4)
        ->get()
        ->sortBy('HomeSeed');

        $season = ['Year' => $year];

        $seasons = PlayoffRound::select('Season')
        ->distinct()
        ->get()
        ->sortByDesc('Season');

        return view("playoffrounds", compact(
        "r1w",
        "r2w",
        "r3w",
        "r1e",
        "r2e",
        "r3e",
        "final",
        "season", 
        "seasons"));
    }

}

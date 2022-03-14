<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Player;
use App\Models\SeasonStat;

class FormerPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("/player");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SeasonStats  $player
     * @return \Illuminate\Http\Response
     */
    public function show($player)
    {

        $players = Player::select("PlayerID")
        ->where("UniqueID", $player)
        ->get();

        if($players->count() > 0)
            return redirect("/player/" . $players[0]->PlayerID);
        
        $stats = SeasonStat::where("PlayerID", $player)
        ->orderBy('Key', 'desc')
        ->get();

        $awards = Award::where("PlayerID", $player)
        ->orderBy('Key', 'desc')
        ->get();

        if($stats->count() > 0)
            return view('former_player', compact('stats', 'awards'));
        return abort(404);
        
    }

}
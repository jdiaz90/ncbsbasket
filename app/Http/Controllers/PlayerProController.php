<?php

namespace App\Http\Controllers;

use App\Models\Player;
use ErrorException;

class PlayerProController extends Controller
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
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show($player)
    {

        $player = Player::findorfail($player);

        $player['Transactions'] = $player->transactionsHistory();

        $player['Awards'] = $player->awardsWon();

        try {

            $teamColor = $player->team->TeamColor;
            $franchise = $player->franchise;
        
        } catch(ErrorException $e){
            $teamColor = "#808000";
            $franchise = "Free Agent";
        }

        return view('player_pro', compact('player', 'teamColor', 'franchise'));
        
    }

}

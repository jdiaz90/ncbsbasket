<?php

namespace App\Http\Controllers;

use App\Models\Player;
use ErrorException;

class PlayerStatsController extends Controller
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

        $player['PERS'] = $player->getAllPER(3);

        $player['PERSPO'] = $player->getAllPER(4);

        $player['CurrentSeason'] = $player->currentSeason();

        $player['StatsThisSeason'] = $player->statsThisSeason();
        $player['Stats'] = $player->statistics();

        $player['PlayoffStats'] = $player->statsThisPlayOffs($player)
        ->merge($player->poStats());

        $player['CareerRS'] = $player->getTotalStats();

        $player['CareerPO'] = $player->getTotalPOStats();

        $c = count($player->PERS) - 1; 
        $i = 0;
        
        try {

            $teamColor = $player->team->TeamColor;
            $franchise = $player->franchise;
        
        } catch(ErrorException $e){
            $teamColor = "#808000";
            $franchise = "Free Agent";
        }


        return view('player_stats', compact('player', 'c', 'i', 'teamColor', 'franchise'));
        
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Player;
use ErrorException;

class PlayerLogController extends Controller
{    

    /**
    * Display a listing of the resource.
    *
    * @param  \App\Models\Player  $player
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
    return redirect('/player');
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

        $player['Logs'] = $this->matchList($player);

        try {

            $teamColor = $player->team->TeamColor;
            $franchise = $player->franchise;
        
        } catch(ErrorException $e){
            $teamColor = "#808000";
            $franchise = "Free Agent";
        }

        return view('player_logs', compact('player', 'teamColor', 'franchise'));
        
    }

    static function matchList($player){

        return $player->boxScore()
        ->join("Schedule", "BoxScore.GameNo", "=", "Schedule.GameNo")
        ->selectRaw("BoxScore.*, Day")
        ->orderBy('GameNo', 'desc')
        ->get();
        
    }

}

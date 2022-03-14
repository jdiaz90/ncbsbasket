<?php

namespace App\Http\Controllers;

use App\Models\BoxScore;
use App\Models\Player;
use App\Models\SeasonStat;

class MileStonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $max['Points'] = 0;
        $max['Assists'] = 0;
        $max['Rebounds'] = 0;
        $max['Blocks'] = 0;
        $max['Steals'] = 0;

        $arrayPlayers['Points'] = $this->arrayStats();
        $arrayPlayers['Assists'] = $this->arrayStats("Assists", 1000);
        $arrayPlayers['Rebounds'] = $this->arrayStats("DRebs+ORebs", 2000);
        $arrayPlayers['Steals'] = $this->arrayStats("Steals", 400);
        $arrayPlayers['Blocks'] = $this->arrayStats("Blocks", 100);


        return view("milestones", compact("arrayPlayers", "max"));

    }

    static function arrayUniqueID(){

        $players = Player::select('UniqueID')
        ->where('TeamID', '<=', 30)
        ->get()
        ->toArray();

        $arrayPlayers = [];

        foreach($players as $player)
            array_push($arrayPlayers, $player['UniqueID']);

        return $arrayPlayers;

    }

    static function arrayStats($stat="Points", $min=7000){

        $seasonStats = SeasonStat::select('PlayerID')
        ->selectRaw("sum($stat) as Stat")
        ->whereIn('PlayerID', MileStonesController::arrayUniqueID())
        ->groupBy('PlayerID')
        ->having('Stat', '>', $min)
        ->orderBy('Stat', 'desc')
        ->get();

        $boxScore  = BoxScore::select('PlayerID')
        ->selectRaw("sum($stat) as Stat")
        ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')
        ->where('Minutes', '>', 0)
        ->where('Schedule.GameNo', '<', 2305)
        ->groupBy('PlayerID')
        ->get();

        $arrayBoxScore = [];
        $arraySeasonStats = [];

        foreach($boxScore as $player){
            $arrayBoxScore[$player->player->UniqueID] = $player->Stat;
        }

        foreach($seasonStats as $player){
            $arraySeasonStats[$player->PlayerID] = $player->Stat;
        }

        $arrayTotals = [];

        foreach(array_keys($arraySeasonStats) as $past){
            foreach(array_keys($arrayBoxScore) as $current){
               if($past == $current){
                $arrayTotals[$past] = $arraySeasonStats[$past] + $arrayBoxScore[$past];
                break;
               }
            }
        }

        arsort($arrayTotals);
        $arrayPlayers = [];

        foreach($arrayTotals as $key => $value){

            $player = Player::select('PlayerID', 'FirstName', 'LastName')
            ->where('UniqueID', $key)
            ->get();

            $arrayPlayers[$key]['Player'] = $player[0];
            $arrayPlayers[$key]['Stat'] = $value;

        }

        return $arrayPlayers;

    }

    public function show(){
        return redirect("/milestones");
    }

}

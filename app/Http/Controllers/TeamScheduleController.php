<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Schedule;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;

class TeamScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("/schedule");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show($team)
    {

        $team = Team::findorfail($team);

        if ($team->TeamID == 31 || $team->TeamID == 32)
            return abort(404);

        $findStats = '//div[@class="ui five column grid"]/div[@class="ui column"][3]';
        $arrayStats = $team->formatResult($team->searchResultInfo($findStats));

        $team['PPG'] = $arrayStats['PPG'];
        $team['OPPG'] = $arrayStats['OPPG'];
        $team['APG'] = $arrayStats['APG'];
        $team['RPG'] = $arrayStats['RPG'];

        $schedule = Schedule::where('Home', "=", $team->Franchise)
        ->orWhere('Visitor', "=", $team->Franchise)
        ->where("HomeQ4", ">", 0)
        ->get();

        $w = 0;
        $l = 0;
        $i = 0;

        $opponents = [];
        $results = [];
        $records = [];
        $namesPoints = [];
        $abNamesPoints = []; 
        $highsPoints = [];
        $namesAssists = [];
        $abNamesAssists = [];
        $highsAssists = [];
        $namesRebounds = [];
        $abNamesAssists = [];
        $highsRebounds = [];

        foreach($schedule as $game){

            $id = $game['GameNo'];

            if($game['Home'] == $team->Franchise){

                $opponents[$id]['Name'] = $game['Visitor'];
                $opponents[$id]['Id'] = $this::getTeam($game['Visitor']);
                $opponents[$id]['Home'] = "";

                $namesPoints[$id] = $this::getName($team->searchResultPointsSchedule()[$i], $team);
                $namesAssists[$id] = $game['HomeHighAssistsPlayer'];
                $namesRebounds[$id] = $game['HomeHighReboundsPlayer'];

                $highsPoints[$id] = $game['HomeHighPoints'];
                $highsAssists[$id] = $game['HomeHighAssists'];
                $highsRebounds[$id] = $game['HomeHighRebounds'];

                $abNamesPoints[$id]['Id'] = $this::getID($namesPoints[$id]);
                $abNamesPoints[$id]['Name'] = $team->searchResultPointsSchedule()[$i];
                
                $abNamesAssists[$id]['Id'] = $this::getID($namesAssists[$id]);
                $abNamesAssists[$id]['Name'] = $this::getAbName($namesAssists[$id]);
                
                $abNamesRebounds[$id]['Id'] = $this::getID($namesRebounds[$id]);
                $abNamesRebounds[$id]['Name'] = $this::getAbName($namesRebounds[$id]);

                if($game['HomeScore'] > $game['VisitorScore']){

                    $results[$id] = 
                    "W " . $game['HomeScore'] . "-" . $game['VisitorScore'];

                    $w += 1;

                }else{

                    $results[$id] = 
                    "L " . $game['HomeScore'] . "-" . $game['VisitorScore'];

                    $l += 1;

                }
                    
            }else{
                
                $opponents[$id]['Name'] = $game['Home'];
                $opponents[$id]['Id'] = $this::getTeam($game['Home']);
                $opponents[$id]['Home'] = "@";

                $namesPoints[$id] = $this::getName($team->searchResultPointsSchedule()[$i], $team);
                $namesAssists[$id] = $game['VisitorHighAssistsPlayer'];
                $namesRebounds[$id] = $game['VisitorHighReboundsPlayer'];

                $highsPoints[$id] = $game['VisitorHighPoints'];
                $highsAssists[$id] = $game['VisitorHighAssists'];
                $highsRebounds[$id] = $game['VisitorHighRebounds'];

                $abNamesPoints[$id]['Id'] = $this::getID($namesPoints[$id]);
                $abNamesPoints[$id]['Name'] = $team->searchResultPointsSchedule()[$i];
                
                $abNamesAssists[$id]['Id'] = $this::getID($namesAssists[$id]);
                $abNamesAssists[$id]['Name'] = $this::getAbName($namesAssists[$id]);
                
                $abNamesRebounds[$id]['Id'] = $this::getID($namesRebounds[$id]);
                $abNamesRebounds[$id]['Name'] = $this::getAbName($namesRebounds[$id]);

                if($game['VisitorScore'] > $game['HomeScore']){

                    $results[$id] = 
                    "W " . $game['VisitorScore'] . "-" . $game['HomeScore'];

                    $w += 1;

                }else{

                    $results[$id] = 
                    "L " . $game['VisitorScore'] . "-" . $game['HomeScore'];

                    $l += 1;

                }

            }  
            
            $i++;

            $records[$id] = $w . "-" .$l;

        }
        
        return view("team_schedule", compact("team",
        "schedule",
        "opponents",
        "results",
        "records",
        "namesPoints",
        "highsPoints",
        "namesAssists",
        "highsAssists",
        "namesRebounds",
        "highsRebounds",
        "abNamesPoints",
        "abNamesAssists",
        "abNamesRebounds",)
        );
        
    }

    static function getID($search){

        $identifier = "ID";
        $key = $search . "_" . $identifier;
        $value = "";

        if (!Cache::has($key)){

            $players = Player::select('PlayerID', 'FirstName', 'LastName')
            ->get();

            foreach($players as $player){
                if($player->Full_Name == $search){
                    $value = $player->PlayerID;
                    break;
                }
            }
            
            Cache::put($key, $value, 86400*365);

         } 
         
         return Cache::get($key);
            
    }

    static function getTeam($search){

        $identifier = "ID";
        $key = $search . "_" . $identifier;
        $value = "";

        if (!Cache::has($key)){

            $teams = Team::select('TeamID', 'CityName', 'TeamName')
            ->get();

            foreach($teams as $team){
                if($team->Franchise == $search){
                    $value = $team->TeamID;
                    break;
                }
            }
            
            Cache::put($key, $value, 86400*365);

         } 
         
         return Cache::get($key);
            
    }

    static function getAbName($search){

        $identifier = "ABV";
        $key = $search . "_" . $identifier;
        $value = "";

        if (!Cache::has($key)){

            $players = Player::select('PlayerID', 'FirstName', 'LastName')
            ->get();

            foreach($players as $player){
                if($player->Full_Name == $search){
                    $value = $player->FirstName[0] . ". " .$player->LastName;
                    break;
                }
            }
            
            Cache::put($key, $value, 86400*365);

         } 
         
         return Cache::get($key);
            
    }

    static function getName($search, $team){

        $identifier = "FN";
        $key = "";
        $abTeam = "";
        $value = "";

        if (!Cache::has($key)){

            $array = explode(". ", $search);

            $players = Player::select("FirstName", "LastName", "Team")
            ->where("LastName", $array[1])
            ->where("FirstName", "LIKE", $array[0] . "%")
            ->where("TeamID", ">", 0)
            ->where("TeamID", "<=", 30)
            ->get();


            if(count($players) == 1){

                $value = $players[0]->FirstName . " " . $players[0]->LastName;
                $abTeam = $players[0]->Team;
                $key = $search . "_" . $abTeam. "_" . $identifier;

            }else{

                foreach($players as $player){

                    if($player->Team == $team->TeamAbbrev){

                        $value = $player->FirstName . " " . $player->LastName;
                        $abTeam = $player->Team;
                        $key = $search . "_" . $abTeam. "_" . $identifier;
                        break;

                    }

                }

            }

            
            Cache::put($key, $value, 86400*365);

         } 
         
         return Cache::get($key);
            
    }

}

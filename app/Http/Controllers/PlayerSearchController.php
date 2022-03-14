<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\SeasonStat;
use Illuminate\Support\Collection;

class PlayerSearchController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MediaNew  $mediaNew
     * @return \Illuminate\Http\Response
     */
    public function show($search)
    {

        if(strlen($search) >= 3){

            $id = $search;
            $players = new Collection;

            $this->getPlayers($search, $players);
            $this->getFormerPlayers($search, $players);
    
    
            return view("player_search", compact("id", "players"));

        }else{

            return redirect("/player");

        }
        
    }

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

    static function getPlayers($search, Collection $players){

        $query = Player::selectraw('*')
        ->selectraw('FirstName || " " || LastName AS FullName')
        ->where('FullName', 'LIKE', '%'. $search .'%')
        ->limit(10)
        ->get();
        
        foreach($query as $key => $player){

            if($query[$key]->Team == "FA"){

                $franchise = "Free Agent";
                $imgLogo = "";

            }else{

                $franchise = $query[$key]->team->Franchise;
                $imgLogo = $query[$key]->team->ImgLogo;

            }

            $players = $players->push([
            
                "PlayerID" => $query[$key]->PlayerID,
                "Full_Name" => $query[$key]->Full_Name,
                "PlayerPhoto" => $query[$key]->PlayerPhoto,
                "PlayerURL" => "/player/" . $player["PlayerID"],
                "PPG" => $query[$key]->PPG,
                "APG" => $query[$key]->APG,
                "RPG" => $query[$key]->RPG,
                "TeamID" => $query[$key]->TeamID,
                "Team" => $franchise,
                "ImgLogo" => $imgLogo,
                "Position" => strtoupper($player->Pos),
                "JerseyNum" => $query[$key]->JerseyNum,
                ]   

            );
        }

    }

    static function getFormerPlayers($search, Collection $players){

        $query = SeasonStat::select('PlayerID', 'Team')
        ->selectraw('PlayerName as Full_Name, 
        avg(PPG) as PPG,
        avg(APG) as APG,
        avg(RPG) as RPG')
        ->where('Full_Name', 'LIKE', '%'. $search .'%')
        ->orderBy('SeasonID', 'desc')
        ->groupBy('PlayerID')
        ->get();

        foreach($query as $key => $player){

            $count = Player::select('PlayerID')
            ->where('UniqueID', $player->PlayerID)
            ->get();

            if($count->count() > 0)
                unset($query[$key]);

        }

        foreach($query as $key => $player){

            $query2 = SeasonStat::select("Team")
            ->where("PlayerID", $player->PlayerID)
            ->distinct()
            ->get()
            ->toArray();

            $teams = [];

            foreach($query2 as $team){
                array_push($teams, $team['Team']);
            }

            $teams = implode(", ", $teams);

            $players = $players->push([
            
                "PlayerID" => $query[$key]->PlayerID,
                "Full_Name" => $query[$key]->Full_Name,
                "PlayerPhoto" => "/images/players/" . str_replace(" ", "_", $player["Full_Name"]) . ".png",
                "PlayerURL" => "/formerplayer/" . $player["PlayerID"],
                "PPG" => $query[$key]->PPG,
                "APG" => $query[$key]->APG,
                "RPG" => $query[$key]->RPG,
                "TeamID" => 0,
                "Team" => $teams,
                "ImgLogo" => "N/A",
                "Position" => "N/A",
                "JerseyNum" => "N/A",
                ]   

            );

        }

    }

   
}

<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\MediaNew;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $selectedLeague = $this->checkLeague("P");

        $season = Award::select('Season')
        ->orderByDesc('Season', 'desc')
        ->where("AwardName", "LIKE", "PBL%")
        ->limit(1)
        ->get()[0]->Season;

        $seasons = Award::selectraw('distinct(Season) as Season')
        ->where("AwardName", "LIKE", "PBL%")
        ->orderBy("Season", "desc")
        ->get();
        
        $query = Award::where('Season', $season)
        ->where("AwardName", "LIKE", "PBL%")
        ->orderby('Key','asc')
        ->get();

        $awards = new Collection;

        foreach($query as $award){

            $awards->push(
                [
                    "PlayerID" => $award->PlayerID,
                    "PlayerURL" => url('formerplayer', [ 'id' => $award->PlayerID ]),
                    "PlayerName" => $award->PlayerName,
                    "TeamID" => $award->team->TeamID,
                    "TeamURL" => url('team', [ 'id' => $award->TeamID ]),
                    "TeamIMG" => $award->team->ImgLogo,
                    "TeamName" => $award->TeamID > 0 ? $award->team->TeamName : "Not Available",
                    "AwardName" => $award->AwardName,
                ]
            );
        }
        
        $awards = $awards->groupBy("AwardName");

        return View("awards", compact("selectedLeague", 
        "awards", 
        "season", 
        "seasons"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $search = $request->get('league') == "P" ? "PBL%" : "DBL%"; 
        $selectedLeague = $this->checkLeague($request->get('league'));
        $season = $request->get('season');

        $seasons = Award::selectraw('distinct(Season) as Season')
        ->where("AwardName", "LIKE", $search)
        ->orderBy("Season", "desc")
        ->get();

        $query = Award::where('Season', $season)
        ->where("AwardName", "LIKE", $search)
        ->orderby('Key','asc')
        ->get();


        $awards = new Collection;

        foreach($query as $award){

            $awards->push(
                [
                    "PlayerID" => $award->PlayerID,
                    "PlayerURL" => url('formerplayer', [ 'id' => $award->PlayerID ]),
                    "PlayerName" => $award->PlayerName,
                    "TeamID" => $award->TeamID > 0 ? $award->team->TeamID : 0,
                    "TeamURL" => url('team', [ 'id' => $award->TeamID ]),
                    "TeamIMG" => $award->TeamID > 0 ? $award->team->ImgLogo : "",
                    "TeamName" => $award->TeamID > 0 ? $award->team->TeamName : "Not Available",
                    "AwardName" => $award->AwardName,
                ]
            );
        }
        
        $awards = $awards->groupBy("AwardName");


        return View("awards", compact("selectedLeague", 
        "awards", 
        "season", 
        "seasons"));

        }

        function Headlines(){

            $selectedLeague = $this->checkLeague("P");

            $month = MediaNew::
            select("Day", "Story", "RefID", "MainTeam")
            ->where("Story", "LIKE", "%PBL Player of the Month%")
            ->orderBy("Day", "desc")
            ->get();
            $week = MediaNew::
            select("Day", "Story", "RefID", "MainTeam")
            ->where("Story", "LIKE", "%PBL Player of the Week%")
            ->orderBy("Day", "desc")
            ->get();
            $rookie = MediaNew::
            select("Day", "Story", "RefID", "MainTeam")
            ->where("Story", "LIKE", "%PBL Rookie of the Month%")
            ->orderBy("Day", "desc")
            ->get();


            return View("award_headlines", compact("selectedLeague", "month", "week", "rookie"));

        }

        static function checkLeague($league){

            $selected =  [
                0 => "",
                1 => "",
            ];
    
            if($league == "P")
                $selected[0] = "selected";
            else
                $selected[1] = "selected";
    
            return $selected;
    
        }


        public function show(){
            return redirect("/awardwinners");
        }

}



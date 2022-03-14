<?php

namespace App\Http\Controllers;

use App\Models\PastStanding;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

global $request;

class PastStandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $years = $this->getYears();
        $selectedLeague = $this->checkLeague('P');
        $selectedStandings = $this->checkStandings('D');
        $selectedSeason = $this->checkSeason($this->maxYear());
        $_POST['league'] = "P";
        
        $divisions['Atlantic Division'] = $this->getDivision(1, $this->maxYear());
        $divisions['Central Division'] = $this->getDivision(2, $this->maxYear());
        $divisions['Southeast Division'] = $this->getDivision(3, $this->maxYear());
        $divisions['Southwest Division'] = $this->getDivision(4, $this->maxYear());
        $divisions['Northwest Division'] = $this->getDivision(5, $this->maxYear());
        $divisions['Pacific Division'] = $this->getDivision(6, $this->maxYear());

    
        return view("paststandings", compact("years", "selectedLeague", "selectedStandings", "selectedSeason", "divisions"));
    }

    public function store(Request $request)
    {

        $years = $this->getYears();
        $selectedLeague = $this->checkLeague($request->get('league'));
        $selectedStandings = $this->checkStandings($request->get('standings'));
        $selectedSeason = $this->checkSeason($request->get('year'));
        
        if($request->get('standings') == "C" && $request->get('league') == "D"){

            $selectedStandings = $this->checkStandings("D");
            
            $divisions['East Division'] = $this->getDivision(1, $request->get('year'), "D");
            $divisions['South Division'] = $this->getDivision(2, $request->get('year'), "D");
            $divisions['Central Division'] = $this->getDivision(3, $request->get('year'), "D");
            $divisions['West Division'] = $this->getDivision(4, $request->get('year'), "D");
            
        }

        else{

            if($request->get('standings') == 'L'){
            
                if($request->get('league') == "P")
                    $divisions['Pro Basketball League'] = $this->getLeague($request->get('year'));
                else
                    $divisions['Developmental Basketball League'] = $this->getLeague($request->get('year'), $request->get('league'));
    
            }else if($request->get('standings') == 'C'){
    
                $divisions['Eastern Conference'] = $this->getConference(1, $request->get('year'));
                $divisions['Western Conference'] = $this->getConference(2, $request->get('year'));
    
            }else{
    
                if($request->get('league') == "P"){
    
                    $divisions['Atlantic Division'] = $this->getDivision(1, $request->get('year'));
                    $divisions['Central Division'] = $this->getDivision(2, $request->get('year'));
                    $divisions['Southeast Division'] = $this->getDivision(3, $request->get('year'));
                    $divisions['Southwest Division'] = $this->getDivision(4, $request->get('year'));
                    $divisions['Northwest Division'] = $this->getDivision(5, $request->get('year'));
                    $divisions['Pacific Division'] = $this->getDivision(6, $request->get('year'));
    
                }else{
    
                    $divisions['East Division'] = $this->getDivision(1, $request->get('year'), $request->get('league'));
                    $divisions['South Division'] = $this->getDivision(2, $request->get('year'), $request->get('league'));
                    $divisions['Central Division'] = $this->getDivision(3, $request->get('year'), $request->get('league'));
                    $divisions['West Division'] = $this->getDivision(4, $request->get('year'), $request->get('league'));
    
                }
    
            }

        }
            

        return view("paststandings", compact("years", "selectedLeague", "selectedStandings", "selectedSeason", "divisions"));
    }

    static function getDivision($numberDivision = 1, $year, $league = "P"){
        
        
        if($league == "P")

            $teams = PastStanding::
            where("TeamID", "<=", 30)
            ->where("Season", $year)
            ->get();

        else

            $teams = PastStanding::
            where("TeamID", ">", 32)
            ->where("Season", $year)
            ->get();


        $division = new Collection;

        foreach($teams as $team)

            if($team->DivisionID == $numberDivision){

                $division->put($team->team->Franchise,

                    [
                        "IMG" => $team->team->ImgLogo,
                        "URL" => url('team', [ 'id' => $team->TeamID ]),
                        "W" => $team->Wins,
                        "L" => $team->Losses,
                        "PCT" => "." . $team->WinPct,
                        "GB" => 0,
                    ]
    
                );

            }

            $division = $division->sortByDesc('PCT')->sortByDesc('W');
            $maxWins = $division->max('W');  
            
            $division->transform(function($transform) use ($maxWins){
                $transform['GB'] = $maxWins - $transform['W'];
    
                return $transform;
            });

            return $division;

    }

    static function getConference($numberConference = 1, $year){

        $teams = PastStanding::
        where("TeamID", "<=", 30)
        ->where("Season", $year)
        ->get();

        $conference = new Collection;

        foreach($teams as $team)

            if($team->ConferenceID == $numberConference){

                $conference->put($team->team->Franchise,

                    [
                        "IMG" => $team->team->ImgLogo,
                        "URL" => url('team', [ 'id' => $team->TeamID ]),
                        "W" => $team->Wins,
                        "L" => $team->Losses,
                        "PCT" => number_format($team->Wins / ($team->Wins + $team->Loses), 3),
                        "GB" => 0,
                    ]
    
                );

            }

            $conference = $conference->sortByDesc('PCT')->sortByDesc('W');
            $maxWins = $conference->max('W');  
            
            $conference->transform(function($transform) use ($maxWins){
                $transform['GB'] = $maxWins - $transform['W'];
    
                return $transform;
            });

            return $conference;

    }

    static function getLeague($year, $league = "P"){

        if($league == "P")

            $teams = PastStanding::
            where("TeamID", "<=", 30)
            ->where("Season", $year)
            ->get();

        else

            $teams = PastStanding::
            where("TeamID", ">", 32)
            ->where("Season", $year)
            ->get();


        $division = new Collection;

        foreach($teams as $team)

                $division->put($team->team->Franchise,

                    [
                        "IMG" => $team->team->ImgLogo,
                        "URL" => url('team', [ 'id' => $team->TeamID ]),
                        "W" => $team->Wins,
                        "L" => $team->Losses,
                        "PCT" => "." .$team->WinPct,
                        "GB" => 0,
                    ]
    
                );


            $division = $division->sortByDesc('PCT')->sortByDesc('W');
            $maxWins = $division->max('W');  
            
            $division->transform(function($transform) use ($maxWins){
                $transform['GB'] = $maxWins - $transform['W'];
    
                return $transform;
            });

            return $division;

    }

    static function getYears(){

        return PastStanding::select('Season')
        ->distinct()
        ->orderBy('Season', 'desc')
        ->get();

    }

    static function maxYear(){

        return PastStanding::select('Season')
        ->orderBy('Season', 'desc')
        ->limit(1)
        ->get()[0]['Season'];

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

    static function checkStandings($standings){

        $selected =  [
            0 => "",
            1 => "",
            2 => "",
        ];

        if($standings == 'L')
            $selected[0] = "checked";
        else if($standings == 'C')
            $selected[1] = "checked";
        else
            $selected[2] = "checked";

        return $selected;

    }

    static function checkSeason($selectedSeason){

        $c = 0;
        $selected = [];

        foreach(PastStandingController::getYears() as $season){
            if($selectedSeason == $season->Season)
                $selected[$c] = "selected";
            else
                $selected[$c] = "";
            $c++;
        }

        return $selected;

    }

    public function show(){
        return redirect("/paststandings");
    }

}

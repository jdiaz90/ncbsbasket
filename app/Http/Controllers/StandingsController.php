<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class StandingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selectedLeague = $this->checkLeague();
        $selectedStandings = $this->checkStandings('D');
        
        $divisions['Atlantic Division'] = $this->getDivision();
        $divisions['Central Division'] = $this->getDivision(2);
        $divisions['Southeast Division'] = $this->getDivision(3);
        $divisions['Southwest Division'] = $this->getDivision(4);
        $divisions['Northwest Division'] = $this->getDivision(5);
        $divisions['Pacific Division'] = $this->getDivision(6);

    
        return view("standings", compact("selectedLeague", "selectedStandings", "divisions"));
    }

    public function store(Request $request)
    {
        
        $selectedLeague = $this->checkLeague();
        $selectedStandings = $this->checkStandings($request->get('standings'));
        
        if($request->get('standings') == 'L'){
            
            $divisions['Pro Basketball League'] = $this->getLeague();

        }else if($request->get('standings') == 'C'){

            $divisions['Eastern Conference'] = $this->getConference();
            $divisions['Western Conference'] = $this->getConference(2);

        }else{

            $divisions['Atlantic Division'] = $this->getDivision();
            $divisions['Central Division'] = $this->getDivision(2);
            $divisions['Southeast Division'] = $this->getDivision(3);
            $divisions['Southwest Division'] = $this->getDivision(4);
            $divisions['Northwest Division'] = $this->getDivision(5);
            $divisions['Pacific Division'] = $this->getDivision(6);

        }
            

        return view("standings", compact("selectedLeague", "selectedStandings", "divisions"));

    }

    static function getDivision($numberDivision = 1){

        $teams = Team::
        where("TeamID", "<=", 30)
        ->get();

        $division = new Collection;

        foreach($teams as $team)

            if($team->otherInfo->DivisionID == $numberDivision){

                $division->put($team->Franchise,

                    [
                        "IMG" => $team->ImgLogo,
                        "URL" => url('team', [ 'id' => $team->TeamID ]),
                        "W" => $team->Wins,
                        "L" => $team->Loses,
                        "PCT" => number_format($team->Wins / ($team->Wins + $team->Loses), 3),
                        "GB" => 0,
                        "CONF" => $team->ConfWins . "-" . $team->ConfLoses,
                        "DIV" => $team->DivWins . "-" . $team->DivLoses,
                        "HOME" => $team->HomeWins . "-" . $team->HomeLoses,
                        "AWAY" => $team->AwayWins . "-" . $team->AwayLoses,
                        "L10" => $team->L10['Wins'] . "-" . $team->L10['Loses'],
                        "STREAK" => $team->StreakStandings
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

    static function getConference($numberConference = 1){

        $teams = Team::
        where("TeamID", "<=", 30)
        ->get();

        $conference = new Collection;

        foreach($teams as $team)

            if($team->otherInfo->ConferenceID == $numberConference){

                $conference->put($team->Franchise,

                    [
                        "IMG" => $team->ImgLogo,
                        "URL" => url('team', [ 'id' => $team->TeamID ]),
                        "W" => $team->Wins,
                        "L" => $team->Loses,
                        "PCT" => number_format($team->Wins / ($team->Wins + $team->Loses), 3),
                        "GB" => 0,
                        "CONF" => $team->ConfWins . "-" . $team->ConfLoses,
                        "DIV" => $team->DivWins . "-" . $team->DivLoses,
                        "HOME" => $team->HomeWins . "-" . $team->HomeLoses,
                        "AWAY" => $team->AwayWins . "-" . $team->AwayLoses,
                        "L10" => $team->L10['Wins'] . "-" . $team->L10['Loses'],
                        "STREAK" => $team->StreakStandings
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

    static function getLeague(){

        $teams = Team::
        where("TeamID", "<=", 30)
        ->get();

        $league = new Collection;

        foreach($teams as $team)

                $league->put($team->Franchise,

                    [
                        "IMG" => $team->ImgLogo,
                        "URL" => url('team', [ 'id' => $team->TeamID ]),
                        "W" => $team->Wins,
                        "L" => $team->Loses,
                        "PCT" => number_format($team->Wins / ($team->Wins + $team->Loses), 3),
                        "GB" => 0,
                        "CONF" => $team->ConfWins . "-" . $team->ConfLoses,
                        "DIV" => $team->DivWins . "-" . $team->DivLoses,
                        "HOME" => $team->HomeWins . "-" . $team->HomeLoses,
                        "AWAY" => $team->AwayWins . "-" . $team->AwayLoses,
                        "L10" => $team->L10['Wins'] . "-" . $team->L10['Loses'],
                        "STREAK" => $team->StreakStandings
                    ]
    
                );


            $league = $league->sortByDesc('PCT')->sortByDesc('W');
            $maxWins = $league->max('W');  
            
            $league->transform(function($transform) use ($maxWins){
                $transform['GB'] = $maxWins - $transform['W'];
    
                return $transform;
            });

            return $league;

    }

    static function checkLeague(){

        $selected =  [
            0 => "",
            1 => "",
        ];

        if(Route::currentRouteName() == "standings.index" ||
            Route::currentRouteName() == "standings.store")
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

    public function show(){
        return redirect("/standings");
    }

}

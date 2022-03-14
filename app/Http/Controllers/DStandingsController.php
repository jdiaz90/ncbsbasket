<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class DStandingsController extends Controller
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
        
        $divisions['East Division'] = $this->getDivision();
        $divisions['South Division'] = $this->getDivision(2);
        $divisions['Central Division'] = $this->getDivision(3);
        $divisions['West Division'] = $this->getDivision(4);

    
        return view("standings", compact("selectedLeague", "selectedStandings", "divisions"));

    }

    public function store(Request $request)
    {
        
        $selectedLeague = $this->checkLeague();
        $selectedStandings = $this->checkStandings($request->get('standings'));
        
        if($request->get('standings') == 'L'){

            $divisions['Developmental Basketball League'] = $this->getLeague();

        } else{

            $divisions['East Division'] = $this->getDivision();
            $divisions['South Division'] = $this->getDivision(2);
            $divisions['Central Division'] = $this->getDivision(3);
            $divisions['West Division'] = $this->getDivision(4);

        }


        return view("standings", compact("selectedLeague", "selectedStandings", "divisions"));

    }

    static function getLeague(){

        $league = new Collection;
        
        $client = new Client();
        $crawler = $client->request('GET',"/html/DBLStandings.html");  

        $teams = $crawler->filterXPath('//table[@class="ui selectable basic table"]
        /tbody
        /tr')
        ->each(function ($tr){
            return $tr->filterXPath('//td')
            ->each(function ($td){
                return $td->text();   
            });
        }); 

        foreach($teams as $key => $team)
            if(str_contains("East Division", $team[0]) ||
            str_contains("South Division", $team[0]) ||
            str_contains("Central Division", $team[0]) ||
            str_contains("West Division", $team[0]))
                unset($teams[$key]);

        foreach($teams as $team){

            $team[0] = strtr($team[0], array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES))); 
            $team[0] = trim($team[0], chr(0xC2).chr(0xA0));
            $info = DStandingsController::getTeam($team[0]);

            $league->put($team[0],

                [
                    "IMG" => $info->ImgLogo,
                    "URL" => url('team', [ 'id' => $info->TeamID ]),
                    "W" => $team[1],
                    "L" => $team[2],
                    "PCT" => $team[3],
                    "GB" => $team[4],
                    "CONF" => $team[5],
                    "DIV" => $team[6],
                    "HOME" => $team[7],
                    "AWAY" => $team[8],
                    "L10" => $team[9],
                    "STREAK" => $team[10],
                ]

            );

        }
        
        $league = $league->sortByDesc('PCT')->sortByDesc('W');
        $maxWins = $league->max('W');  
        
        $league->transform(function($transform) use ($maxWins){
            $transform['GB'] = $maxWins - $transform['W'];

            return $transform;
        });

        return $league;

    }

    static function getDivision($numberDivision = 1){

        $division = new Collection;
        
        $client = new Client();
        $crawler = $client->request('GET',"/html/DBLStandings.html");  

        $teams = $crawler->filterXPath('//table[@class="ui selectable basic table"][' .$numberDivision . ']
        /tbody
        /tr')
        ->each(function ($tr){
            return $tr->filterXPath('//td')
            ->each(function ($td){
                return $td->text();   
            });
        }); 

        unset($teams[0]);

        foreach($teams as $team){

            $team[0] = strtr($team[0], array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES))); 
            $team[0] = trim($team[0], chr(0xC2).chr(0xA0));
            $info = DStandingsController::getTeam($team[0]);

            $division->put($team[0],

                [
                    "IMG" => $info->ImgLogo,
                    "URL" => url('team', [ 'id' => $info->TeamID ]),
                    "W" => $team[1],
                    "L" => $team[2],
                    "PCT" => $team[3],
                    "GB" => $team[4],
                    "CONF" => $team[5],
                    "DIV" => $team[6],
                    "HOME" => $team[7],
                    "AWAY" => $team[8],
                    "L10" => $team[9],
                    "STREAK" => $team[10],
                ]

            );

        }

        return $division;

    }

    static function getTeam($franchise){

        $teams = Team::
        where("TeamID", '>', 32)
        ->get();

        foreach($teams as $team)
            if(trim($franchise) == trim($team->Franchise))
                return $team;              
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
        return redirect("/dstandings");
    }

}

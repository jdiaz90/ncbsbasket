<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Collection;

class TeamLeagueLeadersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teams = Team::where('TeamID', '<=', '30')
        ->get();
        $teamCollection = new Collection;
        $findStats = '//div[@class="ui five column grid"]/div[@class="ui column"][3]';

        foreach($teams as $team){
            $aux = $team->formatResult($team->searchResultInfo($findStats));
            $aux['TeamID'] = $team->TeamID;
            $aux['CityName'] = $team->CityName;
            $aux['Img'] = $team->ImgLogo;
            $teamCollection->push($aux);
        }
          

        return view("team_league_leaders", compact("teamCollection"));

    }

    public function show()
    {
        return redirect("/teamleagueleaders");
    }

}

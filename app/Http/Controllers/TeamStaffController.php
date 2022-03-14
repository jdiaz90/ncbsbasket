<?php

namespace App\Http\Controllers;

use App\Models\Team;

class TeamStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("/teamstaff/1");
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

        $findStats = '//div[@class="ui five column grid"]/div[@class="ui column"][3]';
        $arrayStats = $team->formatResult($team->searchResultInfo($findStats));

        $team['PPG'] = $arrayStats['PPG'];
        $team['OPPG'] = $arrayStats['OPPG'];
        $team['APG'] = $arrayStats['APG'];
        $team['RPG'] = $arrayStats['RPG'];

        $team['CurrentSeason'] = Team::currentSeason();

        if ($team->TeamID == 31 || $team->TeamID == 32)
            return abort(404);

        return view("team_staff", compact("team"));
        
    }

}

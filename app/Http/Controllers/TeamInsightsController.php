<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Collection;

class TeamInsightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("/teaminsights/1");
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
        $team['APG'] = $arrayStats['APG'];
        $team['RPG'] = $arrayStats['RPG'];
        $team['BPG'] = $arrayStats['BPG'];
        $team['SPG'] = $arrayStats['SPG'];
        $team['FGPct'] = $arrayStats['FGPct'];
        $team['FG3PPct'] = $arrayStats['FG3PPct'];
        $team['FTPct'] = $arrayStats['FTPct'];
        $team['OPPG'] = $arrayStats['OPPG'];

        $team['CurrentSeason'] = Team::currentSeason();

        if ($team->TeamID == 31 || $team->TeamID == 32)
            return abort(404);

        $teams = Team::select('TeamID', 'CityName', 'TeamName', 'TeamAbbrev')
        ->where('TeamID', '<=', 30)
        ->get();

        $teamsCollection = new  Collection;
        $positions = [];

        foreach($teams as $aux){
            $stats = $aux->formatResult($aux->searchResultInfo($findStats));
            $stats['Name'] = $aux->Franchise; 
            $stats['Logo'] = $aux->ImgLogo; 
            $stats['ID'] = $aux->TeamID; 
            $teamsCollection->put($aux->TeamID, $stats);
        }

        $positions = $this::ranking($teamsCollection, $team->Franchise);

        $leaders = $this::leaders($teamsCollection);

        return view("team_insights", compact("team", "positions", "leaders"));
        
    }

    static function position($collection, $team){

        $position = 1;
        $value = 0;

        foreach($collection as $selectedTeam){

            if($team == $selectedTeam['Name']){
                 $value = $position;
                 break;
            }
               
            $position++;

        }

        if($value == 1)
            return "1ST";
        else if($value == 2)
            return "2ND";
        else if($value == 3)
            return "3RD";
        return $value . "TH";

    }

    static function leader($collection, $value){

        $stats = [];
        $stats['Value'] = $value;
        $stats['Logo'] = $collection->first()['Logo'] ?? null;

        return $stats;

    }

    static function ranking($teamsCollection, $team){

        $positions = [];

        $positions['PPG'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['PPG', 'desc'],
            ['Name', 'asc'],
        ]), $team);

        $positions['APG'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['APG', 'desc'],
            ['Name', 'asc'],
        ]), $team);

        $positions['RPG'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['RPG', 'desc'],
            ['Name', 'asc'],
        ]), $team);

        $positions['BPG'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['BPG', 'desc'],
            ['Name', 'asc'],
        ]), $team);

        $positions['SPG'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['SPG', 'desc'],
            ['Name', 'asc'],
        ]), $team);
        
        $positions['FGPct'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['FGPct', 'desc'],
            ['Name', 'asc'],
        ]), $team);
        
        $positions['FTPct'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['FTPct', 'desc'],
            ['Name', 'asc'],
        ]), $team);
        
        $positions['FG3PPct'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['FG3PPct', 'desc'],
            ['Name', 'asc'],
        ]), $team);     
    
        $positions['OPPG'] = 
        TeamInsightsController::position($teamsCollection->sortBy([
            ['OPPG', 'asc'],
            ['Name', 'asc'],
        ]), $team);
        
        
        return $positions;
    
    }

    static function leaders($teamsCollection){

        $leaders = [];

        $leaders['PPG'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['PPG', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('PPG'));

        $leaders['APG'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['APG', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('APG'));

        $leaders['RPG'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['RPG', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('RPG'));

        $leaders['BPG'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['BPG', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('BPG'));

        $leaders['SPG'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['SPG', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('SPG'));
        
        $leaders['FGPct'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['FGPct', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('FGPct'));
        
        $leaders['FTPct'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['FTPct', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('FTPct'));
        
        $leaders['FG3PPct'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['FG3PPct', 'desc'],
            ['Name', 'asc'],
        ]), $teamsCollection->max('FG3PPct'));
    
        $leaders['OPPG'] = 
        TeamInsightsController::leader($teamsCollection->sortBy([
            ['OPPG', 'asc'],
            ['Name', 'asc'],
        ]), $teamsCollection->min('OPPG'));
        
        
        return $leaders;
    
    }

}

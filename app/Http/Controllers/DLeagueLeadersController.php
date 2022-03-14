<?php

namespace App\Http\Controllers;

use App\Models\BoxScore;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DLeagueLeadersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $selected = $this->selectedOption('avg(Points)');
        $selectedPosition = $this->selectedPosition('All Positions');
        $selectedLeague = $this->checkLeague($request);
        $select = $this->fillSelect($selected, 'on');
        $toggles = $this->checkedToggleButtons('on', '', 'on', '');

        $position = 'All Positions';

        $c = 1;

        $leaderCards = $this->leaderCards();
        $leaderStats = $this->leaderStats('avg(Points)');


        return view("league_leaders", compact("select", "toggles", "c", "position", "selectedPosition", "selectedLeague",
        "leaderCards", "leaderStats"));

    }

    public function store(Request $request)
    {
        
        $selected = $this->selectedOption($request->get('record'));
        $selectedPosition = $this->selectedPosition($request->get('position'));
        $selectedLeague = $this->checkLeague($request);
        $select = $this->fillSelect($selected, $request->get('avg'));
        
        $toggles = $this->checkedToggleButtons($request->get('avg'), $request->get('sum'),
            $request->get('rs'), $request->get('po'));

        $position = $request->get('position');

        $c = 1;

        $stat = $this->checkStat($request->get('record'));
        $stat = $this->changeOption($request, $stat);

        $leaderCards = $this->leaderCards();
        $leaderStats = $this->leaderStats($stat, $request->get('po'));

        return view("league_leaders", compact("select", "toggles", "c", "position", "selectedPosition", "selectedLeague",
        "leaderCards", "leaderStats"));

    }

    static function leaderCards(){

        $minGames = (int)round(BoxScore::selectRaw('count(PlayerID) as Games')
        ->where('GameNo', '<', '2305')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', '>', 0)
        ->groupBy('PlayerID')
        ->get()
        ->max('Games') / 100  * 70, 0);

        $query = BoxScore::select('PlayerID')
        ->selectRaw('avg(Points) as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->where('GameNo', '<', '2305')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->groupBy('PlayerID')
        ->having('Games', '>=', $minGames)
        ->orderBy('Stat', 'desc')
        ->limit(1)
        ->get()
        ->first();


        $leaderCards[0] = Player::select('FirstName', 'LastName', 'JerseyNum', 'Position', 'TeamID')
        ->selectRaw($query['Stat'] . " as Stat, 'POINTS PER GAME' as Title")
        ->where('PlayerID', $query['PlayerID'])
        ->get()
        ->first();

        $query = BoxScore::select('PlayerID')
        ->selectRaw('avg(Assists) as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->where('GameNo', '<', '2305')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->groupBy('PlayerID')
        ->having('Games', '>=', $minGames)
        ->orderBy('Stat', 'desc')
        ->limit(1)
        ->get()
        ->first();

        $leaderCards[1] = Player::select('FirstName', 'LastName', 'JerseyNum', 'Position', 'TeamID')
        ->selectRaw($query['Stat'] . " as Stat, 'ASSISTS PER GAME' as Title")
        ->where('PlayerID', $query['PlayerID'])
        ->get()
        ->first();

        $query = BoxScore::select('PlayerID')
        ->selectRaw('avg(Drebs+ORebs) as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->where('GameNo', '<', '2305')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->groupBy('PlayerID')
        ->having('Games', '>=', $minGames)
        ->orderBy('Stat', 'desc')
        ->limit(1)
        ->get()
        ->first();

        $leaderCards[2] = Player::select('FirstName', 'LastName', 'JerseyNum', 'Position', 'TeamID')
        ->selectRaw($query['Stat'] . " as Stat, 'REBOUNDS PER GAME' as Title")
        ->where('PlayerID', $query['PlayerID'])
        ->get()
        ->first();

        $query = BoxScore::select('PlayerID')
        ->selectRaw('avg(Blocks) as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->where('GameNo', '<', '2305')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->groupBy('PlayerID')
        ->having('Games', '>=', $minGames)
        ->orderBy('Stat', 'desc')
        ->limit(1)
        ->get()
        ->first();

        $leaderCards[3] = Player::select('FirstName', 'LastName', 'JerseyNum', 'Position', 'TeamID')
        ->selectRaw($query['Stat'] . " as Stat, 'BLOCKS PER GAME' as Title")
        ->where('PlayerID', $query['PlayerID'])
        ->get()
        ->first();

        $query = BoxScore::select('PlayerID')
        ->selectRaw('avg(Steals) as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->where('GameNo', '<', '2305')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->groupBy('PlayerID')
        ->having('Games', '>=', $minGames)
        ->orderBy('Stat', 'desc')
        ->limit(1)
        ->get()
        ->first();

        $leaderCards[4] = Player::select('FirstName', 'LastName', 'JerseyNum', 'Position', 'TeamID')
        ->selectRaw($query['Stat'] . " as Stat, 'STEALS PER GAME' as Title")
        ->where('PlayerID', $query['PlayerID'])
        ->get()
        ->first();

        return $leaderCards;

    }

    static function leaderStats($stat, $postSeason=""){

        $minGames = (int)round(BoxScore::selectRaw('count(PlayerID) as Games')
        ->where('GameNo', '<', '2305')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', '>', 0)
        ->groupBy('PlayerID')
        ->get()
        ->max('Games') / 100  * 70, 0);
        
        if($postSeason == "on")
            $minGames = 1;

        if($stat == "FG%")
            return LeagueLeadersController::FGPct($postSeason);

        if($stat == "FG3P%")
            return LeagueLeadersController::ThreePPct($postSeason);

        if($stat == "FT%")
            return LeagueLeadersController::FTPct($postSeason);
    
        if($stat == "DoubleDoubles")
            return LeagueLeadersController::doubleDoubles($postSeason);

        if($stat == "TripleDoubles")
            return LeagueLeadersController::tripleDoubles($postSeason);

        if($postSeason <> "on")

            return BoxScore::select('PlayerID')
            ->selectRaw($stat . ' as Stat')
            ->selectRaw('count(PlayerID) as Games')
            ->where('GameNo', '<', '2305')
            ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->having('Games', '>=', $minGames)
            ->orderBy('Stat', 'desc')
            ->get();

        return BoxScore::select('PlayerID')
        ->selectRaw($stat . ' as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->where('GameNo', '>=', '2307')
        ->groupBy('PlayerID')
        ->having('Games', '>=', $minGames)
        ->orderBy('Stat', 'desc')
        ->get();

    }

    static function checkStat($stat){

        if($stat == "EFF")
            $stat = "((cast(sum(Points) as float) + sum(Drebs+ORebs) + sum(Assists) + sum(Steals) + sum(Blocks)) -
            (sum(FGA - FGM) + sum(FTA - FTM) + sum(Turnovers))) / count(PlayerID)";

        return $stat;

    }

    static function checkLeague(){

        $selected =  [
            0 => "",
            1 => "",
        ];

        if(Route::currentRouteName() == "leagueleaders.index" ||
            Route::currentRouteName() == "leagueleaders.store")
            $selected[0] = "selected";
        else
            $selected[1] = "selected";

        return $selected;

    }

    static function FGPct($postSeason){

        if($postSeason <> "on")

            return BoxScore::select('PlayerID')
            ->selectRaw('cast(sum(FGM) as float)/sum(FGA) * 1000 as Stat')
            ->selectRaw('count(PlayerID) as Games')
            ->selectRaw('sum(FGM) as FGMTotal')
            ->where('GameNo', '<', '2305')
            ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->having('FGMTotal', '>=', 300)
            ->orderBy('Stat', 'desc')
            ->get();

        return BoxScore::select('PlayerID')
        ->selectRaw('cast(sum(FGM) as float)/sum(FGA) * 1000 as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->selectRaw('sum(FGM) as FGMTotal')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->where('GameNo', '>=', '2307')
        ->groupBy('PlayerID')
        ->having('FGMTotal', '>=', 300)
        ->orderBy('Stat', 'desc')
        ->get();
    }

    static function FTPct($postSeason){

        if($postSeason <> "on")

            return BoxScore::select('PlayerID')
            ->selectRaw('cast(sum(FTM) as float)/sum(FTA) * 1000 as Stat')
            ->selectRaw('count(PlayerID) as Games')
            ->selectRaw('sum(FTM) as FTMTotal')
            ->where('GameNo', '<', '2305')
            ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->having('FTMTotal', '>=', 125)
            ->orderBy('Stat', 'desc')
            ->get();

        return BoxScore::select('PlayerID')
        ->selectRaw('cast(sum(FTM) as float)/sum(FTA) * 1000 as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->selectRaw('sum(FTM) as FTMTotal')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->where('GameNo', '>=', '2307')
        ->groupBy('PlayerID')
        ->having('FGMTotal', '>=', 125)
        ->orderBy('Stat', 'desc')
        ->get();
    }

    static function ThreePPct($postSeason){

        if($postSeason <> "on")

            return BoxScore::select('PlayerID')
            ->selectRaw('cast(sum(FG3PM) as float)/sum(FG3PA) * 1000 as Stat')
            ->selectRaw('count(PlayerID) as Games')
            ->selectRaw('sum(FG3PM) as FG3PMTotal')
            ->where('GameNo', '<', '2305')
            ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->having('FG3PMTotal', '>=', 82)
            ->orderBy('Stat', 'desc')
            ->get();

        return BoxScore::select('PlayerID')
        ->selectRaw('cast(sum(FG3PM) as float)/sum(FG3PA) * 1000 as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->selectRaw('sum(FG3PM) as FGMTotal')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->where('GameNo', '>=', '2307')
        ->groupBy('PlayerID')
        ->having('FGMTotal', '>=', 82)
        ->orderBy('Stat', 'desc')
        ->get();
    }

    static function doubleDoubles($postSeason=""){

        if($postSeason <> "on") 
            return BoxScore::select('PlayerID')
            ->selectRaw('count(PlayerID) as Stat')
            ->selectRaw('count(PlayerID) as Games')
            ->where('GameNo', '<', '2305')
            ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
            ->where('Minutes', ">", 0) 
            ->whereRaw('(

                (Points >= 10 and Assists >= 10) or
                (Points >= 10 and DRebs+ORebs >= 10) or
                (Points >= 10 and Blocks >= 10) or
                (Points >= 10 and Steals >= 10) or
                
                (Assists >= 10 and DRebs+ORebs >= 10) or
                (Assists >= 10 and Blocks >= 10) or
                (Assists >= 10 and Steals >= 10) or
                
                (DRebs+ORebs >= 10 and Blocks >= 10) or
                (DRebs+ORebs >= 10 and Steals >= 10) or
                
                (Blocks >= 10 and Steals >= 10) 
                
                )')
            ->groupBy('PlayerID')
            ->orderBy('Stat', 'desc')
            ->get();

        return BoxScore::select('PlayerID')
        ->selectRaw('count(PlayerID) as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->where('GameNo', '>=', '2307')
        ->whereRaw('(

            (Points >= 10 and Assists >= 10) or
            (Points >= 10 and DRebs+ORebs >= 10) or
            (Points >= 10 and Blocks >= 10) or
            (Points >= 10 and Steals >= 10) or
            
            (Assists >= 10 and DRebs+ORebs >= 10) or
            (Assists >= 10 and Blocks >= 10) or
            (Assists >= 10 and Steals >= 10) or
            
            (DRebs+ORebs >= 10 and Blocks >= 10) or
            (DRebs+ORebs >= 10 and Steals >= 10) or
            
            (Blocks >= 10 and Steals >= 10) 
            
            )')
        ->groupBy('PlayerID')
        ->orderBy('Stat', 'desc')
        ->get();
    }

    static function tripleDoubles($postSeason=""){

        if($postSeason <> "on") 
            return BoxScore::select('PlayerID')
            ->selectRaw('count(PlayerID) as Stat')
            ->selectRaw('count(PlayerID) as Games')
            ->where('GameNo', '<', '2305')
            ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
            ->where('Minutes', ">", 0) 
            ->whereRaw('(
                
                (Points >= 10 and Assists >= 10 and DRebs+ORebs >= 10) or
                (Points >= 10 and Assists >= 10 and Blocks >= 10) or
                (Points >= 10 and Assists >= 10 and Steals >= 10) or
                
                (Points >= 10 and DRebs+ORebs >= 10 and Blocks >= 10) or
                (Points >= 10 and DRebs+ORebs >= 10 and Steals >= 10) or
                
                (Points >= 10 and Blocks >= 10 and Steals >= 10) or
                
                (Assists >= 10 and DRebs+ORebs >= 10 and Blocks >= 10) or
                (Assists >= 10 and DRebs+ORebs >= 10 and Steals >= 10) or
                
                (Assists >= 10 and Blocks >= 10 and Steals >= 10) or
                
                (DRebs+ORebs >= 10 and Blocks >= 10 and Steals >= 10) 
                
                )')
            ->groupBy('PlayerID')
            ->orderBy('Stat', 'desc')
            ->get();

        return BoxScore::select('PlayerID')
        ->selectRaw('count(PlayerID) as Stat')
        ->selectRaw('count(PlayerID) as Games')
        ->whereIn('GameNo', BoxScore::getArrayDLeagueGameNo())
        ->where('Minutes', ">", 0) 
        ->where('GameNo', '>=', '2307')
        ->whereRaw('(
            
            (Points >= 10 and Assists >= 10 and DRebs+ORebs >= 10) or
            (Points >= 10 and Assists >= 10 and Blocks >= 10) or
            (Points >= 10 and Assists >= 10 and Steals >= 10) or
            
            (Points >= 10 and DRebs+ORebs >= 10 and Blocks >= 10) or
            (Points >= 10 and DRebs+ORebs >= 10 and Steals >= 10) or
            
            (Points >= 10 and Blocks >= 10 and Steals >= 10) or
            
            (Assists >= 10 and DRebs+ORebs >= 10 and Blocks >= 10) or
            (Assists >= 10 and DRebs+ORebs >= 10 and Steals >= 10) or
            
            (Assists >= 10 and Blocks >= 10 and Steals >= 10) or
            
            (DRebs+ORebs >= 10 and Blocks >= 10 and Steals >= 10) 
            
            )')
        ->groupBy('PlayerID')
        ->orderBy('Stat', 'desc')
        ->get();
    }

    static function fillSelect($selected, $avg){

        if($avg == "on")
            return '
            <option value="count(PlayerID)" ' . $selected[0] . '>Games</option>
            <option value="avg(Minutes)" ' . $selected[1] . '>Minutes Per Game</option>
            <option value="avg(Points)" ' . $selected[2] . '>Points Per Game</option>
            <option value="avg(Assists)" ' . $selected[3] . '>Assists Per Game</option>
            <option value="avg(ORebs+DRebs)" ' . $selected[4] . '>Rebounds Per Game</option>
            <option value="avg(Blocks)" ' . $selected[5] . '>Blocks Per Game</option>
            <option value="avg(Steals)" ' . $selected[6] . '>Steals Per Game</option>
            <option value="avg(FGA)" ' . $selected[7] . '>FGA Per Game</option>
            <option value="avg(FGM)" ' . $selected[8] . '>FGM Per Game</option>
            <option value="FG%" ' . $selected[9] . '>Field Goal %</option>
            <option value="avg(FG3PA)" ' . $selected[10] . '>3PA Per Game</option>
            <option value="avg(FG3PM)" ' . $selected[11] . '>3PM Per Game</option>
            <option value="FG3P%" ' . $selected[12] . '>3 Point %</option>
            <option value="avg(FTA)" ' . $selected[13] . '>FTA Per Game</option>
            <option value="avg(FTM)" ' . $selected[14] . '>FTM Per Game</option>
            <option value="FT%" ' . $selected[15] . '>Free Throw %</option>
            <option value="avg(Turnovers)" ' . $selected[16] . '>Turnovers Per Game</option>
            <option value="EFF" ' . $selected[17] . '>Player Efficiency</option>
            <option value="DoubleDoubles" ' . $selected[18] . '>Double Doubles</option>
            <option value="TripleDoubles" ' . $selected[19] . '>Triple Doubles</option>';

        return '
        <option value="count(PlayerID)" ' . $selected[0] . '>Games</option>
        <option value="sum(Minutes)" ' . $selected[1] . '>Minutes</option>
        <option value="sum(Points)" ' . $selected[2] . '>Points</option>
        <option value="sum(Assists)" ' . $selected[3] . '>Assists</option>
        <option value="sum(ORebs+DRebs)" ' . $selected[4] . '>Rebounds</option>
        <option value="sum(Blocks)" ' . $selected[5] . '>Blocks</option>
        <option value="sum(Steals)" ' . $selected[6] . '>Steals</option>
        <option value="sum(FGA)" ' . $selected[7] . '>Field Goal Attempts</option>
        <option value="sum(FGM)" ' . $selected[8] . '>Field Goals Made</option>
        <option value="FG%" ' . $selected[9] . '>Field Goal %</option>
        <option value="sum(FG3PA)" ' . $selected[10] . '>3 Point Attempts</option>
        <option value="sum(FG3PM)" ' . $selected[11] . '>3 Pointers Made</option>
        <option value="FG3P%" ' . $selected[12] . '>3 Point %</option>
        <option value="sum(FTA)" ' . $selected[13] . '>Free Throw Attempts</option>
        <option value="sum(FTM)" ' . $selected[14] . '>Free Throws Made</option>
        <option value="FT%" ' . $selected[15] . '>Free Throw %</option>
        <option value="sum(Turnovers)" ' . $selected[16] . '>Turnovers</option>
        <option value="EFF" ' . $selected[17] . '>Player Efficiency</option>
        <option value="DoubleDoubles" ' . $selected[18] . '>Double Doubles</option>
        <option value="TripleDoubles" ' . $selected[19] . '>Triple Doubles</option>';

    }

    static function checkedToggleButtons($avg, $sum, $rs, $po){

        $selecteds = [
            0 => '',
            1 => '',
            2 => '',
            3 => '',
        ];

        if($avg == 'on')
            $selecteds[0] = 'checked';
        if($sum == 'on')
            $selecteds[1] = 'checked';
        if($rs == 'on')
            $selecteds[2] = 'checked';
        if($po == 'on')
            $selecteds[3] = 'checked';

        return $selecteds;

    }

    static function selectedOption($stat){

        $selected = [
                0 => "",
                1 => "",
                2 => "",
                3 => "",
                4 => "",
                5 => "",
                6 => "",
                7 => "",
                8 => "",
                9 => "",
                10 => "",
                11 => "",
                12 => "",
                13 => "",
                14 => "",
                15 => "",
                16 => "",
                17 => "",
                18 => "",
                19 => "",
        ];

        if($stat == "count(PlayerID)")
            $selected[0] = "selected";
        if($stat == "avg(Minutes)" || $stat == "sum(Minutes)")
            $selected[1] = "selected";
        if($stat == "avg(Points)" || $stat ==  "sum(Points)")
            $selected[2] = "selected";
        if($stat == "avg(Assists)" || $stat ==  "sum(Assists)")
            $selected[3] = "selected";
        if($stat == "avg(DRebs+ORebs)" || $stat == "sum(DRebs+ORebs)")
            $selected[4] = "selected";
        if($stat == "avg(Blocks)" || $stat == "sum(Blocks)")
            $selected[5] = "selected";
        if($stat == "avg(Steals)" || $stat == "sum(Steals)")
            $selected[6] = "selected";
        if($stat == "avg(FGA)" || $stat == "sum(FGA)")
            $selected[7] = "selected";
        if($stat == "avg(FGM)" || $stat == "sum(FGM)")
            $selected[8] = "selected";
        if($stat == "FG%")
            $selected[9] = "selected";
        if($stat == "avg(FG3PA)" || $stat == "sum(FG3PA)")
            $selected[10] = "selected";
        if($stat == "avg(FG3PM)" || $stat == "sum(FG3PM)")
            $selected[11] = "selected";
        if($stat == "FG3P%")
            $selected[12] = "selected";
        if($stat == "avg(FTA)" || $stat == "sum(FTA)")
            $selected[13] = "selected";
        if($stat == "avg(FTM)" || $stat == "sum(FTM)")
            $selected[14] = "selected";
        if($stat == "FT%")
            $selected[15] = "selected";
        if($stat == "avg(Turnovers)" || $stat == "sum(Turnovers)")
            $selected[16] = "selected";
        if($stat == "EFF")
            $selected[17] = "selected";
        if($stat == "DoubleDoubles")
            $selected[18] = "selected";
        if($stat == "TripleDoubles")
            $selected[19] = "selected";

        return $selected;

    }

    static function selectedPosition($stat){

        $selected =  [
            0 => "",
            1 => "",
            2 => "",
            3 => "",
        ];

        if($stat == "All Positions")
            $selected[0] = "selected";
        if($stat == "Guards")
            $selected[1] = "selected";
        if($stat == "Forwards")
            $selected[2] = "selected";
        if($stat == "Centers")
            $selected[3] = "selected";

        return $selected;

    }

    static function changeOption($request, $stat){

        if($request->get('avg') == 'on' &&
            (
                $stat == "sum(Minutes)" ||
                $stat == "sum(Points)" ||
                $stat == "sum(Assists)" ||
                $stat == "sum(ORebs+DRebs)" ||
                $stat == "sum(Blocks)" ||
                $stat == "sum(Steals)" ||
                $stat == "sum(FGA)" ||
                $stat == "sum(FGM)" ||
                $stat == "sum(FG3PA)" ||
                $stat == "sum(FG3PM)"  ||
                $stat == "sum(FTA)" ||
                $stat == "sum(FTM)" ||
                $stat == "sum(Turnovers)"
            )
        )
            return str_replace("sum(", "avg(", $stat);

        else if($request->get('sum') == 'on' &&
            (
            $stat == "avg(Minutes)" ||
            $stat == "avg(Points)" ||
            $stat == "avg(Assists)" ||
            $stat == "avg(ORebs+DRebs)" ||
            $stat == "avg(Blocks)" ||
            $stat == "avg(Steals)" ||
            $stat == "avg(FGA)" ||
            $stat == "avg(FGM)" ||
            $stat == "avg(FG3PA)" ||
            $stat == "avg(FG3PM)"  ||
            $stat == "avg(FTA)" ||
            $stat == "avg(FTM)" ||
            $stat == "avg(Turnovers)"
            )
        )
            return str_replace("avg(", "sum(", $stat);

        else
            return $stat;

    }

    public function show(){
        return redirect("/dleagueleaders");
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\CoachHistory;
use App\Models\SeasonStat;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("/teamhistory/1");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function playerHistory($team)
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
  
        return view("team_history_player_history", compact("team"));
        
    }

    public function seasonRecaps($team)
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

        $recaps = CoachHistory::where("Team", "like", "%(HC)")
        ->where("TeamID", $team->TeamID)
        ->get();
  
        return view("team_history_season_recaps", compact("team", "recaps"));
        
    }

    public function draftHistory($team)
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

  
        return view("team_history_draft_history", compact("team"));
        
    }

    public function transactionHistory($team)
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

  
        return view("team_history_transaction_history", compact("team"));
        
    }

    public function coachRecords(Request $request, $team)
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

        $stat = $request->get('record');
        
        if(empty($stat))
            $stat = "Wins";

        $c = 0;
        $selected = $this::selectedOption3($stat);
        $seasonStats = $this->getCoachHistory($team, $stat);

        return view("team_history_coach_records", compact("team", 
        "seasonStats", 
        "stat", "c", 
        "selected"));
        
    }

    
    public function playerRecords(Request $request, $team)
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

        $stat = $request->get('record');
        $period = $request->get('period');

        if(empty($stat))
            $stat = "FGM";

        if(empty($period))
            $period = "1";

        if($period == 1)
            $seasonStats = $this::selectSingleSeasonStat($team, $stat);
        else
            $seasonStats = $this::selectCareerStat($team, $stat);

        $c = 0;
        $selected = $this::selectedOption($stat);
        $selected2 = $this::selectedOption2($period);

        return view("team_history_player_records", compact("team", 
        "seasonStats", 
        "stat", "c", 
        "selected", "selected2"));

    }

    static function selectSingleSeasonStat($team, $stat="FGM"){

        $seasonStats = SeasonStat::select("PlayerName", "Season", "PlayerID")
        ->selectRaw("SeasonID as Season")
        ->selectRaw("$stat as Stat")
        ->where('TeamID', $team->TeamID)
        ->take(30)
        ->groupBy("PlayerID")
        ->orderBy('Stat', 'desc')
        ->orderBy('Season', 'desc');

        $made = explode("Pct", $stat);

        if($stat == "FGPct"){
            
            $seasonStats->where($made[0] . "M", ">=", 300);

        } if($stat == "FTPct"){

            $seasonStats->where("FTM", ">=", 125);

        } if($stat == "FG3PPct"){

            $seasonStats->where("FG3PM", ">=", 82);
        }
            
        return $seasonStats->get();

    }

    static function selectCareerStat($team, $stat="FGM"){

        if($stat == "FGPct" || $stat == "FTPct" || $stat == "FG3PPct"){

            $madeArray = explode("Pct", $stat);
            $made = $madeArray[0];

            $seasonStats = SeasonStat::select("PlayerName", "PlayerID")
            ->selectRaw("MAX(SeasonID) as Season")
            ->selectRaw("CAST(avg(" . $made . "M) AS FLOAT) / avg(" . $made . "A) as Stat")
            ->where('TeamID', $team->TeamID)
            ->groupBy('PlayerID')
            ->take(30)
            ->orderBy('Stat', 'desc')
            ->orderBy('Season', 'desc');

            if($stat == "FGPct"){
            
                $seasonStats->selectRaw("SUM(FGM) as filter")
                ->having("filter", ">", 2000);
    
            } if($stat == "FTPct"){
    
                $seasonStats->selectRaw("SUM(FTM) as filter")
                ->having("filter", ">", 1200);
            }
            
            if($stat == "FG3PPct"){
    
                $seasonStats->selectRaw("SUM(FG3PM) as filter")
                ->having("filter", ">", 250);
            }

            return $seasonStats->get();

        }else{

            return SeasonStat::select("PlayerName", "PlayerID")
            ->selectRaw("max(SeasonID) as Season")
            ->selectRaw("SUM($stat) as Stat")
            ->where('TeamID', $team->TeamID)
            ->groupBy('PlayerID')
            ->take(30)
            ->orderBy('Stat', 'desc')
            ->orderBy('Season', 'desc')
            ->get();

        }

    }

    function getCoachHistory($team, $stat="Wins"){

        $coachHistory = CoachHistory::select("TeamID", "CoachName")
        ->where("TeamID", $team->TeamID)
        ->where("Team",'LIKE', '%(HC)')
        ->groupBy("CoachID");

        if($stat == "Wins")
            $coachHistory = $coachHistory->selectraw('SUM(Wins) as Stat');
        if($stat == "Losses")
            $coachHistory = $coachHistory->selectraw('SUM(Losses) as Stat');
        if($stat == "Win Percentage")
            $coachHistory = $coachHistory->selectRaw("CAST(SUM(Wins) AS FLOAT) 
            / SUM(Wins + Losses) as Stat");
        if($stat == "Playoff Appearances")
            $coachHistory = $coachHistory->selectraw('count(PostSeason) as Stat')
            ->where('PostSeason', '<>', '');
        if($stat == "Championships")
            $coachHistory = $coachHistory->selectraw('count(PostSeason) as Stat')
            ->where('PostSeason', 'like', '%Champions');

        return $coachHistory->orderBy('Stat', 'desc')->get();

    }

    static function selectedOption($stat="FGM"){

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
        ];

        if($stat == "FGM")
            $selected[0] = "selected";
        if($stat == "FGA")
            $selected[1] = "selected";
        if($stat == "FTM")
            $selected[2] = "selected";
        if($stat == "FTA")
            $selected[3] = "selected";
        if($stat == "FG3PM")
            $selected[4] = "selected";
        if($stat == "FG3PA")
            $selected[5] = "selected";
        if($stat == "FGPct")
            $selected[6] = "selected";
        if($stat == "FTPct")
            $selected[7] = "selected";
        if($stat == "FG3PPct")
            $selected[8] = "selected";
        if($stat == "Points")
            $selected[9] = "selected";
        if($stat == "Assists")
            $selected[10] = "selected";
        if($stat == "ORebs+DRebs")
            $selected[11] = "selected";
        if($stat == "Steals")
            $selected[12] = "selected";
        if($stat == "Blocks")
            $selected[13] = "selected";
        if($stat == "DoubleDoubles")
            $selected[14] = "selected";
        if($stat == "TripleDoubles")
            $selected[15] = "selected";
        if($stat == "G")
            $selected[16] = "selected";

        return $selected;

    }

    static function selectedOption2($stat=1){

        $selected = [
                0 => "",
                1 => "",
        ];

        if($stat == 1)
            $selected[0] = "selected";
        if($stat == 2)
            $selected[1] = "selected";

        return $selected;

    }

    static function selectedOption3($stat=1){

        $selected = [
                0 => "",
                1 => "",
                2 => "",
                3 => "",
                4 => "",
        ];

        if($stat == "Wins")
            $selected[0] = "selected";
        if($stat == "Losses")
            $selected[1] = "selected";
        if($stat == "Win Percentage")
            $selected[2] = "selected";
        if($stat == "Playoff Appearances")
            $selected[3] = "selected";
        if($stat == "Championships")
            $selected[4] = "selected";

        return $selected;

    }

}

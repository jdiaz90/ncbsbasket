<?php

namespace App\Http\Controllers;

use App\Models\SeasonStat;
use Illuminate\Http\Request;

class PlayerRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stat = "FGM"; //$request->get('record');
        $period = "1"; //$request->get('period');

        if(empty($stat))
            $stat = "FGM";

        if(empty($period))
            $period = "1";

        if($period == 1)
            $seasonStats = $this::selectSingleSeasonStat($stat);
        else
            $seasonStats = $this::selectCareerStat($stat);

        $c = 0;
        $selected = $this::selectedOption($stat);
        $selected2 = $this::selectedOption2($period);

        return view("player_records", compact("seasonStats", 
        "stat", "c", 
        "selected", "selected2"));


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    $stat = $request->get('record');
    $period = $request->get('period');

    if(empty($stat))
        $stat = "FGM";

    if(empty($period))
        $period = "1";

    if($period == 1)
        $seasonStats = $this::selectSingleSeasonStat($stat);
    else
        $seasonStats = $this::selectCareerStat($stat);

    $c = 0;
    $selected = $this::selectedOption($stat);
    $selected2 = $this::selectedOption2($period);

    return view("player_records", compact("seasonStats", 
    "stat", "c", 
    "selected", "selected2"));


    }

    static function selectSingleSeasonStat($stat="FGM"){

        $seasonStats = SeasonStat::select("PlayerName", "PlayerID")
        ->selectRaw("SeasonID as Season")
        ->selectRaw("$stat as Stat")
        ->take(30)
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

    static function selectCareerStat($stat="FGM"){

        if($stat == "FGPct" || $stat == "FTPct" || $stat == "FG3PPct"){

            $madeArray = explode("Pct", $stat);
            $made = $madeArray[0];

            $seasonStats = SeasonStat::select("PlayerName", "PlayerID")
            ->selectRaw("max(SeasonID) as Season")
            ->selectRaw("CAST(avg(" . $made . "M) AS FLOAT) / avg(" . $made . "A) as Stat")
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
            ->groupBy('PlayerID')
            ->take(30)
            ->orderBy('Stat', 'desc')
            ->orderBy('Season', 'desc')
            ->get();

        }

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

    public function show(){
        return redirect("/playerrecords");
    }



}

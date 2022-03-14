<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::select("TeamID")
        ->selectRaw("AVG(FG_RA) as FG_RA, AVG(FG_ITP) as FG_ITP, AVG(FG_MID) as FG_MID, AVG(FG_COR) as FG_COR, AVG(FG_ATB) as FG_ATB, AVG(FT) as FT, AVG(Scoring) as Scoring,
         AVG(Passing) as Passing, AVG(Handling) as Handling, AVG(OReb) as OReb, AVG(DReb) as DReb, AVG(Block) as Block, AVG(Steal) as Steal, AVG(Defender) as Defender, 
         AVG(Discipline) as Discipline, AVG(DrawFoul) as DrawFoul, AVG(BballIQ) as BballIQ, AVG(Endurance) as Endurance, AVG(Age) as Age, AVG(ProExperience) as ProExperience")
        ->groupBy("TeamID")
        ->where("TeamID", ">", 0)
        ->get();
        

        return view("team_list", compact("players"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        if ($team->TeamID == 31 || $team->TeamID == 32)
            return abort(404);
        
        $team['Transactions'] = $team->news();

        $team['PIE'] = $team->PIEGraph();

        $team['Leaders'] = $team->leaders();

        $findStats = '//div[@class="ui five column grid"]/div[@class="ui column"][3]';
        $arrayStats = $team->formatResult($team->searchResultInfo($findStats));

        $team['PPG'] = $arrayStats['PPG'];
        $team['OPPG'] = $arrayStats['OPPG'];
        $team['APG'] = $arrayStats['APG'];
        $team['RPG'] = $arrayStats['RPG'];
        
        return view("team", compact("team"));
        
    }

    static function htmlCodeLeaders($array, $title, $text, $text2){
        return "<script type=\"text/javascript\">
        Highcharts.chart('" . $text . "Graph', {
            chart: {
                type: 'bar',
            },
            title: {
                text: '$title Leaders'
            },
            xAxis: {
                categories: ['" . $array[0] . "', '" . $array[2] . "', '" . $array[4] . "'],
            },
            yAxis: {
                title: {
                    text: '$text per game',
                },
            },
            tooltip: {
                valueSuffix: ' $text2 per game'
            },
            series: [{
                name: '$text',
                data: 
                    [" . $array[1] . ", 
                    {
                        y: " . $array[3] . ",
                        color: '#BF0B23'
                    }, 
                    "  . $array[5] . "]
                }, 
            ],
            legend: {
                enabled: false
            },
        });
    </script>";
    }

}

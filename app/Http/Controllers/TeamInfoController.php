<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Champion;
use App\Models\Team;

class TeamInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("/teaminfo/1");
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

        $ownerInfo = $this->ownerInfo($team);
        $awardsCount = $this->countAwards($team->awards);

        return view("team_info", compact("team", "ownerInfo", "awardsCount"));
        
    }

    static function ownerInfo($team){

        $ownerInfo = [];
        $ownerInfo['Spend'] = $team->OwnerSpend * 20;
        $ownerInfo['SpendColor'] = TeamInfoController::ownerColor($team->OwnerSpend);
        $ownerInfo['Win'] = $team->OwnerWin * 20;
        $ownerInfo['WinColor'] = TeamInfoController::ownerColor($team->OwnerWin);
        $ownerInfo['Patience'] = $team->OwnerPatience * 20;
        $ownerInfo['PatienceColor'] = TeamInfoController::ownerColor($team->OwnerPatience);
        $ownerInfo['Star'] = $team->OwnerStar * 20;
        $ownerInfo['StarColor'] = TeamInfoController::ownerColor($team->OwnerStar);

        return $ownerInfo;

    }

    static function ownerColor($color){

        switch($color){
            case 0:
                return "";
            case 1:
                return "bg-danger";
            case 2:
                return "bg-info";
            case 3:
                return "bg-warning";
            case 4:
                return "";
            case 5:
                return "bg-success";
        }

    }

    static function countAwards($awards){

        $awardsCount =[
            'ta1' => 0,
            'ta2' => 0,
            'ta3' => 0,
            'ta4' => 0,
            'ta5' => 0,
            'ta6' => 0,
            'ta7' => 0,
            'ta8' => 0,
            'ta9' => 0,
            'ta10' => 0,
            'ta11' => 0,
            'ta12' => 0,
        ];

        foreach($awards as $award){
            if (str_contains($award->AwardName, 'Valuable')){
                $awardsCount['ta1']++;
                continue;
            }
           
            if (str_contains($award->AwardName, 'Defensive')){
                $awardsCount['ta2']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'Rookie of the Year')){
                $awardsCount['ta3']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'Sixth')){
                $awardsCount['ta4']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'Coach')){
                $awardsCount['ta5']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'All-League 1st')){
                $awardsCount['ta6']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'All-League 2nd')){
                $awardsCount['ta7']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'All-League 3rd')){
                $awardsCount['ta8']++;
                continue;
            }
             
            if (str_contains($award->AwardName, 'All-Defense 1st')){
                $awardsCount['ta9']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'All-Defense 2nd')){
                $awardsCount['ta10']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'All-Rookie 1st')){
                $awardsCount['ta11']++;
                continue;
            }
            
            if (str_contains($award->AwardName, 'All-Rookie 2nd')){
                $awardsCount['ta12']++;
                continue;
            }
            
        }
        
        return $awardsCount;

    }

}

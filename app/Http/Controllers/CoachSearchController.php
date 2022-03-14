<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\CoachHistory;
use App\Models\RetiredCoach;
use Illuminate\Support\Collection;

class CoachSearchController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MediaNew  $mediaNew
     * @return \Illuminate\Http\Response
     */
    public function show($search)
    {

        if(strlen($search) >= 3){

            $id = $search;
            $coaches = new Collection;

            $this->getCoachs($search, $coaches);
            $this->getFormerCoachs($search, $coaches);

            
            $coaches->unique();
    
    
            return view("coach_search", compact("id", "coaches"));

        }else{

            return abort(404);

        }
        
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("/coach");
    }

    static function getCoachs($search, Collection $coaches){

        $query = Coach::selectraw('*')
        ->selectraw('FirstName || " " || LastName AS FullName')
        ->where('FullName', 'LIKE', '%'. $search .'%')
        ->limit(10)
        ->get();

        
        foreach($query as $key => $coach){

            if($query[$key]->Team == "FA"){

                $franchise = "Free Agent";
                $imgLogo = "";

            }else{

                $franchise = $query[$key]->coachTeam->Franchise;
                $imgLogo = $query[$key]->coachTeam->ImgLogo;

            }

            $stats = CoachHistory::selectRaw("sum(Wins) as Wins, sum(Losses) as Losses")
            ->where("CoachID", $coach->CoachID)
            ->get()
            ->toArray()[0];
            
            if($stats['Wins'] == "")
                $stats['Wins'] = 0;

            if($stats['Losses'] == "")
                $stats['Losses'] = 0;

            $championships = CoachHistory::selectRaw("count(PostSeason) as Championships")
            ->where("CoachID", $coach->CoachID)
            ->where('PostSeason', 'LIKE', 'PBL Champions')
            ->get()[0]['Championships'];

            $coaches = $coaches->push([
            
                "PlayerID" => $query[$key]->CoachID,
                "Full_Name" => $query[$key]->Full_Name,
                "PlayerPhoto" => $query[$key]->PlayerPhoto,
                "CoachURL" => "/coach/" . $coach["CoachID"],
                "TeamID" => $query[$key]->TeamID,
                "Team" => $franchise,
                "ImgLogo" => $imgLogo,
                "Wins" => $stats['Wins'],
                "Losses" => $stats['Losses'],
                "Championships" => $championships,
                ]   

            );
        }

    }

    static function getFormerCoachs($search, Collection $coaches){

        $query = RetiredCoach::select("CoachID", "Wins1", "Losses1",  "Titles1")
        ->selectraw('FirstName || " " || LastName AS FullName')
        ->where('FullName', 'LIKE', '%'. $search .'%')
        ->get();

        
        foreach($query as $key => $coach){

            $find = false;

            foreach($coaches as $i => $item){

                if($item['Full_Name'] == $coach['FullName'] &&
                    $item['Wins'] == $coach['Wins1'] &&
                    $item['Losses'] == $coach['Losses1'] &&
                    $item['Championships'] == $coach['Titles1']){

                        $find = true;
                        break;

                    }

            }

            if(!$find){

                $coaches = $coaches->push([
                    
                    "PlayerID" => $query[$key]->CoachID,
                    "Full_Name" => $query[$key]->FullName,
                    "PlayerPhoto" => "/images/coach/" . str_replace(" ", "_", $query[$key]->FullName) . "png",
                    "CoachURL" => "N/A",
                    "TeamID" => 0,
                    "Team" => "N/A",
                    "ImgLogo" => "N/A",
                    "Wins" => $query[$key]->Wins1,
                    "Losses" => $query[$key]->Losses1,
                    "Championships" => $query[$key]->Titles1,
                    ]   

                );

            }        

        }
        
    }

   
}

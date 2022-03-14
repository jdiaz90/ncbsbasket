<?php

namespace App\Http\Controllers;

use App\Models\PastStanding;
use App\Models\SeasonPrev;

class SeasonPrevController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SeasonPrev  $seasonPrev
     * @return \Illuminate\Http\Response
     */
    public function show($seasonPrev)
    {

        if($seasonPrev == 31){

            $team = SeasonPrev::
            where("ConfID", 1)
            ->where("ConfRank", 1)
            ->get()->first()->TeamID;

            return redirect("/seasonprev/" . $team);

        }

         else if($seasonPrev == 32){

            $team = SeasonPrev::
            where("ConfID", 2)
            ->where("ConfRank", 1)
            ->get()->first()->TeamID;

            return redirect("/seasonprev/" . $team);

         }else
            $seasonPrev = SeasonPrev::find($seasonPrev);

        $maxSeason = PastStanding::selectRaw("MAX(Season) as LastYear")
        ->get()->first()->LastYear;

        $standings = SeasonPrev::select("TeamID")
        ->where("ConfID", $seasonPrev->ConfID)
        ->orderBy("ConfRank", "asc")
        ->get();

        $position = $seasonPrev->ConfRank;

        if($position == 1){

            $previous = seasonPrev::select("TeamID")
            ->where("ConfID", $seasonPrev->ConfID)
            ->where("ConfRank", 15)
            ->get()->first();

            $next = seasonPrev::select("TeamID")
            ->where("ConfID", $seasonPrev->ConfID)
            ->where("ConfRank", 2)
            ->get()->first();

        } else if ($position == 15){
            
            $previous = seasonPrev::select("TeamID")
            ->where("ConfID", $seasonPrev->ConfID)
            ->where("ConfRank", 14)
            ->get()->first();

            $next = seasonPrev::select("TeamID")
            ->where("ConfID", $seasonPrev->ConfID)
            ->where("ConfRank", 1)
            ->get()->first();

        } else {

            $previous = seasonPrev::select("TeamID")
            ->where("ConfID", $seasonPrev->ConfID)
            ->where("ConfRank", ($position - 1))
            ->get()->first();

            $next = seasonPrev::select("TeamID")
            ->where("ConfID", $seasonPrev->ConfID)
            ->where("ConfRank", ($position + 1))
            ->get()->first();

        }


        return view("seasonprev", compact("seasonPrev", "maxSeason", "standings", "previous", "next"));
    }

    public function index(){

        $team = SeasonPrev::select("TeamID")
        ->where("ConfID", 1)
        ->where("ConfRank", 1)
        ->get()->first()->TeamID;

        return redirect("/seasonprev/" . $team);

    }
    
    

}

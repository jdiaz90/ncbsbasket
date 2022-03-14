<?php

namespace App\Http\Controllers;

use App\Models\CoachHistory;
use Illuminate\Http\Request;

class CoachRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = 0;
        $stat = "Wins";

        $selected = $this->selectedOption();
        
        $coachHistory = CoachHistory::select("TeamID", "CoachName", "CoachID")
        ->where("Team",'LIKE', '%(HC)')
        ->where("TeamID", "<=", 30)
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

        $coachHistory = $coachHistory->orderBy('Stat', 'desc')->get();

        
        return View("coach_records", compact("c", "selected", "stat", "coachHistory"));


    }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $c = 0;
            $stat = $request->get('record');
    
            $selected = $this->selectedOption($stat);
            
            $coachHistory = CoachHistory::select("TeamID", "CoachName", "CoachID")
            ->where("Team",'LIKE', '%(HC)')
            ->where("TeamID", "<=", 30)
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
    
            $coachHistory = $coachHistory->orderBy('Stat', 'desc')->get();
    
            
            return View("coach_records", compact("c", "selected", "stat", "coachHistory"));
    
    
        }

    static function selectedOption($stat="Wins"){

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

    public function show(){
        return redirect("/coachrecords");
    }



}

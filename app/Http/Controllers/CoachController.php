<?php

namespace App\Http\Controllers;

use App\Models\Coach;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coaches = Coach::
        orderBy("TeamID", "asc")
        ->get();
        
        
        return view("coach_list", compact("coaches"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Coach $coach)
    {

        $coachHistory = $coach->coachHistory;

        if($coach->TeamID > 0)
            $otherInfo = $coach->getCoachOtherInfo();
        else
            $otherInfo = $coach->getFACoachOtherInfo();

        return view('coach', compact('coach', 'coachHistory', 'otherInfo'));

    }

}
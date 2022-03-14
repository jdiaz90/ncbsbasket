<?php

namespace App\Http\Controllers;

use App\Models\Draft;

class DraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consult = Draft::select('SeasonID')
        ->orderByDesc('SeasonID', 'desc')
        ->limit(1)
        ->get();

        $year = $consult[0]->SeasonID;

        $season = ['Year' => $year];
        
        $selections = Draft::where('SeasonID', $season)
        ->orderBy('Round','ASC')
        ->orderBy('Pick','ASC')
        ->get();

        $seasons = Draft::select('SeasonID')
        ->distinct()
        ->get()
        ->sortByDesc('SeasonID');

        return view("draft", compact("selections", "season", 
        "seasons"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Draft  $draft
     * @return \Illuminate\Http\Response
     */
    public function show($draft)
    {
        $selections = Draft::where('SeasonID', $draft)
        ->get();

        $season = ['Year' => $draft];

        $seasons = Draft::select('SeasonID')
        ->distinct()
        ->get()
        ->sortByDesc('SeasonID');

        return view("draft", compact("selections", "season", 
        "seasons"));
    }
    

}

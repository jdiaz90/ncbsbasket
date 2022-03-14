<?php

namespace App\Http\Controllers;

use App\Models\FantasyGuide;
use Illuminate\Http\Request;

class FantasyGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $position = 1;
        $fantasyguide = FantasyGuide::where('Position', $position)
        ->get();


        return View("fantasy_guide", compact("position", "fantasyguide"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $position = $request->get('position');

        $fantasyguide = FantasyGuide::where('Position', $position)
        ->get();


        return View("fantasy_guide", compact("position", "fantasyguide"));

    }

    public function show(){
        return redirect("/fantasyguide");
    }

}

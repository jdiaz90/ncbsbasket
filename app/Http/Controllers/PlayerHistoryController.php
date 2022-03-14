<?php

namespace App\Http\Controllers;

use App\Models\Team;

class PlayerHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teams = Team::where("TeamID","<=", 30)
        ->get();


        return View("playerhistory", compact("teams"));

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        return redirect("/playerhistory");      
        
    }

}
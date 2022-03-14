<?php

namespace App\Http\Controllers;

use App\Models\Team;


class DraftPickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $teams = Team::where("TeamID", "<=", 30)
        ->orderBy("CityName", "asc")
        ->get(); 

        return View("draft_picks", compact("teams"));
    }

    public function show(){
        return redirect("/draftpicks");
    }

}

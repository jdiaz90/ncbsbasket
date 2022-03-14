<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Collection;

class InjuryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::where("TeamID", ">", 0)
        ->where("TeamID", "<=", 30)
        ->get();


        return view("injury_report", compact("teams"));
    }

    public function show(){
        return redirect("/injuryreport");
    }

}

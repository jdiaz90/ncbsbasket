<?php

namespace App\Http\Controllers;

use App\Models\MediaNew;
use Illuminate\Http\Request;


class AwardHeadlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $selectedLeague = $this->checkLeague('P');

        $month = MediaNew::
        select("Day", "Story", "RefID", "MainTeam")
        ->where("Story", "LIKE", "%PBL Player of the Month%")
        ->orderBy("Day", "desc")
        ->get();
        $week = MediaNew::
        select("Day", "Story", "RefID", "MainTeam")
        ->where("Story", "LIKE", "%PBL Player of the Week%")
        ->orderBy("Day", "desc")
        ->get();
        $rookie = MediaNew::
        select("Day", "Story", "RefID", "MainTeam")
        ->where("Story", "LIKE", "%PBL Rookie of the Month%")
        ->orderBy("Day", "desc")
        ->get();


        return View("award_headlines", compact("selectedLeague", "month", "week", "rookie"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $selectedLeague = $this->checkLeague($request->get('league'));

        $league = $request->get('league') == "P" ? "PBL" : "DBL";

        $month = MediaNew::
        select("Day", "Story", "RefID", "MainTeam")
        ->where("Story", "LIKE", "%$league Player of the Month%")
        ->orderBy("Day", "desc")
        ->get();
        $week = MediaNew::
        select("Day", "Story", "RefID", "MainTeam")
        ->where("Story", "LIKE", "%$league Player of the Week%")
        ->orderBy("Day", "desc")
        ->get();
        $rookie = MediaNew::
        select("Day", "Story", "RefID", "MainTeam")
        ->where("Story", "LIKE", "%$league Rookie of the Month%")
        ->orderBy("Day", "desc")
        ->get();


        return View("award_headlines", compact("selectedLeague", "month", "week", "rookie"));


        }

        static function checkLeague($league){

            $selected =  [
                0 => "",
                1 => "",
            ];
    
            if($league == "P")
                $selected[0] = "selected";
            else
                $selected[1] = "selected";
    
            return $selected;
    
        }

        public function show(){
            return redirect("/awards");
        }

}

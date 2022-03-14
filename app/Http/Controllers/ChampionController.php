<?php

namespace App\Http\Controllers;

use App\Models\Champion;
use Illuminate\Http\Request;

class ChampionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $selectedLeague = $this->checkLeague("P");
        
        $champions = Champion::where("LeagueID", 1)
        ->orderBy("SeasonID", "desc")
        ->get();

        return view("champions", compact("selectedLeague", "champions"));

    
    }

    public function store(Request $request){

        $selectedLeague = $this->checkLeague($request->get('league'));

        if($request->get('league') == "P")
        
            $champions = Champion::where("LeagueID", 1)
            ->orderBy("SeasonID", "desc")
            ->get();

        else

            $champions = Champion::where("LeagueID", 2)
            ->orderBy("SeasonID", "desc")
            ->get();

        return view("champions", compact("selectedLeague", "champions"));

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
        return redirect("/champions");
    }

}

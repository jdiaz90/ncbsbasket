<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($search)
    {
        
        $id = $search;

        $players = new Collection;

        PlayerSearchController::getPlayers($id, $players);
        PlayerSearchController::getFormerPlayers($id, $players);

        $coaches = new Collection;

        CoachSearchController::getCoachs($id, $coaches);
        CoachSearchController::getFormerCoachs($id, $coaches);


        return view("search", compact("id", "players", "coaches"));

    }

    public function store(Request $request)
    {
        
        $id = $request->get('key');

        $players = new Collection;

        PlayerSearchController::getPlayers($id, $players);
        PlayerSearchController::getFormerPlayers($id, $players);

        $coaches = new Collection;

        CoachSearchController::getCoachs($id, $coaches);
        CoachSearchController::getFormerCoachs($id, $coaches);


        return view("search", compact("id", "players", "coaches"));

    }

    public function index(){
        return redirect("/player");
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\HallOfFame;
use Illuminate\Http\Request;

class HallOfFameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hofs = HallOfFame::all()
        ->sortByDesc('SeasonID');
    
        return view("hof", compact("hofs"));
        
    }

    public function show(){
        return redirect("/hof");
    }

}

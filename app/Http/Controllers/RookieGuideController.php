<?php

namespace App\Http\Controllers;

use App\Models\MockDraft;
use App\Models\TopRookie;
use Illuminate\Http\Request;

class RookieGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $position = 1;
        $rookieguide = TopRookie::where('Position', $position)
        ->get();


        return View("rookie_guide", compact("position", "rookieguide"));
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

        if($position <= 5)
            $rookieguide = TopRookie::where('Position', $position)
            ->get();
        else
            $rookieguide = MockDraft::all();


        return View("rookie_guide", compact("position", "rookieguide"));

    }

    public function show(){
        return redirect("/rookieguide");
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\MediaNew;

class MediaNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $news = MediaNew::where("MainTeam", "<=", 30)
        ->where("StoryValue",">", 8)
        ->orderBy("Day", "desc")
        ->orderBy("_rowid_", "asc")
        ->get();

        return view("media_news", compact("news"));

    }

    public function show(){
        return redirect("/medianews");
    }

    
}

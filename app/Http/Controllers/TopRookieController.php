<?php

namespace App\Http\Controllers;

use App\Models\TopRookie;
use App\Models\Player;
use Illuminate\Http\Request;

class TopRookieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toprookies = TopRookie::all()
        ->sortBy("Rank")
        ->sortBy("Position");

        $comparations = [];
        $count = 0;

        foreach($toprookies as $nbaplayer){
                $name = explode(' ', $nbaplayer->PlayerMatch);
                $comparation = Player::select('UniqueID')
                ->where('FirstName', $name[0] ?? "")
                ->where('LastName', $name[1] ?? "n/a")
                ->get();
                
                if(isset($comparation[0]))
                    $comparations[$count] = $comparation[0]->UniqueID;
                else
                    $comparations[$count] = "n/a";
                $count++;
        }

        return view("toprookies", compact('toprookies', 'comparations'));
    }


    public function show()
    {
        return redirect("/toprookies");
    }

}

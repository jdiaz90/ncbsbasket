<?php

namespace App\Http\Controllers;

use App\Models\MockDraft;

class MockDraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mockDraft = MockDraft::all()
        ->sortBy("Rank");

        return view("mockdraft", compact('mockDraft'));
    }

    public function show(){
        return redirect("/mockdraft");
    }
    
}

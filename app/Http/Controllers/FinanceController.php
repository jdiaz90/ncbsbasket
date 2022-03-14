<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\SalaryCap;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $finances = $this->getFinances();
        $capSpace =  $this->capSpace();
        

        return view("finances", compact("finances"));

    }

    static function getFinances(){

        $teams = Player::select("TeamID")
        ->selectraw("sum(ContractYear2) AS PayRoll_2, "
        . FinanceController::capSpace()." - sum(ContractYear2) AS Next_PayRoll_2")
        ->where("TeamID", ">", 0)
        ->where("TeamID", "<=", 30)
        ->groupBy("TeamID")
        ->orderBy("Team")
        ->get();

        return $teams;

    }

    static function capSpace(){

        return SalaryCap::where('_rowid_', '1')
        ->get()[0]['SalaryCap'];

    }

    public function show(){
        return redirect("/finances");
    }

}

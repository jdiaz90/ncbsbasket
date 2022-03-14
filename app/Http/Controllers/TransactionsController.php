<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $selected = $this->selectedOption(1);
        $selected2 = $this->selectedOption(1);

        $seasons = Transaction::selectRaw('distinct(Season)')
        ->orderBy('Season', 'desc')
        ->get()
        ->toArray();
        $days = [];

        $transactions = new Collection;
        $i = 0;

        foreach($seasons as $season){

            $union1 = Transaction::
            where('TeamID', '>', 0)
            ->where('TeamID', '<=', 30)
            ->where('Transaction', 'NOT LIKE', '% trade %')
            ->where('Transaction', 'NOT LIKE', 'Drafted by the%')
            ->where('Season', $season['Season'])
            ->get();
    
            $union2 = Transaction::
            where('TeamID', '>', 0)
            ->where('TeamID', '<=', 30)
            ->where('Transaction', 'LIKE', '% trade %')
            ->where('Season', $season['Season'])
            ->groupBy('Transaction')
            ->orderby('Key', 'desc')
            ->get();

            $moves = $union1->merge($union2)->sortByDesc('Key');
            $moves = $moves->groupBy('Day')->sortByDesc('Day');
    
             foreach ($moves as $key => $value){
    
                $day = Day::select('DayText')
                ->where('Id', strval($key))
                ->get()[0];
    
    
                $days[$i][$key] = $day['DayText'];
    
            }

            $i++;
            $transactions->push($moves);
      

        }


        return view("transactions", compact("selected", "selected2", "transactions", "days", "seasons"));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transaction $player)
    {

        $selected2 = $this->selectedOption($request->get('league'));
        $selected = $this->selectedOption($request->get('option'));

        if($request->get('league') == 1)
            $league = ["TeamID", "<=", 30];
        else
            $league = ["TeamID", ">", 30];

        $seasons = Transaction::selectRaw('distinct(Season)')
        ->orderBy('Season', 'desc')
        ->get()
        ->toArray();

        $days = [];

        $transactions = new Collection;
        $i = 0;

        foreach($seasons as $season){
            
            switch($request->get('option')){

                case 1:

                    $union1 = Transaction::
                    where([$league])
                    ->where('TeamID', '>', 0)
                    ->where('Transaction', 'NOT LIKE', '% trade %')
                    ->where('Transaction', 'NOT LIKE', 'Drafted by the%')
                    ->where('Season', $season['Season'])
                    ->get();
            
                    $union2 = Transaction::
                    where([$league])
                    ->where('TeamID', '>', 0)
                    ->where('Transaction', 'LIKE', '% trade %')
                    ->where('Season', $season['Season'])
                    ->groupBy('Transaction')
                    ->orderby('Key', 'desc')
                    ->get();

                    break;

                case  2:

                    $union1 = new Collection;
            
                    $union2 = Transaction::
                    where([$league])
                    ->where('TeamID', '>', 0)
                    ->where('Transaction', 'LIKE', '% trade %')
                    ->where('Season', $season['Season'])
                    ->groupBy('Transaction')
                    ->orderby('Key', 'desc')
                    ->get();

                    break;

                case 3:

                    $union1 = Transaction::
                    where([$league])
                    ->where('TeamID', '>', 0)
                    ->where('Season', $season['Season'])
                    ->whereRaw('("Transaction" LIKE "Signed by %" OR
                                "Transaction" LIKE "Released by %")')
                    ->get();

                    $union2 = new Collection;

                break;

                case 4:

                    $union1 = Transaction::
                    where([$league])
                    ->where('TeamID', '>', 0)
                    ->where('Season', $season['Season'])
                    ->whereRaw('("Transaction" LIKE "Assigned to %" OR
                                "Transaction" LIKE "Recalled from %")')
                    ->get();

                    $union2 = new Collection;

                break;

                case 5:

                    $union1 = Transaction::
                    where([$league])
                    ->where('TeamID', '>', 0)
                    ->where('Season', $season['Season'])
                    ->whereRaw('("Transaction" LIKE "% picked up %" OR
                                "Transaction" LIKE "Agreed to %")')
                    ->get();

                    $union2 = new Collection;

                break;

            }


            $moves = $union1->merge($union2)->sortByDesc('Key');
            $moves = $moves->groupBy('Day')->sortByDesc('Day');
    
             foreach ($moves as $key => $value){
    
                $day = Day::select('DayText')
                ->where('Id', strval($key))
                ->get()[0];
    
    
                $days[$i][$key] = $day['DayText'];
    
            }

            $i++;
            $transactions->push($moves);
      

        }


        return view("transactions", compact("selected", "selected2", "transactions", "days", "seasons"));

    }

    static function selectedOption($stat){

        $selected = [
                0 => "",
                1 => "",
                2 => "",
                3 => "",
                4 => "",
        ];

        if($stat == 1)
            $selected[0] = "selected";
        if($stat == 2)
            $selected[1] = "selected";
        if($stat == 3)
            $selected[2] = "selected";
        if($stat == 4)
            $selected[3] = "selected";
        if($stat == 5)
            $selected[4] = "selected";

        return $selected;

    }

    public function show()
    {
        return redirect("/transactions");
    }


}

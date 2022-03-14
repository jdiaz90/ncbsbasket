<?php

namespace App\Http\Controllers;

use App\Models\BoxScore;
use App\Models\Schedule;
use Illuminate\Support\Facades\Cache;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $datas = [];

        if (!Cache::has("Schedule")){

            $highsPoints = BoxScore::select("GameNo", "PlayerID")
            ->selectRaw("MAX(Points) as HPoints")
            ->where("HomeScore", ">", 0)
            ->groupBy("GameNo")
            ->get()
            ->keyBy('GameNo');

            $highsAssists = BoxScore::select("GameNo", "PlayerID")
            ->selectRaw("MAX(Assists) as HAssists")
            ->where("HomeScore", ">", 0)
            ->groupBy("GameNo")
            ->get()
            ->keyBy('GameNo');

            $highsRebounds = BoxScore::select("GameNo", "PlayerID")
            ->selectRaw("MAX(DRebs+ORebs) as HRebounds")
            ->where("HomeScore", ">", 0)
            ->groupBy("GameNo")
            ->get()
            ->keyBy('GameNo');

            $schedule = Schedule::select("GameNo", "Day", "Visitor", "Home", "VisitorScore", "HomeScore")
            ->where("HomeScore", ">", 0)
            ->get();

            $schedule = $schedule->groupBy("Day");

            $datas['Schedule'] = $schedule;
            $datas['Points'] = $highsPoints;
            $datas['Assists'] = $highsAssists;
            $datas['Rebounds'] = $highsRebounds;

            Cache::put("Schedule", $datas, now()->addDays(1));

        }$datas = Cache::get("Schedule");

        $schedule = $datas['Schedule']; 
        $highsPoints = $datas['Points']; 
        $highsAssists = $datas['Assists']; 
        $highsRebounds = $datas['Rebounds']; 
        

        return view("schedule", compact("schedule", "highsPoints", "highsAssists", "highsRebounds"));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show($schedule)
    {
        $schedule = Schedule::findorfail($schedule);

        $stats['Visitor'] = $schedule->getTeamGameStats();
        $stats['Home'] = $schedule->getTeamGameStats(3);

        $stats['VisitorFinal'] = $schedule->VisitorOT > 0 ? $schedule->VisitorOT : $schedule->VisitorQ4;
        $stats['HomeFinal'] = $schedule->HomeOT > 0 ? $schedule->HomeOT : $schedule->HomeQ4;

        $stats['MVP'] = $schedule->getMVPStats();

        return view("game", compact("schedule", "stats"));

    }

}

<?php

namespace App\Providers;

use App\Models\BoxScore;
use App\Models\HallOfFame;
use App\Models\Player;
use App\Models\SeasonStat;
use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->teams();
        $this->topPoints();
        $this->topAssists();
        $this->topRebounds();
        $this->historicalPlayers();

    }

    static function topPoints0Games(){

        $season = SeasonStat::selectRaw("max(SeasonID) as Season")
        ->get()[0]['Season'];

        $query = SeasonStat::select("PlayerID", "PlayerName")
        ->where("SeasonID", $season)
        ->orderBy("Points", "desc")
        ->limit(5)
        ->get();

        View::share('topPoints', $query);

    }

    static function topPoints(){

        $query = BoxScore::selectRaw("avg(Points) as Stat, PlayerID")
        ->join("Schedule", "BoxScore.GameNo", "=", "Schedule.GameNo")
        ->groupBy("PlayerID")
        ->orderBy("Stat", "desc")
        ->limit(5)
        ->get();

        if(count($query) > 0)

            View::share('topPoints', $query);

        else

            AppServiceProvider::topPoints0Games();

    }

    static function topAssists0Games(){

        $season = SeasonStat::selectRaw("max(SeasonID) as Season")
        ->get()[0]['Season'];

        $query = SeasonStat::select("PlayerID", "PlayerName")
        ->where("SeasonID", $season)
        ->orderBy("Assists", "desc")
        ->limit(5)
        ->get();

        View::share('topAssists', $query);

    }

    static function topAssists(){

        $query = BoxScore::selectRaw("avg(Assists) as Stat, PlayerID")
        ->join("Schedule", "BoxScore.GameNo", "=", "Schedule.GameNo")
        ->groupBy("PlayerID")
        ->orderBy("Stat", "desc")
        ->limit(5)
        ->get();

        if(count($query) > 0)

            View::share('topAssists', $query);

        else

            AppServiceProvider::topAssists0Games();

    }

    static function topRebounds0Games(){

        $season = SeasonStat::selectRaw("max(SeasonID) as Season")
        ->get()[0]['Season'];

        $query = SeasonStat::select("PlayerID", "PlayerName")
        ->where("SeasonID", $season)
        ->orderBy("Assists", "desc")
        ->limit(5)
        ->get();

        View::share('topAssists', $query);

    }

    static function topRebounds(){

        $query = BoxScore::selectRaw("avg(DRebs+ORebs) as Stat, PlayerID")
        ->join("Schedule", "BoxScore.GameNo", "=", "Schedule.GameNo")
        ->groupBy("PlayerID")
        ->orderBy("Stat", "desc")
        ->limit(5)
        ->get();

        if(count($query) > 0)

            View::share('topRebounds', $query);

        else

            AppServiceProvider::topRebounds0Games();

    }

    static function historicalPlayers(){

        $query = HallOfFame::select("PlayerID", "PlayerName")
        ->orderBy("Points", "desc")
        ->limit(5)
        ->get();

        View::share('historicalPlayers', $query);

    }
    

    static function teams(){

        $query = Team::select("TeamID", "CityName", "TeamName")
        ->where("TeamID", "<=", 30)
        ->get();

        $teams = new Collection;

        foreach($query as $team){

            switch($team->otherInfo->DivisionID){

                case 1: 
                    $division = "Atlantic Division";
                    break;
                case 2: 
                    $division = "Central Division";
                    break;
                case 3: 
                    $division = "Southeast Division";
                    break;
                case 4: 
                    $division = "Southwest Division";
                    break;
                case 5: 
                    $division = "Northwest Division";
                    break;
                case 6: 
                    $division = "Pacific Division";
                    break;

            }

            $players = Player::select("PlayerID", "FirstName", "LastName")
            ->where("TeamID", $team->TeamID)
            ->orderBy("Position asc")
            ->get();

            $teams->push(

                [
                    "TeamID" => $team->TeamID,
                    "Division" => $division,
                    "Franchise" => $team->Franchise,
                    "ImgLogo" => $team->ImgLogo,
                    "Players" => $players,
                ]

            );
        }

        $teams = $teams->groupBy('Division');

        View::share('navBarTeams', $teams);

        $query = Team::select("TeamID", "CityName", "TeamName")
        ->where("TeamID", ">", 32)
        ->get();

        $teams = new Collection;

        foreach($query as $team){

            if($team->TeamID >= 33 && $team->TeamID < 41)
                $division = "East Division";

            else if($team->TeamID >= 41 && $team->TeamID < 49)
                $division = "South Division";

            else if($team->TeamID >= 49 && $team->TeamID < 57)
                $division = "Central Division";

            else
                $division = "West Division";
                
            
                $players = Player::select("PlayerID", "FirstName", "LastName")
            ->where("TeamID", $team->TeamID)
            ->orderBy("Position asc")
            ->get();

            $teams->push(

                [
                    "TeamID" => $team->TeamID,
                    "Division" => $division,
                    "Franchise" => $team->Franchise,
                    "ImgLogo" => $team->ImgLogo,
                    "Players" => $players,
                ]

            );
        }

        $teams = $teams->groupBy('Division');

        View::share('dNavBarTeams', $teams);

    }


}

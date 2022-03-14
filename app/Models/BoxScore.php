<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Custom\Stats;

class BoxScore extends Stats
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $connection = 'sqlite3';
    protected $table = 'BoxScore';
    protected $primaryKey = '_rowid_';
    public $incrementing = false;

    function schedule(){
        return $this->hasOne(Schedule::class, 'GameNo', 'GameNo');
    }

    function player(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID');
    }

    function getPIEAttribute(){

        /* PIE Formula=(PTS + FGM + FTM - FGA - FTA + DREB + (.5 * OREB) + AST + STL + (.5 * BLK) - PF - TO) 
        / (GmPTS + GmFGM + GmFTM - GmFGA - GmFTA + GmDREB + (.5 * GmOREB) + GmAST + GmSTL + (.5 * GmBLK) - GmPF - GmTO */

        //PTS + FGM + FTM - FGA - FTA + DREB + (.5 * OREB) + AST + STL + (.5 * BLK) - PF - TO)
        $part1 = $this->selectRaw("sum(Points + FGM + FTM - FGA - FTA + DRebs + (0.5 * Orebs) + Assists + Steals + (0.5 * Blocks) - Fouls - Turnovers) AS PIE1")
        ->where('GameNo', $this->GameNo)
        ->where('PlayerId', $this->PlayerID)
        ->get()
        ->toArray();

        //(GmPTS + GmFGM + GmFTM - GmFGA - GmFTA + GmDREB + (.5 * GmOREB) + GmAST + GmSTL + (.5 * GmBLK) - GmPF - GmTO
        $part2 = $this->selectRaw("sum(Points + FGM + FTM - FGA - FTA + DRebs + (0.5 * Orebs) + Assists + Steals + (0.5 * Blocks) - Fouls - Turnovers) AS PIE2")
        ->where('GameNo', $this->GameNo)
        ->get()
        ->toArray();

        $pie[0] = $part1[0]['PIE1'];
        $pie[1] = $part2[0]['PIE2'];

        return round($pie[0] / $pie[1] * 100, 2);

    }

    function getSeasonTeams(){

        $playerID = $this->player->UniqueID;

        $playerTeams = [];

        $maxSeason = Transaction::selectRaw("MAX(Season) as SeasonID")
        ->get()->first()['SeasonID'];

        $trades = Transaction::select("Transaction", "TeamID", "Day")
        ->where("PlayerID", $playerID)
        ->where("Transaction", "LIKE", "% trade %")
        ->where("Season", $maxSeason)
        ->get();

        if($trades->count() > 0){

            $teams = Team::select("TeamID", "TeamName")
            ->selectRaw('CityName || " " || TeamName as Franchise')
            ->where("TeamID", "<=", 30)
            ->get()
            ->toArray();

            foreach($trades as $key => $trade){
                foreach($teams as $team){
                    if($trade['TeamID'] == $team['TeamID'])
                        $trades[$key]['Transaction'] = str_replace($team['TeamName'], "", $trade['Transaction']);
                }
            }

            foreach($trades as $trade){
                foreach($teams as $team){
                    if(str_contains($trade['Transaction'], $team['TeamName']))
                        array_push($playerTeams, [
                            "Day" => $trade['Day'],
                            "TeamName" => $team['TeamName'],
                            "Franchise" => $team['Franchise'],
                        ]
                    );
                }
            }

            $teams = [];
            
            foreach($playerTeams as $key => $team){
                
                do{
                    if($team['Day'] < 120)
                        $day = 120;
                    else
                        $day = $team['Day'];

                    $firstGame = Schedule::select("GameNo")
                    ->where("Day", "LIKE", getDaytoDayText($day) ."%")
                    ->orderBy('Key', 'asc')
                    ->limit(1)
                    ->get()
                    ->toArray();

                    $c = count($firstGame);

                    if($c <> 0)
                        array_push($teams,[
                            "GameNo" => $firstGame[0]['GameNo'],
                            "TeamName" => $team['TeamName'],
                            "Franchise" => $team['Franchise'],
                            ]
                        );
                    else
                        $day++;

                }while($c == 0);

            }

            return $teams;

        } else {
            return [
                [
                "GameNo" => 83,
                "TeamName" => $this->player->team->TeamName,
                "Franchise" => $this->player->team->Franchise,
                ]
            ];
        }
    }

    function getTeamForThatDayAttribute(){

        $team = null;

        foreach($this->getSeasonTeams() as $seasonTeam){
            if($this->GameNo >= $seasonTeam['GameNo'])
                $team = $seasonTeam;
        }

        if($team <> null)
            return $team;

    }

    function Opponent(){

        $pos = strpos(
            $this->schedule->Home, $this->Player->Franchise);
            
        // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
        if($pos === false)
            return $this->schedule->Home;
        return $this->schedule->Visitor;
    }

    function Starter(){
        if($this->Starter == 1)
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
      </svg>';
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg>';
    }

    function getPlayerNameAttribute(){

        return $this->player->AbName;

    }

    
    function getLastNameAttribute(){

        return $this->player->LastName;

    }

    static function getArrayDLeagueGameNo(){

        $dLeague = [];

        $schedule = Schedule::select('GameNo')
        ->orderBy('GameNo', 'asc')
        ->get()
        ->toArray();

        $aux['GameNo'] = 2305; 
        array_push($schedule, $aux);
        $aux['GameNo'] = 2306; 
        array_push($schedule, $aux);

        $boxScore = BoxScore::selectRaw('distinct(GameNo)')
        ->orderBy('GameNo', 'asc')
        ->get()
        ->toArray();

        foreach($boxScore as $calendar){
            $found = 0;
            foreach($schedule as $game){
                if($calendar['GameNo'] == $game['GameNo']){
                    $found = $game['GameNo'];
                    break;
                }      
            }

            if($found == 0){
                array_push($dLeague, $calendar['GameNo']);
            }
                
        }

        return $dLeague;

    }

}




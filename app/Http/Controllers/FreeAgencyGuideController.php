<?php

namespace App\Http\Controllers;

use App\Models\BoxScore;
use App\Models\Player;
use App\Models\Team;
use ErrorException;
use Goutte\Client;
use Illuminate\Support\Collection;

class FreeAgencyGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $IDs = Player::select("PlayerID")
        ->where("ContractYear1", ">", 125000)
        ->where("ContractYear2", 0)
        ->get()
        ->toArray();

        $toIDs = $this->getIDs($this->getOptionsIDs());
        $poIDs = $this->getIDs($this->getOptionsIDs("PO"));

        $IDs = array_merge($IDs, $toIDs, $poIDs);

        $playersQuery = $this->getPlayer($IDs);
        $avgsQuery = $this->getAvgs($IDs);

        $avgs = [];

        foreach($avgsQuery as $player){

            $avgs[$player->PlayerID]['PPG'] = $player->PPG;
            $avgs[$player->PlayerID]['APG'] = $player->APG;
            $avgs[$player->PlayerID]['RPG'] = $player->RPG;
            $avgs[$player->PlayerID]['SPG'] = $player->SPG;
            $avgs[$player->PlayerID]['BPG'] = $player->BPG;

        }

        $players = new Collection;

        foreach($playersQuery as $player){

            $type = "";
            $finish = false;

            try{

                foreach($toIDs as $toID){
                    if($toID['PlayerID'] == $player->PlayerID){
                        $type = "TEAM OPTION";
                        $finish = true;
                        break;
                    }

                }

                if($type <> "TEAM OPTION"){
                    foreach($poIDs as $poID){
                        if($poID['PlayerID'] == $player->PlayerID){
                            $type = "PLAYER OPTION";
                            $finish = true;
                            break;
                        }

                    }   

                }

                if(!$finish)
                    if($player->ProExperience == 3 && $player->DraftRound == 1){
                        $type = "RESTRICTED FREE AGENT";
                    }

                    else{
                        $type = "UNRESTRICTED";
                    }

                $this->setPlayerWithStats($players, $player, $avgs, $type);

            } catch (ErrorException $e){

                $finish = false;

                foreach($toIDs as $toID){
                    if($toID['PlayerID'] == $player->PlayerID){
                        $type = "TEAM OPTION";
                        $finish = true;
                        break;
                    }

                }

                if($type <> "TEAM OPTION"){
                    foreach($poIDs as $poID){
                        if($poID['PlayerID'] == $player->PlayerID){
                            $type = "PLAYER OPTION";
                            $finish = true;
                            break;
                        }

                    }   

                }

                if(!$finish)
                    if($player->ProExperience == 3 && $player->DraftRound == 1){
                        $type = "RESTRICTED FREE AGENT";
                    }

                    else{
                        $type = "UNRESTRICTED";
                    }

                $this->setPlayerWithoutStats($players, $player, $type);

            }

        }


        return View("free_agency_guide", compact("players"));
    }


    static function setPlayerWithStats($players, $player, $avgs, $type){

        $players->put($player->PlayerID,
                
            [
                "Name" =>  $player->Full_Name,
                "Position" => $player->Position,
                "AbPosition" => $player->AbPosition,
                "Team" => $player->Franchise,
                "TeamID" => $player->team->TeamID,
                "Salary" => $player->ContractYear1,
                "PPG" => number_format($avgs[$player->PlayerID]['PPG'], 1),
                "APG" => number_format($avgs[$player->PlayerID]['APG'], 1),
                "RPG" => number_format($avgs[$player->PlayerID]['RPG'], 1),
                "SPG" => number_format($avgs[$player->PlayerID]['SPG'], 1),
                "BPG" => number_format($avgs[$player->PlayerID]['BPG'], 1),
                "Type" => $type,
                "Overall" => $player->currentRating(),
            ]
        
        );

    }

    static function setPlayerWithoutStats($players, $player, $type){

        $players->put($player->PlayerID,
                
            [
                "Name" =>  $player->Full_Name,
                "Position" => $player->Position,
                "AbPosition" => $player->AbPosition,
                "Team" => $player->Franchise,
                "TeamID" => $player->team->Franchise,
                "Salary" => $player->ContractYear1,
                "PPG" => number_format(0, 1),
                "APG" => number_format(0, 1),
                "RPG" => number_format(0, 1),
                "SPG" => number_format(0, 1),
                "BPG" => number_format(0, 1),
                "Type" => $type,
                "Overall" => $player->currentRating(),
            ]
        
        );

    }

    static function getOptionsIDs($option = "TO"){

        $teams = Team::where("TeamID", ">", 0)
        ->where("TeamID", "<=", "30")
        ->get();

        $client = new Client();
        
        $ids = new Collection;

        foreach($teams as $team){

            $crawler = $client->request('GET', 
            "/html/" . $team->TeamAbbrev . "" 
            . $team->TeamName. "_Ratings.html");
            
 
            $crawler->filterXPath('//table[@class="ui selectable basic table"][2]
                /tbody
                /tr')
                ->each(function($tr) use($team, $ids, $option){

                    foreach($team->players as $player){

                        if(str_contains($tr->text(), "($option)---") &&
                            str_contains($tr->text(), $player->Full_Name)){
                                
                            $ids->push(explode(".", $tr->filter("td")
                                ->eq(1)
                                ->filter("a")
                                ->eq(0)
                                ->attr("href"))[0]
                            );
                                
                        }

                    }

                });

        }

        return $ids;

    }

    static function getPlayer($playersID){

        return Player::
        whereIn("PlayerID", $playersID)
        ->orderBy("Position", "Asc")
        ->get();

    }

    static function getAvgs($playersID){

        return BoxScore::selectRaw("PlayerID,
        avg(Points) as PPG,
        avg(Assists) as APG,
        avg(DRebs + ORebs) as RPG,
        avg(Steals) as SPG,
        avg(Blocks) as BPG") 
        ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')
        ->whereIn("PlayerID", $playersID)
        ->where('BoxScore.GameNo', "<", 2305)  
        ->where('Minutes', ">", 0) 
        ->groupBy('PlayerID')
        ->get();

    }

    static function getIDs($uniquesID){

        $ids = [];

        foreach($uniquesID as $uniqueID){

            array_push($ids, Player::select("PlayerID")
            ->where("UniqueID", $uniqueID)
            ->get()
            ->toArray()[0]);

        }

        return $ids;

    }

    public function show(){
        return redirect("/freeagencyguide");
    }


}
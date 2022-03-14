<?php

namespace App\Http\Controllers;

use App\Models\Player;
use ErrorException;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $selectedLeague = $this->checkLeague("P");
        $selectedButtons = $this->checkButtons();


        $players = Player::where("TeamID", ">", 0)
        ->where("TeamID", "<=", 30)
        ->orderby("TeamID", "asc")
        ->get();

        return View("player_list", compact("selectedLeague", "selectedButtons", "players"));

    }

    public function store(Request $request)
    {
  
        $selectedLeague = $this->checkLeague($request->get('league'));
        $positions = $request->get('position');
        $selectedButtons = $this->checkButtons($positions);

        if($request->get('league') == "P")

            $players = Player::where("TeamID", ">", 0)
            ->where("TeamID", "<=", 30)
            ->whereIn("Position", $positions)
            ->orderby("TeamID", "asc")
            ->get();

        else if ($request->get('league') == "D")

            $players = Player::where("TeamID", ">", 32)
            ->whereIn("Position", $positions)
            ->orderby("TeamID", "asc")
            ->get();

        else

            $players = Player::where("TeamID", 0)
            ->whereIn("Position", $positions)
            ->orderby("TeamID", "asc")
            ->get();


        return View("player_list", compact("selectedLeague", "selectedButtons", "players"));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {

        $player['CurrentSeason'] = $player->currentSeason();


        $findContracts = '//div[@class="column"]/div[@class="ui list"]/div[@class="item"]/div[@class="content"]';
        $player['Contracts'] = $player->searchResult($findContracts); 


        $findAchievements = '//div[@class="ui bulleted list"]/div[@class="item"]';
        $player['Achievements'] = $player->getAchievementsArray($player->searchResult($findAchievements));


        $player['PlayerType'] = $this->checkType($player->getPlayerType());
        $dataToggle = $this->checkDataToggle($player->getPlayerType());

        try {

            $teamColor = $player->team->TeamColor;
            $franchise = $player->franchise;
        
        } catch(ErrorException $e){
            $teamColor = "#808000";
            $franchise = "Free Agent";
        }
        

        return view('player', compact('player', 'dataToggle', 'teamColor', 'franchise'));
        
        
    }

    static function checkLeague($league){

        $selected =  [
            0 => "",
            1 => "",
            2 => "",
        ];

        if($league == "P")
            $selected[0] = "selected";
        else if($league == "D")
            $selected[1] = "selected";
        else
            $selected[2] = "selected";

        return $selected;

    }

    static function checkButtons($positions = [1, 2, 3, 4, 5]){

        $selected =  [
            1 => "",
            2 => "",
            3 => "",
            4 => "",
            5 => "",
        ];

        foreach($positions as $position){

            switch($position){

                case 1:
                    $selected[1] = 'checked';
                    break;

                case 2:
                    $selected[2] = 'checked';
                    break;

                        
                case 3:
                    $selected[3] = 'checked';
                    break;

                    
                case 4:
                    $selected[4] = 'checked';
                    break;

                    
                case 5:
                    $selected[5] = 'checked';
                    break;

            }

        }

        return $selected;

    }

    function checkType($types){

        $css =  [];

        foreach($types as $type){

            switch($type){

                case "Bucket Getter":
                    array_push($css, ".fa-fill");
                    break;

                case "Sharpshooter":
                    array_push($css, ".fa-crosshairs");
                    break;
        
                case "Attacker":
                    array_push($css, ".fa-bolt-lightning");
                    break;
                    
                case "Paint Dominator":
                    array_push($css, ".fa-paint-roller");
                    break;

                case "Ball Magician":
                    array_push($css, ".fa-hat-wizard");
                    break;

                case "Playmaker":
                    array_push($css, ".fa-wand-magic-sparkler");
                    break;
                    
                case "Defender":
                    array_push($css, ".fa-shield");
                    break;
                    
                case "Clean Up":
                    array_push($css, ".fa-paintbrush");
                    break;

            }

        }

        return $css;

    }

    function checkDataToggle($types){

        $selected =  [
            0 => "",
            1 => "",
            2 => "",
            3 => "",
            4 => "",
            5 => "",
            6 => "",
            7 => "",
        ];

        foreach($types as $type){

            switch($type){

                case "Bucket Getter":
                    $selected[0] ='data-toggle="tooltip" data-placement="right"';
                    break;

                case "Sharpshooter":
                    $selected[1] ='data-toggle="tooltip" data-placement="right"';
                    break;
        
                case "Attacker":
                    $selected[2] ='data-toggle="tooltip" data-placement="right"';
                    break;
                    
                case "Paint Dominator":
                    $selected[3] ='data-toggle="tooltip" data-placement="right"';
                    break;

                case "Ball Magician":
                    $selected[4] ='data-toggle="tooltip" data-placement="right"';
                    break;

                case "Playmaker":
                    $selected[5] ='data-toggle="tooltip" data-placement="right"';
                    break;

                case "Defender":
                    $selected[6] ='data-toggle="tooltip" data-placement="right"';
                    break;

                case "Clean Up":
                    $selected[7] ='data-toggle="tooltip" data-placement="right"';
                    break;


            }

        }

        return $selected;

    }

}
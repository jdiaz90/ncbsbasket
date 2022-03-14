<?php


function printAward($award){

        $award = str_replace(["PBL ", "DBL "], "", $award);

        switch($award){

            case "Most Valuable Player":

                return "/images/trophies/mvp.png";

            case "Defensive Player of the Year":

                return "/images/trophies/dpoy.png";

            case "Rookie of the Year":

                return "/images/trophies/roy.png";

            case "Sixth Man of the Year":

                return "/images/trophies/sixthman.png";

            case "Coach of the Year":

                return "/images/trophies/coach.png";

            case "All-League 1st Team":

                return "/images/trophies/allleague1.png";

            case "All-League 2nd Team":

                return "/images/trophies/allleague2.png";

            case "All-League 3rd Team":

                return "/images/trophies/allleague3.png";

            case "All-Defense 1st Team":

                return "/images/trophies/alldefense1.png";

            case "All-Defense 2nd Team":

                return "/images/trophies/alldefense2.png";

            case "All-Rookie 1st Team":

                return "/images/trophies/allrookie1.png";

            case "All-Rookie 2nd Team":

                return "/images/trophies/allrookie2.png";
        }

}

function getTeamAbbrev($teamName){

    $team = \App\Models\Team::select("TeamAbbrev")
    ->where("TeamName", $teamName)
    ->where("TeamID", "<=", 30)
    ->get();

    if($team->count() > 0)
        return $team->first()->TeamAbbrev;
    return "-";

}

function getFormerPlayerID($name){

    $player = \App\Models\SeasonStat::selectraw("distinct(PlayerID)")
    ->where("PlayerName", $name)
    ->get();

    if($player->count() > 0)
        return $player->first()->PlayerID;
    return "0";

}

function getDaytoDayText($day){

    $player = \App\Models\Day::selectraw("DayText")
    ->where("Id", (String)$day)
    ->get()
    ->toArray()[0]['DayText'];

    return $player;

}

function progress($value, $text){
    $style = "style='width: $value%'";
    $colour = "";
    if($value < 40){
        $colour = "bg-danger";
    }else if($value < 70){
        $colour = "bg-warning";
    }else if($value < 90){
        $colour = "bg-success";
    }
    return "<div class='progress'>
<div class='progress-bar progress-bar-striped progress-bar-animated $colour' role='progressbar' aria-valuenow='$value' aria-valuemin='0' aria-valuemax='100' $style>$text</div>
</div>";
}

function moneyFormat($value){
    if($value == 0){
        return "N/A";
    }return "$" . number_format($value, "0", ",", ".");
}

function roundSeasonPrev($value){

    return str_replace(".", ",", round($value, 1));

}

?>
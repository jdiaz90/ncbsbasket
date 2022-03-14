<?php

$connection = new SQLite3('/home/vagrant/code/ncbsbasket/storage/app/public/career.pbb');
$connection2 = new SQLite3('/home/vagrant/code/ncbsbasket/storage/app/public/MNLedit.db');
 
$html = '';
$key = $_POST['key'];

$players = [];
$players2 = [];
$coaches = [];
$teams = [];
 
$result = $connection2->query(
    'SELECT FirstName || " " || LastName AS FullName, FirstName, LastName, PlayerID, UniqueID 
        FROM Players
        WHERE FullName LIKE "%' . $key . '%"
        ORDER BY LastName ASC');

while ($row = $result->fetchArray()) {  
    array_push($players, [
        "PlayerID" => $row['PlayerID'],
        "UniqueID" => $row['UniqueID'],
        "FullName" => $row['FullName'],
    ]);           
}   

$result2 = $connection->query(
    'SELECT PlayerName AS FullName, PlayerID 
        FROM SeasonStats
        WHERE FullName LIKE "%' . $key . '%"
        GROUP BY PlayerID
        ORDER BY FullName ASC');

while ($row = $result2->fetchArray()) {  
    array_push($players2, [
        "PlayerID" => $row['PlayerID'],
        "UniqueID" => $row['PlayerID'],
        "FullName" => $row['FullName'],
    ]);           
}

foreach($players2 as $seasonstats){

    $find = false;
    foreach($players as $player){

        if($player['UniqueID'] == $seasonstats['PlayerID']){

            $find = true;
            break;

        }

    }

    if(!$find)
        array_push($players, $seasonstats);

}

$result3 = $connection2->query(
    'SELECT FirstName || " " || LastName AS FullName, FirstName, LastName, CoachID 
        FROM Coaches
        WHERE FullName LIKE "%' . $key . '%"
        ORDER BY LastName ASC');

while ($row = $result3->fetchArray()) {  
    array_push($coaches, [
        "CoachID" => $row['CoachID'],
        "FullName" => $row['FullName'],
    ]);           
}   

$c = 0;

if(count($players) > 0)
$html .= '<div class="suggest-title"><b>Players</b></div>';

foreach ($players as $row) {     

    $html .= '<div><a class="suggest-element" url="/formerplayer/'.utf8_encode($row['UniqueID']).'">'.utf8_encode($row['FullName']).'</a></div>';
    $c++;

    if($c > 4){
        if(count($players) <> 5)
            $html .= '<div><a class="suggest-element" url="/playersearch/'.utf8_encode($key).'">More players...</a></div>';
        break;
        
    }

}

$i = 0;

if(count($coaches) > 0)
$html .= '<div class="suggest-title"><b>Coaches</b></div>';

foreach ($coaches as $row) {     

    $html .= '<div><a class="suggest-element" url="/coach/'.utf8_encode($row['CoachID']).'">'.utf8_encode($row['FullName']).'</a></div>';
    $i++;

    if($i > 4 ){
        if(count($coaches) <> 5)
            $html .= '<div><a class="suggest-element" url="/coachsearch/'.utf8_encode($key).'">More coaches...</a></div>';
        break;
        
    }

}

$result4 = $connection2->query(
    'SELECT CityName || " " || TeamName AS Team, CityName, TeamName, TeamID 
        FROM Teams
        WHERE Team LIKE "%' . $key . '%"
        ORDER BY TeamName ASC');

while ($row = $result4->fetchArray()) {  
    array_push($teams, [
        "TeamID" => $row['TeamID'],
        "Team" => $row['Team'],
    ]);           
}

$c = 0;

if(count($teams) > 0)
$html .= '<div class="suggest-title"><b>Teams</b></div>';

foreach ($teams as $row) {     

    $html .= '<div><a class="suggest-element" url="/team/'.utf8_encode($row['TeamID']).'">'.utf8_encode($row['Team']).'</a></div>';

}

if(strlen($key) >= 3){
    echo $html;
}

 ?>
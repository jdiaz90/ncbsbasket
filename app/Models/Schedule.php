<?php

namespace App\Models;

use Goutte\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class Schedule extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Schedule';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'GameNo';
    protected $connection = 'sqlite3';

    public function boxscore()
    {
        return $this->hasMany(BoxScore::class, 'GameNo', 'GameNo');
    }

    function getHTMLGame(){
        $client = new Client();
        return $client->request('GET', 
        "/html/Game" . $this->GameNo. ".html");  
    }

    function searchResult($i = 1){

        return array_filter($this->getHTMLGame()
        ->filterXPath('//tbody[' . $i . ']
        /tr')
        ->each(function ($tr) {

            $node = $tr->filterXPath("//td")
            ->eq(0);

            try{
                return explode(".", $node->filterXPath("//a")
                ->attr('href'))[0];}

            catch(InvalidArgumentException $e){}

        })); 
        
    }

    function getTeamGameStats($id = 1){

        $starters  = Player::
        select("PlayerID")
        ->whereIn('UniqueID', $this->searchResult($id))
        ->get()
        ->toArray();

        $bench  = Player::
        select("PlayerID")
        ->whereIn('UniqueID', $this->searchResult(($id + 1)))
        ->get()
        ->toArray();

        $ids = [];

        foreach($starters as $array)
            foreach($array as $row)
                array_push($ids, $row);

        foreach($bench as $array)
            foreach($array as $row)
                array_push($ids, $row);
                
        
         return BoxScore::
         where('GameNo', "=", $this->GameNo)
         ->whereIn('PlayerID', $ids)
         ->groupBy('PlayerID')
         ->orderBy('Points', 'desc')
         ->get();

    }

    static function getLogo($search){

        $identifier = "Logo";
        $key = $search . "_" . $identifier;
        $value = ""; 

        if (!Cache::has($key)){

            $teams = Team::select('TeamID', 'CityName', 'TeamName')
            ->get();

            foreach($teams as $team){

                if($team->CityName . " " . $team->TeamName == $search){
                    $value = $team->ImgLogo;
                    break;
                }

            }
            
            Cache::put($key, $value, now()->addYears(1));
    
        }return Cache::get($key);

    }

    function getVisitorLogoAttribute(){

        return Schedule::getLogo($this->Visitor);

    }

    function getHomeLogoAttribute(){

        return Schedule::getLogo($this->Home);

    }

    function getMVPStats(){
        
        $players = Player::select('PlayerID', 'FirstName', 'LastName')
        ->get();

        $mvpID = "";

        foreach($players as $player){
            if($this->POTG == $player->FirstName . " " . $player->LastName){
                $mvpID = $player->PlayerID;
                break;
            }
            
        }

        $mvpStats = BoxScore::
        select("PlayerID", "Points", "Assists", 'Blocks', 'Steals')
        ->selectRaw("(DRebs + ORebs) as Rebs")
        ->where([
            ['GameNo', $this->GameNo],
            ['PlayerID', $mvpID]
        ])
        ->get();

        return $mvpStats[0];
    }

    function getMVPPositionAttribute(){

        $playerID = $this->getMVPStats()->PlayerID;

        $player = Player::where('PlayerID', $playerID)
        ->get();

        return $player[0]->Pos;

    }

    function getMVPPhotoAttribute(){

        $playerID = $this->getMVPStats()->PlayerID;

        $player = Player::where('PlayerID', $playerID)
        ->get();

        return $player[0]->PlayerPhoto;

    }

    function getVisitorColorAttribute(){

        return Schedule::getColorTeam($this->Visitor);

    }

    function getHomeColorAttribute(){

        return Schedule::getColorTeam($this->Home);

    }

    static function getColorTeam($search){

        if($search == "Atlanta Hawks")
            return "#E00025";
        
        if($search == "Boston Celtics")
            return "#007A30";

        if($search == "Brooklyn Nets" ||
            $search == "Portland Trail Blazers" ||
            $search == "San Antonio Spurs")
            return "black";

        if($search == "Charlotte Hornets")
            return "#047284";

        if($search == "Chicago Bulls")
            return "#BC022C";

        if($search == "Cleveland Cavaliers")
            return "#6C263C";

        if($search == "Dallas Mavericks" ||
            $search == "Memphis Grizzlies")
            return "#0466B4";

        if($search == "Denver Nuggets")
            return "#0C223C";

        if($search == "Detroit Pistons" ||
            $search == "Golden State Warriors")
            return "#0446AC";

        if($search == "Houston Rockets")
            return "#D41244";  

        if($search == "Indiana Pacers")
            return "#042E64";  

        if($search == "Los Angeles (C) Clippers")
            return "#D40A3C";  

        if($search == "Los Angeles (L) Lakers")
            return "#542E84";  

        if($search == "Miami Heat")
            return "#94022C";  

        if($search == "Milwaukee Bucks")
            return "#244E34";  

        if($search == "Minnesota Timberwolves")
            return "#044E84";  

        if($search == "New Orleans Pelicans")
            return "#041E3C";  

        if($search == "New York Knicks")
            return "#F4822C";  

        if($search == "Oklahoma City Thunder" ||
            $search == "Utah Jazz" ||
            $search == "Washington Wizards")
            return "#042244";  

        if($search == "Orlando Magic")
            return "#0472BC";  

        if($search == "Philadelphia 76ers")
            return "#043EA4";  

        if($search == "Phoenix Suns")
            return "#1C125E";  

        if($search == "Sacramento Kings")
            return "#4C2A7C"; 

        if($search == "Toronto Raptors")
            return "#D3002D"; 
  
    }

    function gameLogExists(){
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $this->getGameLogAttribute())) {
            return true;
        } else {
            return false;
        }
    }

    function getGameLogAttribute(){

        $code = Day::select('Code')
        ->where('DayText', explode(",", $this->Day)[0])
        ->get()[0]->Code;

        return "/html/gamelogs/" . $code . "_" . $this->AbVisitor . "_" . $this->AbHome . ".html";

    }

    static function getAbTeam($search){


        $teams = Team::select('TeamAbbrev', 'CityName', 'TeamName')
        ->get();

        foreach($teams as $team){
            if($search == $team->CityName . " " . $team->TeamName){
                return $team->TeamAbbrev;
            }
            
        }

    }

    function getTeamID($search){

        $identifier = "ID";
        $key = $search . "_" . $identifier;
        $value = "";

        if (!Cache::has($key)){

            $teams = Team::select('TeamID', 'CityName', 'TeamName')
            ->get();

            foreach($teams as $team){
                if($search == $team->CityName . " " . $team->TeamName){
                    $value  =  $team->TeamID;
                    break;
                }
                
            }

            Cache::put($key, $value, now()->addYears(1));
    
        }return Cache::get($key);

    }

    function getAbVisitorAttribute(){

        return Schedule::getAbTeam($this->Visitor);

    }

    function getAbHomeAttribute(){

        return Schedule::getAbTeam($this->Home);

    }

    function getShortDateAttribute(){

        $aux = explode(",", $this->Day)[0];

            if(str_contains($aux, "October"))
                $aux = str_replace("October", 10, $aux);

            if(str_contains($aux, "November"))
                $aux = str_replace("November", 11, $aux);

            if(str_contains($aux, "December"))
                $aux = str_replace("December", 12, $aux);

            if(str_contains($aux, "January"))
                $aux = str_replace("January", 1, $aux);

            if(str_contains($aux, "February"))
                $aux = str_replace("February", 2, $aux);

            if(str_contains($aux, "March"))
                $aux = str_replace("March", 3, $aux);

            if(str_contains($aux, "April"))
                $aux = str_replace("April", 4, $aux);

            if(str_contains($aux, "May"))
                $aux = str_replace("May", 5, $aux);

            if(str_contains($aux, "June"))
                $aux = str_replace("June", 6, $aux);

            $aux = explode(" ", $aux);

            return $aux[1] . "/" . $aux[0];

    }

    
}

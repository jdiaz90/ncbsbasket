<?php

namespace App\Models;

use ErrorException;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Team extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'TeamID';
    protected $connection = 'sqlite2';

    function otherInfo(){
        return $this->hasOne(Team30::class, "TeamID", "TeamID");
    }

    function players(){
        return $this->hasMany(Player::class, "TeamID", "TeamID")
        ->orderBy('Position')
        ->orderBy('ContractYear1', 'desc');
    } 

    function coachHistory(){
        return $this->hasMany(CoachHistory::class, "TeamID", "TeamID")
        ->orderBy('Season', 'desc');
    }

    function coachs(){
        return $this->hasMany(Coach::class, "TeamID", "TeamID")
        ->orderBy('Level', 'asc');
    }
    
    function seasonStats(){
        return $this->hasMany(SeasonStat::class, "TeamID", "TeamID")
        ->orderBy('SeasonID', 'desc')
        ->orderBy('Points', 'desc');
    } 

    function draft(){
        return $this->hasMany(Draft::class, "TeamID", "TeamID")
        ->orderBy('SeasonID', 'desc')
        ->orderBy('Round', 'desc')
        ->orderBy('Pick', 'desc');
    } 

    function awards(){
        return $this->hasMany(Award::class, "TeamID", "TeamID")
        ->orderBy('Season', 'desc');
    } 

    function mediaNews(){
        return $this->hasMany(MediaNew::class, "MainTeam", "TeamID")
        ->orderBy('Key', 'desc');
    }

    function transactions(){
        return $this->hasMany(Transaction::class, "TeamID", "TeamID")
        ->orderBy('Key', 'desc');
    }

    function champions(){
        return $this->hasMany(Champion::class, "ChampID", "TeamID");
    } 

    function retiredJerseys(){
        return $this->hasMany(RetiredJersey::class, "TeamID", "TeamID");
    } 

    function news(){
        return $this->mediaNews()
        ->select("Title", "Story", "Day")
        ->orderBy("Day", "desc")
        ->get();
    }

    static function currentSeason(){

        return Transaction::max('Season');

    }

    function PIEGraph(){

        $players = $this->players()
        ->select("PlayerID", "FirstName", "LastName")
        ->get();

        $aux = [];

        foreach($players as $player)
            $aux[$player->Full_Name] = $player->PIE;

        arsort($aux);

        $pie = [];
        $pie['Rest of Team'] = 0;
        $stop = 7;
        $c = 0;

        foreach ($aux as $key => $value){
            if($c < $stop)
                $pie[$key] = $value;
            else
                $pie['Rest of Team'] += $value; 
            $c++;
        }

        return $pie;
    }

    function leaders(){

        $players = $this->players()
        ->select("PlayerID", "FirstName", "LastName")
        ->get();

        $points = [];
        $assists = [];
        $rebounds = [];
        $leaders = [];

        foreach($players as $player)
            $points[$player->Full_Name] = $player->PPG;

        foreach($players as $player)
            $assists[$player->Full_Name] = $player->APG;

        foreach($players as $player)
            $rebounds[$player->Full_Name] = $player->RPG;

        arsort($points);
        arsort($assists);
        arsort($rebounds);

        array_push($leaders, $points);
        array_push($leaders, $assists);
        array_push($leaders, $rebounds);

        return $leaders;
    }

    function getFranchiseAttribute(){
        return $this->CityName . " " . $this->TeamName;
    }

    function getImgLogoAttribute(){
        
        if($this->TeamID > 0 && $this->TeamID <= 30)
            $gLeague = "";
        else
            $gLeague = "G_League_";

        $url = "/images/logos/RW_NBA_$gLeague" 
        . $this->CityName . "_" . $this->TeamName . ".png";

        return str_replace(" ", "_", $url);
    }

    function getImgCourtAttribute(){

        if(str_contains($this->CityName, "(")){
            $team = explode("(", $this->CityName);
            $team[0] = strtolower($team[0]);
            $aux = $team[0] . " " . $team[1]; 
        }else{
            $aux = $this->CityName;
        }
        
        $aux = str_replace(array(" ", "(", ")"), "", $aux);

        return  "/images/courts/" . $aux . ".jpg";

    }

    function getRecordAttribute(){
        
        $identifier = "WL";
        $key = $this->TeamAbbrev . "_" . $identifier;

        if (!Cache::has($key)){

            $value = $this->RecordHTML;

            Cache::put($key, $value, 86400);

        }return Cache::get($key);
        
    }

    function getHomeWinsAttribute(){

        $identifier = "HW";
        $key = $this->TeamAbbrev . "_" . $identifier;

        if (!Cache::has($key)){
            $aux = Schedule::where('Home', $this->Franchise)
            ->selectRaw("count(Home) as W")
            ->where([
                    ["Home", $this->Franchise],
                    ["GameNo", "<", 2307]
                ])
            ->whereColumn("HomeScore", ">", "VisitorScore")
            ->get();

            $value = $aux[0]['W'];

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);
        
    }

    function getAwayWinsAttribute(){

        $identifier = "AW";
        $key = $this->TeamAbbrev . "_" . $identifier;

        if (!Cache::has($key)){
            $aux = Schedule::where('Visitor', $this->Franchise)
            ->selectRaw("count(Visitor) as W")
            ->where([
                    ["Visitor", $this->Franchise],
                    ["GameNo", "<", 2307]
                ])
            ->whereColumn("VisitorScore", ">", "HomeScore")
            ->get();

            $value = $aux[0]['W'];

            Cache::put($key, $value, 86400);
            
        }
        return Cache::get($key);
        
    }
    
    function getHomeLosesAttribute(){

        $identifier = "HL";
        $key = $this->TeamAbbrev . "_" . $identifier;

        if (!Cache::has($key)){
            $aux = Schedule::where('Home', $this->Franchise)
            ->selectRaw("count(Home) as L")
            ->where([
                    ["Home", $this->Franchise],
                    ["GameNo", "<", 2307]
                ])
            ->whereColumn("HomeScore", "<", "VisitorScore")
            ->get();

            $value = $aux[0]['L'];

            Cache::put($key, $value, 86400);
        
        }return Cache::get($key);
        
    }

    function getAwayLosesAttribute(){

        $identifier = "AL";
        $key = $this->TeamAbbrev . "_" . $identifier;

        if (!Cache::has($key)){
            $aux = Schedule::where('Visitor', $this->Franchise)
            ->selectRaw("count(Visitor) as L")
            ->where([
                    ["Visitor", $this->Franchise],
                    ["GameNo", "<", 2307]
                ])
            ->whereColumn("VisitorScore", "<", "HomeScore")
            ->get();

            $value = $aux[0]['L'];

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);
    
    }

    function getDivAwayWinsAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("DivisionID", $this->otherInfo->DivisionID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $awayWins  = Schedule::selectRaw("count(*) as W")
        ->where("Visitor", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '>', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Home", $rival);
        })
        ->get()[0]['W'];

        return $awayWins; 

    }

    function getDivHomeWinsAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("DivisionID", $this->otherInfo->DivisionID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $homeWins  = Schedule::selectRaw("count(*) as W")
        ->where("Home", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '<', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Visitor", $rival);
        })
        ->get()[0]['W'];

        return $homeWins; 

    }

    function getDivWinsAttribute(){
        
        return $this->DivAwayWins + $this->DivHomeWins;

    }

    function getDivAwayLosesAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("DivisionID", $this->otherInfo->DivisionID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $awayLoses  = Schedule::selectRaw("count(*) as W")
        ->where("Visitor", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '<', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Home", $rival);
        })
        ->get()[0]['W'];

        return $awayLoses; 

    }

    function getDivHomeLosesAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("DivisionID", $this->otherInfo->DivisionID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $homeLoses  = Schedule::selectRaw("count(*) as W")
        ->where("Home", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '>', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Visitor", $rival);
        })
        ->get()[0]['W'];

        return $homeLoses; 

    }

    function getDivLosesAttribute(){
        
        return $this->DivAwayLoses + $this->DivHomeLoses;

    }

    function getConfAwayWinsAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("ConferenceID", $this->otherInfo->ConferenceID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $awayWins  = Schedule::selectRaw("count(*) as W")
        ->where("Visitor", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '>', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Home", $rival);
        })
        ->get()[0]['W'];

        return $awayWins; 

    }

    function getConfHomeWinsAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("ConferenceID", $this->otherInfo->ConferenceID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $homeWins  = Schedule::selectRaw("count(*) as W")
        ->where("Home", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '<', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Visitor", $rival);
        })
        ->get()[0]['W'];

        return $homeWins; 

    }

    function getConfWinsAttribute(){
        
        return $this->ConfAwayWins + $this->ConfHomeWins;

    }

    function getConfAwayLosesAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("ConferenceID", $this->otherInfo->ConferenceID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $awayWins  = Schedule::selectRaw("count(*) as W")
        ->where("Visitor", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '<', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Home", $rival);
        })
        ->get()[0]['W'];

        return $awayWins; 

    }

    function getConfHomeLosesAttribute(){

        $teams30 = Team30::selectRaw('CityName || " " || TeamName as Franchise')
        ->where("ConferenceID", $this->otherInfo->ConferenceID)
        ->get()
        ->toArray();

        foreach($teams30 as $key => $team)
            if($team['Franchise'] == $this->Franchise)
                unset($teams30[$key]);

        $rivals = [];
        foreach($teams30 as $team)
            array_push($rivals, $team['Franchise']);

        $homeWins  = Schedule::selectRaw("count(*) as W")
        ->where("Home", $this->Franchise)
        ->where("GameNo", "<", 2307)
        ->whereColumn("VisitorScore", '>', 'HomeScore')
        ->Where(function ($query) use ($rivals){
            foreach($rivals as $rival)
                $query->orWhere("Visitor", $rival);
        })
        ->get()[0]['W'];

        return $homeWins; 

    }

    function getConfLosesAttribute(){
        
        return $this->ConfAwayLoses + $this->ConfHomeLoses;

    }

    function getL10Attribute(){

        $games = Schedule::select('Visitor', 'VisitorScore', 'Home', 'HomeScore')
       ->where('GameNo', '<', 2307)
       ->where(function ($query){
           $query->where("Home", $this->Franchise)
           ->orwhere("Visitor", $this->Franchise);
       })
       ->orderBy('GameNo', 'desc')
       ->limit(10)
       ->get();

       $l10['Wins'] = 0;
       $l10['Loses'] = 0;

       foreach($games as $game)
           if($game->Visitor == $this->Franchise)
               if($game->VisitorScore > $game->HomeScore)
                    $l10['Wins']++; 
                else
                    $l10['Loses']++ ;        
           else
               if($game->HomeScore > $game->VisitorScore)  
                    $l10['Wins']++;
                else
                    $l10['Loses']++;

       return $l10;
       
   }

    function getWinsAttribute(){
        
        return $this->AwayWins + $this->HomeWins;

    }

    function getLosesAttribute(){
        
        return $this->AwayLoses + $this->HomeLoses;

    }

    function getTeamSalaryAttribute(){

        $value = '//div[@class="ui mini horizontal statistic"][7]';
        $salary = $this->searchResultInfo($value);

        $salary = str_replace("Team Salary", "", $salary[0]);
        $salary = str_replace("$", "", $salary);
        $salary = str_replace(".", "", $salary);

        return intval($salary);

    }

    function getCapStatusAttribute(){

        if ($this->TeamID > 32)
            return "N/A";

        $sql = SalaryCap::where('_rowid_', '1')
        ->get();

        return $sql[0]['SalaryCap'] - $this->TeamSalary;

    }
    
    function getLuxuryTaxAttribute(){

        if ($this->TeamID > 32)
            return "N/A";

        $luxuryTax = LuxuryTax::where('_rowid_', '1')
        ->get()[0]['LuxuryTax'] - $this->TeamSalary;

        if($luxuryTax < 0)
            return -$luxuryTax;
        return 0;

    }

    function affiliate(){

        return Team::where([
                ['TeamID', "=", $this->TeamID + 32]
            ]
        )->get()[0];

    }

    function parentTeam(){

        return Team::where([
            ['TeamID', "=", $this->TeamID - 32]
            ]
        )->get()[0];

    }

    function getFanSupportAttribute(){

        $fans = $this->TeamFansPct;

        if ($fans <= 72)
            return "Low";
        if ($fans <= 84)
            return "Average";
        if ($fans <= 95)
            return "High";
        else
            return "Very High";
    
    }

    function getCourtAttribute(){

        return "/images/courts/" . $this->otherInfo->CourtPath;

    }

    function getHomeJerseyAttribute(){

        return "/images/jerseys/" . $this->otherInfo->HomeJerseyPath;

    }

    function getAwayJerseyAttribute(){

        return "/images/jerseys/" . $this->otherInfo->AwayJerseyPath;

    }

    function getAltJerseyAttribute(){

        return "/images/jerseys/" . $this->otherInfo->AltJerseyPath;

    }

    function getPrimeColorAttribute(){

        return "#" . dechex($this->otherInfo->PrimeColor);

    }

    function getSecondColorAttribute(){

        return "#" . dechex($this->otherInfo->SecondColor);

    }

    function calendar(){

        return Schedule::where("Visitor", $this->Franchise)
        ->orWhere("Home", $this->Franchise)
        ->orderBy('GameNo', 'desc')
        ->get();
        
    }

    function calendarStandings(){

        return Schedule::select('Visitor', 'VisitorScore', 'Home', 'HomeScore')
        ->where('GameNo', '<', 2307)
        ->where(function ($query){
            $query->where("Home", $this->Franchise)
            ->orwhere("Visitor", $this->Franchise);
        })
        ->orderBy('GameNo', 'desc')
        ->get();
        
    }

    function getStreakAttribute(){

        $identifier = "Streak";
        $key = $this->TeamAbbrev . "_" . $identifier;

        if (!Cache::has($key)){

            try{

                $wl = [];

                foreach($this->calendar() as $game)
    
                    if($game->Visitor == $this->franchise)
                        if ($game->VisitorScore > $game->HomeScore)
                            array_push($wl, "W");
                        else
                            array_push($wl, "L");
                    else
                        if ($game->HomeScore > $game->VisitorScore)
                            array_push($wl, "W");
                        else
                            array_push($wl, "L");
    
                $result = 0;
                $i = 0;    
    
                if($wl[0] == "W"){
    
                    while ($wl[$i] == "W"){
                        $result += 1;
                        $i++;
                    }
    
                    $value = "W" . $result;
    
                }
        
                if($wl[0] == "L"){
    
                    while ($wl[$i] == "L"){
                        $result += 1;
                        $i++;
                    }
    
                    $value = "L" . $result;
    
                }

            } catch (ErrorException $e){

                $value = $this->StreakHTML;

            } finally {

                Cache::put($key, $value, 86400);

            }      
            
        }return Cache::get($key);
    
    }

    function getStreakStandingsAttribute(){

            try{

                $wl = [];

                foreach($this->calendarStandings() as $game)
    
                    if($game->Visitor == $this->franchise)
                        if ($game->VisitorScore > $game->HomeScore)
                            array_push($wl, "W");
                        else
                            array_push($wl, "L");
                    else
                        if ($game->HomeScore > $game->VisitorScore)
                            array_push($wl, "W");
                        else
                            array_push($wl, "L");
    
                $result = 0;
                $i = 0;    
    
                if($wl[0] == "W"){
    
                    while ($wl[$i] == "W"){
                        $result += 1;
                        $i++;
                    }
    
                    $value = "W" . $result;
    
                }
        
                if($wl[0] == "L"){
    
                    while ($wl[$i] == "L"){
                        $result += 1;
                        $i++;
                    }
    
                    $value = "L" . $result;
    
                }

            } catch (ErrorException $e){

                $value = $this->StreakHTML;

            } finally {

                return $value;

            }      
    
    }

    function getTotalAttendanceAttribute(){

        return Schedule::selectRaw('sum(Attendance) as TotalAttend')
        ->where("Home", $this->Franchise)
        ->get()[0]['TotalAttend'];

    }

    function getAverageAttendanceAttribute(){

        return Schedule::selectRaw('avg(Attendance) as AvgAttend')
        ->where("Home", $this->Franchise)
        ->get()[0]['AvgAttend'];

    }

    function getCapacityPctAttribute(){

        return $this->AverageAttendance / $this->Capacity * 100;

    }

    function getTeamColorAttribute(){
        
        if($this->TeamID == 11)
            return "#E00025";
    
        if($this->TeamID == 1)
            return "#007A30";

        if($this->TeamID == 2 ||
            $this->TeamID == 23 ||
            $this->TeamID == 20)
            return "#000000";

        if($this->TeamID == 12)
            return "#047284";

        if($this->TeamID == 6)
            return "#BC022C";

        if($this->TeamID == 7)
            return "#6C263C";

        if($this->TeamID == 16 ||
            $this->TeamID == 18)
            return "#0466B4";

        if($this->TeamID == 21)
            return "#0C223C";

        if($this->TeamID == 8 ||
            $this->TeamID == 26)
            return "#0446AC";

        if($this->TeamID == 17)
            return "#D41244";  

        if($this->TeamID == 9)
            return "#042E64";  

        if($this->TeamID == 27)
            return "#D40A3C";  

        if($this->TeamID == 28)
            return "#542E84";  

        if($this->TeamID == 13)
            return "#94022C";  

        if($this->TeamID == 10)
            return "#244E34";  

        if($this->TeamID == 22)
            return "#044E84";  

        if($this->TeamID == 19)
            return "#041E3C";  

        if($this->TeamID == 3)
            return "#F4822C";  

        if($this->TeamID == 24 ||
            $this->TeamID == 25 ||
            $this->TeamID == 15)
            return "#042244";  

        if($this->TeamID == 14)
            return "#0472BC";  

        if($this->TeamID == 4)
            return "#043EA4";  

        if($this->TeamID == 29)
            return "#1C125E";  

        if($this->TeamID == 30)
            return "#4C2A7C"; 

        if($this->TeamID == 5)
            return "#D3002D"; 

        return "#808000";

    }

    function getHTMLTeamInfo(){
        $client = new HttpBrowser(HttpClient::create());
        return $client->request('GET', 
        "/html/" . $this->TeamAbbrev . "" 
        . $this->TeamName. "_Info.html");  
    }

    function getHTMLTeamStats(){
        $client = new HttpBrowser(HttpClient::create());
        return $client->request('GET', 
        "/html/" . $this->TeamAbbrev . "" 
        . $this->TeamName. "_Stats.html");  
    }

    function getHTMLTeamRatings(){
        $client = new HttpBrowser(HttpClient::create());
        return $client->request('GET', 
        "/html/" . $this->TeamAbbrev . "" 
        . $this->TeamName. "_Ratings.html");  
    }

    function getHTMLTeamDepth(){
        $client = new HttpBrowser(HttpClient::create());
        return $client->request('GET', 
        "/html/" . $this->TeamAbbrev . "" 
        . $this->TeamName. "_Depth.html");  
    }

    function getHTMLTeamSchedule(){
        $client = new HttpBrowser(HttpClient::create());
        return $client->request('GET', 
        "/html/" . $this->TeamAbbrev . "" 
        . $this->TeamName. "_Schedule.html");  
    }



    function searchResultInfo($value){

        return $this->getHTMLTeamInfo()
        ->filterXPath($value)
        ->each(function ($node) {
            return $node->text();   
        });   
    
    }

    function searchResultSalary($color = "#CCCCCC", $skip = "CUT SALARY :"){

        $array = $this->getHTMLTeamRatings()
        ->filterXPath('//tr[@style="color: #333333; background: ' . $color . ';"]')
        ->each(function ($tr) {
            return $tr->filterXPath("//td")
            ->each(function ($td) {
                    return $td->text();   
            });   
        })[0]; 
        
        $cutSalary = [];

        foreach($array as $aux)
            if(!($aux == "" || $aux == $skip))
                array_push($cutSalary, $aux);

        return $cutSalary;
    
    }

    function searchResultPointsSchedule(){

        return $this->getHTMLTeamSchedule()
        ->filterXPath("//table[1]
        /tbody
        /tr")
        ->each(function ($tr) {
            return $tr->
            filter("td")
            ->eq(4)
            ->filter("a")
            ->eq(0)
            ->text();
        }); 

    }

    function getRecordHTMLAttribute(){
        
        $string = '//div[@class="ui eight column grid"]
        /div[@class="column"][1]
        /div[@class="ui mini horizontal statistic"]
        /div[@class="value"]'; 

        return $this->searchResultInfo($string)[0];

    }

    function getStreakHTMLAttribute(){
        
        $string = '//div[@class="ui eight column grid"]
        /div[@class="column"][2]
        /div[@class="ui mini horizontal statistic"]
        /div[@class="value"]'; 

        return $this->searchResultInfo($string)[0];

    }

    function getBasicArray(){
        
        $string = '//table[@class="ui selectable basic table"][1]
        /tbody
        /tr'; 

        return $this->searchResultBasic($string);

    }
    
    function getShootingArray(){
        
        $string = '//table[@class="ui selectable basic table"][2]
        /tbody
        /tr'; 

        return $this->searchResultShooting($string);

    }

    function getAdvancedArray(){
        
        $string = '//table[@class="ui selectable basic table"][3]
        /tbody
        /tr'; 

        return $this->searchResultAdvanced($string);

    }

    function getMiscellaneousArray(){
        
        $string = '//table[@class="ui selectable basic table"][4]
        /tbody
        /tr'; 

        return $this->searchResultMiscellaneous($string);

    }

    function searchResultBasic($value){

        $aux = $this->getHTMLTeamStats()
        ->filterXPath($value)
        ->each(function ($tr) {
            return $tr->filterXPath("//td")
            ->each(function ($td) {
                return $td->text();   
            });   
        }); 

        $players = [];

        foreach ($aux as $player){

            $players[$player[1]]['Pos'] = $player[0];
            $players[$player[1]]['Player'] = $player[1];
            $players[$player[1]]['GP'] = $player[2];
            Cache::put($player[1] . "_GP", $player[2], 86400);
            $players[$player[1]]['GS'] = $player[3];
            $players[$player[1]]['MIN'] = str_replace(",", ".", $player[4]);
            $players[$player[1]]['FGM'] = str_replace(",", ".", $player[5]);
            $players[$player[1]]['FGA'] = str_replace(",", ".", $player[6]);
            $players[$player[1]]['FG%'] = $player[7];
            $players[$player[1]]['3PM'] = str_replace(",", ".", $player[8]);
            $players[$player[1]]['3PA'] = str_replace(",", ".", $player[9]);
            $players[$player[1]]['3P%'] = $player[10];
            $players[$player[1]]['FTM'] = str_replace(",", ".", $player[11]);
            $players[$player[1]]['FTA'] = str_replace(",", ".", $player[12]);
            $players[$player[1]]['FT%'] = $player[13];
            $players[$player[1]]['ORB'] = str_replace(",", ".", $player[14]);
            $players[$player[1]]['DRB'] = str_replace(",", ".", $player[15]);
            $players[$player[1]]['TRB'] = str_replace(",", ".", $player[16]);
            $players[$player[1]]['AST'] = str_replace(",", ".", $player[17]);
            $players[$player[1]]['STL'] = str_replace(",", ".", $player[18]);
            $players[$player[1]]['BLK'] = str_replace(",", ".", $player[19]);
            $players[$player[1]]['TOV'] = str_replace(",", ".", $player[20]);
            $players[$player[1]]['PF'] = str_replace(",", ".", $player[21]);
            $players[$player[1]]['PTS'] = str_replace(",", ".", $player[22]);

        }

        return $players;
        
    }

    function searchResultBasic36(){

        $stats = [];

        $players = $this->players;

        foreach ($players as $player){

            $season = $player->statsThisSeason();

            if(isset($season['PRO'])){
                $data = $season['PRO'];
            }else{
                $data = $season['DL'];
            }

            $per36 = 36 / $data->Minutes;

            $stats[$player->Full_Name]['Pos'] = $player->AbPosition;
            $stats[$player->Full_Name]['URL'] = $player->URLPlayer;
            $stats[$player->Full_Name]['Player'] = $player->Full_Name;
            $stats[$player->Full_Name]['GP'] = $data->G;
            $stats[$player->Full_Name]['GS'] = $data->GS;
            $stats[$player->Full_Name]['MIN'] = round($data->Minutes  * $per36, 1);
            $stats[$player->Full_Name]['FGM'] = round($data->FGM  * $per36, 1);
            $stats[$player->Full_Name]['FGA'] = round($data->FGA  * $per36, 1);
            $stats[$player->Full_Name]['FG%'] = "," . $data->FGP;
            $stats[$player->Full_Name]['3PM'] = round($data->FG3PM  * $per36, 1);
            $stats[$player->Full_Name]['3PA'] = round($data->FG3PA  * $per36, 1);
            $stats[$player->Full_Name]['3P%'] = "," .  $data->FG3PP;
            $stats[$player->Full_Name]['FTM'] = round($data->FTM  * $per36, 1);
            $stats[$player->Full_Name]['FTA'] = round($data->FTA  * $per36, 1);
            $stats[$player->Full_Name]['FT%'] = "," .  $data->FTP;
            $stats[$player->Full_Name]['ORB'] = round($data->ORebs  * $per36, 1);
            $stats[$player->Full_Name]['DRB'] = round($data->DRebs  * $per36, 1);
            $stats[$player->Full_Name]['TRB'] = round($data->Rebounds  * $per36, 1);
            $stats[$player->Full_Name]['AST'] = round($data->Assists  * $per36, 1);
            $stats[$player->Full_Name]['STL'] = round($data->Steals  * $per36, 1);
            $stats[$player->Full_Name]['BLK'] = round($data->Blocks  * $per36, 1);
            $stats[$player->Full_Name]['TOV'] = round($data->Turnovers  * $per36, 1);
            $stats[$player->Full_Name]['PF'] = round($data->Fouls  * $per36, 1);
            $stats[$player->Full_Name]['PTS'] = round($data->Points  * $per36, 1);

        }

        return $stats;
        
    }

    function searchResultBasicTotal(){

        $stats = [];

        $players = $this->players;

        foreach ($players as $player){

            $season = $player->statsThisSeason();

            if(isset($season['PRO'])){
                $data = $season['PRO'];
            }else{
                $data = $season['DL'];
            }
            

            $stats[$player->Full_Name]['Pos'] = $player->AbPosition;
            $stats[$player->Full_Name]['URL'] = $player->URLPlayer;
            $stats[$player->Full_Name]['Player'] = $player->Full_Name;
            $stats[$player->Full_Name]['GP'] = $data->G;
            $stats[$player->Full_Name]['GS'] = $data->GS;
            $stats[$player->Full_Name]['MIN'] = round($data->Minutes, 0);
            $stats[$player->Full_Name]['FGM'] = $data->FGM;
            $stats[$player->Full_Name]['FGA'] = $data->FGA;
            $stats[$player->Full_Name]['FG%'] = "," . $data->FGP;
            $stats[$player->Full_Name]['3PM'] = $data->FG3PM;
            $stats[$player->Full_Name]['3PA'] = $data->FG3PA;
            $stats[$player->Full_Name]['3P%'] = "," . $data->FG3PP;
            $stats[$player->Full_Name]['FTM'] = $data->FTM;
            $stats[$player->Full_Name]['FTA'] = $data->FTA;
            $stats[$player->Full_Name]['FT%'] = "," . $data->FTP;
            $stats[$player->Full_Name]['ORB'] = $data->ORebs;
            $stats[$player->Full_Name]['DRB'] = $data->DRebs;
            $stats[$player->Full_Name]['TRB'] = $data->Rebounds;
            $stats[$player->Full_Name]['AST'] = $data->Assists;
            $stats[$player->Full_Name]['STL'] = $data->Steals;
            $stats[$player->Full_Name]['BLK'] = $data->Blocks;
            $stats[$player->Full_Name]['TOV'] = $data->Turnovers;
            $stats[$player->Full_Name]['PF'] = $data->Fouls;
            $stats[$player->Full_Name]['PTS'] = $data->Points;

        }

        return $stats;
        
    }

    function searchResultShooting($value){

        $aux = $this->getHTMLTeamStats()
        ->filterXPath($value)
        ->each(function ($tr) {
            return $tr->filterXPath("//td")
            ->each(function ($td) {
                return $td->text();   
            });   
        }); 

        $players = [];

        foreach ($aux as $player){

            $players[$player[1]]['Pos'] = $player[0];
            $players[$player[1]]['Player'] = $player[1];
            $players[$player[1]]['2PA'] = $player[2];
            $players[$player[1]]['0-3A'] = $player[3];
            $players[$player[1]]['3-10A'] = $player[4];
            $players[$player[1]]['10-16A'] = $player[5];
            $players[$player[1]]['16-3PA'] = $player[6];
            $players[$player[1]]['3PA'] = $player[7];
            $players[$player[1]]['2P%'] = $player[8];
            $players[$player[1]]['0-3%'] = $player[9];
            $players[$player[1]]['3-10%'] = $player[10];
            $players[$player[1]]['10-16%'] = $player[11];
            $players[$player[1]]['16-3P%'] = $player[12];
            $players[$player[1]]['3P%'] = $player[13];

        }

        return $players;
        
    }
    
    function searchResultAdvanced($value){

        $aux = $this->getHTMLTeamStats()
        ->filterXPath($value)
        ->each(function ($tr) {
            return $tr->filterXPath("//td")
            ->each(function ($td) {
                return $td->text();   
            });   
        }); 

        $players = [];

        foreach ($aux as $player){

            $players[$player[1]]['Pos'] = $player[0];
            $players[$player[1]]['Player'] = $player[1];
            $players[$player[1]]['ON'] = str_replace(",", ".", $player[2]);
            $players[$player[1]]['OFF'] = str_replace(",", ".", $player[3]);
            $players[$player[1]]['NET'] = str_replace(",", ".", $player[4]);
            $players[$player[1]]['PER'] = str_replace(",", ".", $player[5]);
            $players[$player[1]]['TS%'] = $player[6];
            $players[$player[1]]['EFG%'] = $player[7];
            $players[$player[1]]['ORB%'] = str_replace(",", ".", $player[8]);
            $players[$player[1]]['DRB%'] = str_replace(",", ".", $player[9]);
            $players[$player[1]]['TRB%'] = str_replace(",", ".", $player[10]);
            $players[$player[1]]['AST%'] = str_replace(",", ".", $player[11]);
            $players[$player[1]]['STL%'] = str_replace(",", ".", $player[12]);
            $players[$player[1]]['BLK%'] = str_replace(",", ".", $player[13]);
            $players[$player[1]]['TO%'] = str_replace(",", ".", $player[14]);
            $players[$player[1]]['A/TO'] = str_replace(",", ".", $player[15]);
            $players[$player[1]]['USG%'] = str_replace(",", ".", $player[16]);

        }

        return $players;
        
    }

    function searchResultAdvanced36(){
        
        $players = [];

        foreach ($this->getAdvancedArray() as $player){

            $players[$player['Player']]['Pos'] = $player['Pos'];
            $players[$player['Player']]['Player'] = $player['Player'];
            $players[$player['Player']]['ON'] = round($player['ON'] * 0.75, 2, PHP_ROUND_HALF_EVEN);
            $players[$player['Player']]['OFF'] = round($player['OFF'] * 0.75, 2, PHP_ROUND_HALF_EVEN);
            $players[$player['Player']]['NET'] = round($player['NET'] * 0.75, 2, PHP_ROUND_HALF_EVEN);
            $players[$player['Player']]['PER'] = $player['PER'];
            $players[$player['Player']]['TS%'] = $player['TS%'];
            $players[$player['Player']]['EFG%'] = $player['EFG%'];
            $players[$player['Player']]['ORB%'] = $player['ORB%'];
            $players[$player['Player']]['DRB%'] = $player['DRB%'];
            $players[$player['Player']]['TRB%'] = $player['TRB%'];
            $players[$player['Player']]['AST%'] = $player['AST%'];
            $players[$player['Player']]['STL%'] = $player['STL%'];
            $players[$player['Player']]['BLK%'] = $player['BLK%'];
            $players[$player['Player']]['TO%'] = $player['TO%'];
            $players[$player['Player']]['A/TO'] = $player['A/TO'];
            $players[$player['Player']]['USG%'] = $player['USG%'];

        }

        return $players;
        
    }

    function searchResultMiscellaneous($value){

        $aux = $this->getHTMLTeamStats()
        ->filterXPath($value)
        ->each(function ($tr) {
            return $tr->filterXPath("//td")
            ->each(function ($td) {
                return $td->text();   
            });   
        }); 

        $players = [];

        foreach ($aux as $player){

            $players[$player[1]]['Pos'] = $player[0];
            $players[$player[1]]['Player'] = $player[1];
            $players[$player[1]]['DRVS'] = str_replace(",", ".", $player[2]);
            $players[$player[1]]['DRVF'] = str_replace(",", ".", $player[3]);
            $players[$player[1]]['STP%'] = $player[4];
            $players[$player[1]]['TOFC'] = str_replace(",", ".", $player[5]);
            $players[$player[1]]['PTAL'] = str_replace(",", ".", $player[6]);
            $players[$player[1]]['SHTF'] = str_replace(",", ".", $player[7]);
            $players[$player[1]]['PA/SF'] = str_replace(",", ".", $player[8]);
            $players[$player[1]]['TCHS'] = str_replace(",", ".", $player[9]);
            $players[$player[1]]['TO/TCH'] = $player[10];
            $players[$player[1]]['A/TCH'] = $player[11];
            $players[$player[1]]['CHRG'] = str_replace(",", ".", $player[12]);
            $players[$player[1]]['TECH'] = str_replace(",", ".", $player[13]);

        }

        return $players;
        
    }

    function searchResultMiscellaneousTotal(){

        $players = [];

        foreach ($this->getMiscellaneousArray() as $player){
    
            $value = $this->getGamesPlayertoHTML($player['Player']);
            $players[$player['Player']]['Pos'] = $player['Pos'];
            $players[$player['Player']]['Player'] = $player['Player'];
            $players[$player['Player']]['DRVS'] = round($player['DRVS'] * $value, 0);
            $players[$player['Player']]['DRVF'] = round($player['DRVF']* $value, 0);
            $players[$player['Player']]['STP%'] = $player['STP%'];
            $players[$player['Player']]['TOFC'] = round($player['TOFC']* $value, 0);
            $players[$player['Player']]['PTAL'] = round($player['PTAL']* $value, 0);
            $players[$player['Player']]['SHTF'] = round($player['SHTF']* $value, 0);
            $players[$player['Player']]['PA/SF'] = $player['PA/SF'];
            $players[$player['Player']]['TCHS'] = round($player['TCHS']* $value, 0);
            $players[$player['Player']]['TO/TCH'] = $player['TO/TCH'];
            $players[$player['Player']]['A/TCH'] = $player['A/TCH'];
            $players[$player['Player']]['CHRG'] = round($player['CHRG']* $value, 0);
            $players[$player['Player']]['TECH'] = round($player['TECH']* $value, 0);

        }

        return $players;
        
    }

    function checkPlayer($player){
        return str_replace(" (DLG)", "", $player);

    }

    function getUrlPlayertoHTML($search){

        $identifier = "URL";
        $key = $search . "_" . $identifier;
        $value = "";

        if (!Cache::has($key)){

            $players = Player::select('PlayerID', 'FirstName', 'LastName')
            ->get();

            foreach($players as $player){
                if($player->Full_Name == $search){
                    $value = $player->URLPlayer;
                    break;
                }
            }
            
            Cache::put($key, $value, 86400*365);

         } 
         
         return Cache::get($key);
            
    }

    function getIDPlayertoHTML($search){

        $identifier = "ID";
        $key = $search . "_" . $identifier;
        $value = "";

        if (!Cache::has($key)){

            $players = Player::select('PlayerID', 'FirstName', 'LastName')
            ->get();

            foreach($players as $player){
                if($player->Full_Name == $search){
                    $value = $player->PlayerID;
                    break;
                }
            }
            
            Cache::put($key, $value, 86400*365);

         } 
         
         return Cache::get($key);
            
    }

    function getGamesPlayertoHTML($search){

        $identifier = "GP";
        $key = $search . "_" . $identifier;
        
        return Cache::get($key);
            
    }


    function formatResult($text){

        $value = str_replace(
            "Team StatisticsPoints Per Game", 
            "Points Per Game:",
             $text[0]);

        $value = str_replace(
            "Assists Per Game", 
            "<br/>Assists Per Game:",
            $value);

        $value = str_replace(
            "Rebounds Per Game", 
            "<br/>Rebounds Per Game:",
            $value);

        $value = str_replace(
            "Blocks Per Game", 
            "<br/>Blocks Per Game:",
            $value);

        $value = str_replace(
            "Steals Per Game", 
            "<br/>Steals Per Game:",
            $value);

        $value = str_replace(
            "Turnovers Per Game", 
            "<br/>Turnovers Per Game:",
            $value);

        $value = str_replace(
            "Field Goal %", 
            "<br/>Field Goald Pct:",
            $value);

        $value = str_replace(
            "Three Point %", 
            "<br/>Three Point Pct:",
            $value);

        $value = str_replace(
            "Free Throw %", 
            "<br/>Free Throw Pct:",
            $value);

        $value = str_replace(
            "Points Allowed Per Game", 
            "<br/>Points Allowed Per Game:",
            $value);  
            
        $aux = explode("<br/>", $value);
        $aux2 = [];

        foreach ($aux as $split){
            $aux3 = explode(":", $split);
            $aux4 = str_replace(",", ".", $aux3[1]);
            array_push($aux2, $aux4);
        }

        $stats = array(
            "PPG" => floatval($aux2[0]),
            "APG" => floatval($aux2[1]),
            "RPG" => floatval($aux2[2]),
            "BPG" => floatval($aux2[3]),
            "SPG" => floatval($aux2[4]),
            "TOPG" => floatval($aux2[5]),
            "FGPct" => floatval($aux2[6]),
            "FG3PPct" => floatval($aux2[7]),
            "FTPct" => floatval($aux2[8]),
            "OPPG" => floatval($aux2[9]),
        );

        return $stats;

    }

    function getInjuriesAttribute(){

        $injuries = new Collection;

        $this->getHTMLTeamDepth()
        ->filterXPath('//table[@class="ui selectable basic table"][3]
        /tbody
        /tr')
        ->each(function($tr) use($injuries){

            if($tr->filter('td')->eq(0)->text() <> "POS"){

                $name = $tr->filter('td')->eq(1)->text();

                $playerIDs = Player::select("UniqueID", "PlayerID")
                ->selectRaw('FirstName || " " || LastName as Name')
                ->where("Name", $name)
                ->get()[0];

                $dayInjury = Transaction::select("Transaction")
                ->where("PlayerID", $playerIDs['UniqueID'])
                ->where("Transaction", "LIKE", "+ Injured %")
                ->limit(1)
                ->orderBy("Key", "desc")
                ->get()[0]['Transaction'];

                $dayInjury = explode("(", $dayInjury)[1];
                $dayInjury = explode("/", $dayInjury);

                $timeline = str_replace("(OUT - ","", $tr->filter('td')->eq(3)->text());
                $timeline = str_replace(", "," (", $timeline);


                $injuries->push(
                    [
                    "PlayerName" => $name,
                    "PlayerID" => $playerIDs['PlayerID'],
                    "Date" => $dayInjury[0] . "/" . $dayInjury[1] ,
                    "Injury" => $tr->filter('td')->eq(2)->text(),
                    "Timeline" => $timeline,
                    ]
                );
            }
        });
            

        if($injuries->count() > 0)
            return $injuries;
        return "";

    }

    function getDraftPicks(){

        $aux = new Collection;
        $draftPicks = [];

        $this->getHTMLTeamInfo()
        ->filterXPath('//table[@class="ui selectable basic table"][1]
        /tbody
        /tr')
        ->each(function ($tr) use($aux) {

            $data = [];

            $data = $tr->filterXPath('//td')
            ->each(function ($td) {

                return $td->text();
                
                }
            );

            $aux->push($data);

            }

        );

        $dates = [];

        foreach($aux as $round){
            array_push($dates, $round[0]);
        }

        $dates = array_values(array_unique($dates));

        $p1 = [];
        $p2 = [];
        $p3 = [];
        $p4 = [];
        $p5 = [];
        $p6 = [];

        foreach($aux as $round){

            if($round[0] == $dates[0] && $round[1] == 1)
                array_push($p1, getTeamAbbrev($round[2]));

            else if($round[0] == $dates[0] && $round[1] == 2)
                array_push($p2, getTeamAbbrev($round[2]));

            if($round[0] == $dates[1] && $round[1] == 1)
                array_push($p3, getTeamAbbrev($round[2]));

            else if($round[0] == $dates[1] && $round[1] == 2)
                array_push($p4, getTeamAbbrev($round[2]));

            if($round[0] == $dates[2] && $round[1] == 1)
                array_push($p5, getTeamAbbrev($round[2]));

            else if($round[0] == $dates[2] && $round[1] == 2)
                array_push($p6, getTeamAbbrev($round[2]));
        }

        $draftPicks[$dates[0]]['1st Round'] = $p1;
        $draftPicks[$dates[0]]['2nd Round'] = $p2;
        $draftPicks[$dates[1]]['1st Round'] = $p3;
        $draftPicks[$dates[1]]['2nd Round'] = $p4;
        $draftPicks[$dates[2]]['1st Round'] = $p5;
        $draftPicks[$dates[2]]['2nd Round'] = $p6;

        return $draftPicks;
       
    }

    function getInsideRatingAttribute(){

        $ir = round($this->FG_ITP/100*42 + $this->FG_RA);
        if($ir >= 100)
            return 100;
        return $ir;

    }

    function getOutsideRatingAttribute(){

        $or = round(
            $this->FG_MID/100*32 +
            $this->FG_COR/100*78 +
            $this->FG_ATB/100*90);
        
        if($or >= 100)
            return 100;
        return $or;
            
    }

}

<?php

namespace App\Models;

use ErrorException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class Player extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'PlayerID';
    protected $connection = 'sqlite2';
    public $incrementing = false;

    function team(){
        return $this->hasOne(Team::class, 'TeamID', 'TeamID');
    }

    function otherInfo(){
        return $this->hasOne(PlayerOtherInfo::class, 'RookieID', 'PlayerID');
    }

    function seasonStats(){
        return $this->hasMany(SeasonStat::class, 'PlayerID', 'UniqueID');
    }

    function playOffStats(){
        return $this->hasMany(PlayoffStat::class, 'PlayerID', 'UniqueID');
    }

    function boxScore(){
        return $this->hasMany(BoxScore::class, 'PlayerID', 'PlayerID');
    }

    function awards(){
        return $this->hasMany(Award::class, 'PlayerID', 'UniqueID');
    }

    function transactions(){
        return $this->hasMany(Transaction::class, 'PlayerID', 'UniqueID');
    }

    function country(){
        return $this->hasOne(Country::class, 'Id', 'Country');
    }

    
/////////////////////////////////////////////////////////////////
//FUNCTIONS


    function Experience($text, $caps){

        if ($this->ProExperience == 0)
            if($caps){
                return "ROOKIE";
            return "Rookie";
            }

        if (($this->ProExperience == 1)){
            return $this->ProExperience . " " . $text;
        }

        if($caps)
            return $this->ProExperience . " " . $text . "S";
        return $this->ProExperience . " " . $text . "s";

    }


///////////////////////////////////////////////////////////////////
//QUERIES


    function currentSeason(){

        return Transaction::max('Season');

    }

    function transactionsHistory(){

        return $this->transactions()
        ->select('Transaction')
        ->orderBy('Key', 'desc')
        ->get();
        
    }


    function awardsWon(){
        
        return $this->awards()
        ->select('Season','AwardName')
        ->orderBy('Key', 'desc')
        ->get();

    }

    function statistics(){

        return $this->SeasonStats()
        ->where('G', ">", 0)
        ->where('SeasonID', "<", $this->currentSeason())
        ->orderBy('Key', 'desc')
        ->get();

    }

    function getIdPBLGamesAttribute(){

        $games = $this->boxScore()
        ->select("BoxScore.GameNo")
        ->where('BoxScore.GameNo', "<", 2307)  
        ->where('Minutes', ">", 0)      
        ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')   
        ->get()
        ->toArray();

        $idGames = [];
        
        foreach($games as $game){
            array_push($idGames, $game['GameNo']);
        }

        return $idGames;

    }

    function statsThisSeason(){

        $identifier = "RS";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){

            $pro =  $this->boxScore()
            ->selectRaw('"PBL Season" as SeasonID')
            ->selectRaw('"NoTeam" as Team')
            ->selectRaw('count(Starter) as G')
            ->selectRaw('sum(Starter) as GS')
            ->selectRaw('avg(Minutes) as MPG')
            ->selectRaw('avg(Points) as PPG')
            ->selectRaw('avg(Assists) as APG')
            ->selectRaw('(avg(ORebs) + avg(DRebs)) as RPG')
            ->selectRaw('avg(DRebs) as DRPG')
            ->selectRaw('avg(ORebs) as ORPG')
            ->selectRaw('avg(Steals) as SPG')
            ->selectRaw('avg(Blocks) as BPG')
            ->selectRaw('avg(Turnovers) as TOPG')
            ->selectRaw('sum(Points) as Points')
            ->selectRaw('sum(FGM) as FGM')
            ->selectRaw('sum(FGA) as FGA')
            ->selectRaw('CAST(sum(FGM) AS float) / CAST(sum(FGA) AS float) as FGPct')
            ->selectRaw('sum(FTM) as FTM')
            ->selectRaw('sum(FTA) as FTA')
            ->selectRaw('CAST(sum(FTM) AS float) / CAST(sum(FTA) AS float) as FTPct')
            ->selectRaw('sum(FG3PM) as FG3PM')
            ->selectRaw('sum(FG3PA) as FG3PA')
            ->selectRaw('CAST(sum(FG3PM) AS float) / CAST(sum(FG3PA) AS float) as FG3PPct')
            ->selectRaw('sum(Assists) as Assists')
            ->selectRaw('sum(DRebs) as DRebs')
            ->selectRaw('sum(ORebs) as ORebs')
            ->selectRaw('(sum(DRebs) + sum(ORebs)) as Rebounds')
            ->selectRaw('sum(Steals) as Steals')
            ->selectRaw('sum(Blocks) as Blocks')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Minutes) as Minutes')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Fouls) as Fouls')
            ->selectRaw('(Select count(Fouls)
                            from BoxScore
                            where Fouls = 6
                            and PlayerID = ?) as DQ', [$this->PlayerID])
            ->where('BoxScore.GameNo', "<", 2307) 
            ->where('Minutes', ">", 0)      
            ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')   
            ->groupBy("PlayerID")
            ->get();

            $dl =  $this->boxScore()
            ->selectRaw('"DBL Season" as SeasonID')
            ->selectRaw('"NoTeam" as Team')
            ->selectRaw('count(Starter) as G')
            ->selectRaw('sum(Starter) as GS')
            ->selectRaw('avg(Minutes) as MPG')
            ->selectRaw('avg(Points) as PPG')
            ->selectRaw('avg(Assists) as APG')
            ->selectRaw('(avg(ORebs) + avg(DRebs)) as RPG')
            ->selectRaw('avg(DRebs) as DRPG')
            ->selectRaw('avg(ORebs) as ORPG')
            ->selectRaw('avg(Steals) as SPG')
            ->selectRaw('avg(Blocks) as BPG')
            ->selectRaw('avg(Turnovers) as TOPG')
            ->selectRaw('sum(Points) as Points')
            ->selectRaw('sum(FGM) as FGM')
            ->selectRaw('sum(FGA) as FGA')
            ->selectRaw('CAST(sum(FGM) AS float) / CAST(sum(FGA) AS float) as FGPct')
            ->selectRaw('sum(FTM) as FTM')
            ->selectRaw('sum(FTA) as FTA')
            ->selectRaw('CAST(sum(FTM) AS float) / CAST(sum(FTA) AS float) as FTPct')
            ->selectRaw('sum(FG3PM) as FG3PM')
            ->selectRaw('sum(FG3PA) as FG3PA')
            ->selectRaw('CAST(sum(FG3PM) AS float) / CAST(sum(FG3PA) AS float) as FG3PPct')
            ->selectRaw('sum(Assists) as Assists')
            ->selectRaw('sum(DRebs) as DRebs')
            ->selectRaw('sum(ORebs) as ORebs')
            ->selectRaw('(sum(DRebs) + sum(ORebs)) as Rebounds')
            ->selectRaw('sum(Steals) as Steals')
            ->selectRaw('sum(Blocks) as Blocks')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Minutes) as Minutes')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Fouls) as Fouls')
            ->selectRaw('(Select count(Fouls)
                            from BoxScore
                            where Fouls = 6
                            and PlayerID = ?) as DQ', [$this->PlayerID])
            ->where('BoxScore.GameNo', "<", 2305)  
            ->where('Minutes', ">", 0)      
            ->whereNotIn('GameNo', $this->IdPBLGames)  
            ->groupBy("PlayerID")
            ->get();

            $collection = new Collection;

                if($pro->count() > 0)
                    $collection['PRO'] = $pro[0];
                if($dl->count() > 0)
                    $collection['DL'] = $dl[0];

            Cache::put($key, $collection, 86400);

        }

        return Cache::get($key);
        
    }

    function poStats(){

        return $this->playOffStats()
        ->where('G', ">", 0)
        ->orderBy('Key', 'desc')
        ->get();

    }

    function statsThisPlayOffs(){

        $identifier = "PO";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){

            $pro =  $this->boxScore()
            ->selectRaw('"PBL Season" as SeasonID')
            ->selectRaw('"NoTeam" as Team')
            ->selectRaw('count(Starter) as G')
            ->selectRaw('sum(Starter) as GS')
            ->selectRaw('avg(Minutes) as MPG')
            ->selectRaw('avg(Points) as PPG')
            ->selectRaw('avg(Assists) as APG')
            ->selectRaw('(avg(ORebs) + avg(DRebs)) as RPG')
            ->selectRaw('avg(DRebs) as DRPG')
            ->selectRaw('avg(ORebs) as ORPG')
            ->selectRaw('avg(Steals) as SPG')
            ->selectRaw('avg(Blocks) as BPG')
            ->selectRaw('avg(Turnovers) as TOPG')
            ->selectRaw('sum(Points) as Points')
            ->selectRaw('sum(FGM) as FGM')
            ->selectRaw('sum(FGA) as FGA')
            ->selectRaw('CAST(sum(FGM) AS float) / CAST(sum(FGA) AS float) as FGPct')
            ->selectRaw('sum(FTM) as FTM')
            ->selectRaw('sum(FTA) as FTA')
            ->selectRaw('CAST(sum(FTM) AS float) / CAST(sum(FTA) AS float) as FTPct')
            ->selectRaw('sum(FG3PM) as FG3PM')
            ->selectRaw('sum(FG3PA) as FG3PA')
            ->selectRaw('CAST(sum(FG3PM) AS float) / CAST(sum(FG3PA) AS float) as FG3PPct')
            ->selectRaw('sum(Assists) as Assists')
            ->selectRaw('sum(DRebs) as DRebs')
            ->selectRaw('sum(ORebs) as ORebs')
            ->selectRaw('(sum(DRebs) + sum(ORebs)) as Rebounds')
            ->selectRaw('sum(Steals) as Steals')
            ->selectRaw('sum(Blocks) as Blocks')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Minutes) as Minutes')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Fouls) as Fouls')
            ->selectRaw('(Select count(Fouls)
                            from BoxScore
                            where Fouls = 6
                            and PlayerID = ?) as DQ', [$this->PlayerID])
            ->where('BoxScore.GameNo', ">=", 2307) 
            ->where('Minutes', ">", 0)      
            ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')   
            ->groupBy("PlayerID")
            ->get();

            $dl =  $this->boxScore()
            ->selectRaw('"DBL Season" as SeasonID')
            ->selectRaw('"NoTeam" as Team')
            ->selectRaw('count(Starter) as G')
            ->selectRaw('sum(Starter) as GS')
            ->selectRaw('avg(Minutes) as MPG')
            ->selectRaw('avg(Points) as PPG')
            ->selectRaw('avg(Assists) as APG')
            ->selectRaw('(avg(ORebs) + avg(DRebs)) as RPG')
            ->selectRaw('avg(DRebs) as DRPG')
            ->selectRaw('avg(ORebs) as ORPG')
            ->selectRaw('avg(Steals) as SPG')
            ->selectRaw('avg(Blocks) as BPG')
            ->selectRaw('avg(Turnovers) as TOPG')
            ->selectRaw('sum(Points) as Points')
            ->selectRaw('sum(FGM) as FGM')
            ->selectRaw('sum(FGA) as FGA')
            ->selectRaw('CAST(sum(FGM) AS float) / CAST(sum(FGA) AS float) as FGPct')
            ->selectRaw('sum(FTM) as FTM')
            ->selectRaw('sum(FTA) as FTA')
            ->selectRaw('CAST(sum(FTM) AS float) / CAST(sum(FTA) AS float) as FTPct')
            ->selectRaw('sum(FG3PM) as FG3PM')
            ->selectRaw('sum(FG3PA) as FG3PA')
            ->selectRaw('CAST(sum(FG3PM) AS float) / CAST(sum(FG3PA) AS float) as FG3PPct')
            ->selectRaw('sum(Assists) as Assists')
            ->selectRaw('sum(DRebs) as DRebs')
            ->selectRaw('sum(ORebs) as ORebs')
            ->selectRaw('(sum(DRebs) + sum(ORebs)) as Rebounds')
            ->selectRaw('sum(Steals) as Steals')
            ->selectRaw('sum(Blocks) as Blocks')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Minutes) as Minutes')
            ->selectRaw('sum(Turnovers) as Turnovers')
            ->selectRaw('sum(Fouls) as Fouls')
            ->selectRaw('(Select count(Fouls)
                            from BoxScore
                            where Fouls = 6
                            and PlayerID = ?) as DQ', [$this->PlayerID])
            ->where('BoxScore.GameNo', ">=", 2307)  
            ->whereNotIn('GameNo', $this->IdPBLGames) 
            ->where('Minutes', ">", 0)      
            ->groupBy("PlayerID")
            ->get();

            $collection = new Collection;

            if($pro->count() > 0)
                $collection['PRO'] = $pro[0];
            else if ($dl->count() > 0)
                $collection['DL'] = $dl[0];

            Cache::put($key, $collection, 86400);

        }
        
        return Cache::get($key);
        
    }


    function getTotalStats(){

        $pro = new Collection; 
        $dl = new Collection;
        $stats = [];

        if(isset($this->statsThisSeason()['PRO']))
            $pro->push($this->statsThisSeason()['PRO']);
        if(isset($this->statsThisSeason()['DL']))
            $dl->push($this->statsThisSeason()['DL']);

        foreach($this->statistics() as $stats){
            if($stats->LeagueID == 1)
                $pro->push($stats);
            else
                $dl->push($stats);
        }

        $stats['DL'] = Player::calculateTotals($dl, "DL");
        $stats['PRO'] = Player::calculateTotals($pro);
        
        return $stats;

    }

    function getTotalPOStats(){

        $pro = new Collection; 
        $dl = new Collection;
        $stats = [];

        if(isset($this->statsThisPlayOffs()['PRO']))
            $pro->push($this->statsThisPlayOffs()['PRO']);
        if(isset($this->statsThisPlayOffs()['DL']))
            $dl->push($this->statsThisPlayOffs()['DL']);

        foreach($this->poStats() as $stats){
            if($stats->LeagueID == 1)
                $pro->push($stats);
            else
                $dl->push($stats);
        }

        $stats['DL'] = Player::calculateTotals($dl, "DL");
        $stats['PRO'] = Player::calculateTotals($pro);
        
        return $stats;

    }

    static function calculateTotals($seasons, $league="PRO"){

        $g = $seasons->sum('G');
        $total['G'] = $g;

        if($g > 0){

            $total['SeasonID'] = "CAREER";
            $total['CityName'] = $league;

            $total['GS'] = $seasons->sum('GS');

            $aux = $seasons->sum('Minutes');
            $total['Minutes'] = $aux;
            $total['MPG'] = $aux / $g;

            $aux = $seasons->sum('Points');
            $total['Points'] = $aux;
            $total['PPG'] = $aux / $g;

            $aux = $seasons->sum('Assists');
            $total['Assists'] = $aux;
            $total['APG'] = $aux / $g;

            $aux = $seasons->sum('Rebounds');
            $total['Rebounds'] = $aux;
            $total['RPG'] = $aux / $g;

            $aux = $seasons->sum('DRebs');
            $total['DRebs'] = $aux;
            $total['DRPG'] = $aux / $g;

            $aux = $seasons->sum('ORebs');
            $total['ORebs'] = $aux;
            $total['ORPG'] = $aux / $g;

            $aux = $seasons->sum('Steals');
            $total['Steals'] = $aux;
            $total['SPG'] = $aux / $g;

            $aux = $seasons->sum('Blocks');
            $total['Blocks'] = $aux;
            $total['BPG'] = $aux / $g;
            
            $aux = $seasons->sum('Turnovers');
            $total['Turnovers'] = $aux;
            $total['TOPG'] = $aux / $g;

            $aux = $seasons->sum('FGM');
            $total['FGM'] = $aux;

            $aux = $seasons->sum('FGA');
            $total['FGA'] = $aux;
            
            if($total['FGA'] == 0)
                $total['FGP'] = "000";
            else
                $total['FGP'] = round($total['FGM'] / $total['FGA'] * 1000, 0);

            $aux = $seasons->sum('FTM');
            $total['FTM'] = $aux;

            $aux = $seasons->sum('FTA');
            $total['FTA'] = $aux;

            if($total['FTA'] == 0)
                $total['FTP'] = "000";
            else
                $total['FTP'] = round($total['FTM'] / $total['FTA'] * 1000, 0);

            $aux = $seasons->sum('FG3PM');
            $total['FG3PM'] = $aux;

            $aux = $seasons->sum('FG3PA');
            $total['FG3PA'] = $aux;

            if($total['FG3PA'] == 0)
                $total['FG3PP'] = "000";
            else
                $total['FG3PP'] =  round($total['FG3PM'] / $total['FG3PA'] * 1000, 0);

            $total['DQ'] = $seasons->sum('DQ');

            $aux = $seasons->sum('PER');
            $total['PER'] = $aux / $g;

            $tsa = $total['FGA'] + 0.44 * $total['FTA'];
            $total['TS'] = round($total['Points'] / (2 * $tsa) * 1000, 0);

            if($g > 0)
                $total['EFF'] = round (((
                    $total['Points'] + 
                    $total['Rebounds'] + 
                    $total['Assists'] + 
                    $total['Steals'] + 
                    $total['Blocks']) 
                    - (
                        ($total['FGA'] - $total['FGM']) + 
                        ($total['FTA'] - $total['FTM']) + 
                        $total['Turnovers']
                )) / $total['G'], 1);
            
            else    
                $total['EFF'] = 0;

            return $total;

        }

    }


/////////////////////////////////////////////////////////////////////
//ATTRIBUTES
    

    function getPPGAttribute(){

        $identifier = "PPG";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){

            $stat = $this->boxScore()
            ->selectRaw('AVG(Points) as PPG')
            ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')
            ->where('BoxScore.GameNo', "<", 2307)  
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->get();

            if ($stat->count() == 0){

                $stat = $this->boxScore()
                ->selectRaw('AVG(Points) as PPG')
                ->where('BoxScore.GameNo', "<", 2305) 
                ->groupBy('PlayerID')
                ->get(); 

                if ($stat->count() > 0){

                    $value = round($stat[0]['PPG'], 1);

                } else {

                    $value = 0;

                }
            } else {

                $value = round($stat[0]['PPG'], 1);

            }

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);
        
    }

    function getAPGAttribute(){

        $identifier = "APG";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){
            $stat = $this->boxScore()
            ->selectRaw('AVG(Assists) as APG')
            ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')
            ->where('BoxScore.GameNo', "<", 2307)   
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->get();

            if ($stat->count() == 0){
                $stat = $this->boxScore()
                ->selectRaw('AVG(Assists) as APG')
                ->where('BoxScore.GameNo', "<", 2305) 
                ->groupBy('PlayerID')
                ->get(); 

                if ($stat->count() > 0){

                    $value = round($stat[0]['APG'], 1);

                } else {

                    $value = 0;

                }

            } else {

                $value = round($stat[0]['APG'], 1);
                
            }

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);
        
    }

    function getRPGAttribute(){

        $identifier = "RPG";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){
            $stat = $this->boxScore()
            ->selectRaw('AVG(ORebs + DRebs) as RPG')
            ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')
            ->where('BoxScore.GameNo', "<", 2307)   
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->get();

            if ($stat->count() == 0){
                $stat = $this->boxScore()
                ->selectRaw('AVG(ORebs + DRebs) as RPG')
                ->where('BoxScore.GameNo', "<", 2305) 
                ->groupBy('PlayerID')
                ->get(); 

                if ($stat->count() > 0){

                    $value = round($stat[0]['RPG'], 1);

                } else {

                    $value = 0;

                }

            } else {

                $value = round($stat[0]['RPG'], 1);
                
            }

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);
        
    }

    function getSPGAttribute(){

        $identifier = "SPG";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){
            $stat = $this->boxScore()
            ->selectRaw('AVG(Steals) as SPG')
            ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')
            ->where('BoxScore.GameNo', "<", 2307)  
            ->where('Minutes', ">", 0) 
            ->groupBy('PlayerID')
            ->get();

            if ($stat->count() == 0){
                $stat = $this->boxScore()
                ->selectRaw('AVG(Steals) as SPG')
                ->where('BoxScore.GameNo', "<", 2305) 
                ->groupBy('PlayerID')
                ->get(); 

                if ($stat->count() > 0){

                    $value = round($stat[0]['SPG'], 1);

                } else {

                    $value = 0;

                }

            } else {

                $value = round($stat[0]['SPG'], 1);
                
            }

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);
        
    }

    function getBPGAttribute(){

        $identifier = "BPG";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){
            $stat = $this->boxScore()
            ->selectRaw('AVG(Blocks) as BPG')
            ->join('Schedule', 'Schedule.GameNo', '=', 'BoxScore.GameNo')
            ->where('BoxScore.GameNo', "<", 2307)   
            ->where('Minutes', ">", 0)  
            ->groupBy('PlayerID')
            ->get();

            if ($stat->count() == 0){
                $stat = $this->boxScore()
                ->selectRaw('AVG(Blocks) as BPG')
                ->where('BoxScore.GameNo', "<", 2305) 
                ->groupBy('PlayerID')
                ->get();

                if ($stat->count() > 0){

                    $value = round($stat[0]['BPG'], 1);

                } else {

                    $value = 0;

                }

            } else {

                $value = round($stat[0]['BPG'], 1);
                
            }

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);
        
    }

    function getFranchiseAttribute(){
        if($this->TeamID <> 0)
            return $this->team->CityName . " " .$this->team->TeamName;
        return "Free Agent";
    }

    function getFullNameAttribute(){
        return $this->FirstName . " " . $this->LastName;
    }

    function getAbNameAttribute(){
        return $this->FirstName[0] . ". " . $this->LastName;
    }

    function getPosAttribute(){
        switch($this->Position){
            case 1:
            case 2:
                return "Guard";
            case 3:
            case 4:
                return "Forward";
            case 5:
                return "Center";
        }
    }

    function getAbPositionAttribute(){
        switch($this->Position){
            case 1:
                return "PG";
            case 2:
                return "SG";
            case 3:
                return "SF";
            case 4:
                return "PF";
            case 5:
                return "C";
        }
    }

    function getFullPositionAttribute(){
        switch($this->Position){
            case 1:
                return "Point Guard";
            case 2:
                return "Small Guard";
            case 3:
                return "Small Forward";
            case 4:
                return "Point Forward";
            case 5:
                return "Center";
        }
    }

    function getDraftAttribute(){
        if($this->DraftRound == 0)
            return "Undrafted";
        return "ROUND " . $this->DraftRound . " - PICK " . $this->DraftPick;
    }

    function getPlayerPhotoAttribute(){

        return "/images/players/" . $this->FirstName . "_" .  str_replace(" ", "_", $this->LastName) . ".png";

    }

    function getCollegeLogoAttribute(){

        return "images/logos/collegelogos/" . str_replace(" ", "", $this->College) . ".png";

    }

    function getCountryFlagAttribute(){
        return "/images/flags/" 
        . $this->country->logo;     
    }

    function getURLTeamAttribute(){
        return "/team/"
        . $this->team->TeamID;
    }

    function getURLPlayerAttribute(){
        return "/player/"
        . $this->PlayerID;
    }

    function getHeightAttribute(){
        return "$this->Feet-$this->Inches";
    }

    function getCMAttribute(){
        return $this->Feet * 30.48 + $this->Inches * 2.54;
    }

    function getDrawingFoulsAttribute(){
        if($this->DrawFoul * 4 <= 100)
            return $this->DrawFoul * 4;
        return 100;
    }

    function getExpiringAttribute(){
       return $this->ContractYear2 == 0 && $this->TeamID <> 0 ? true : false;
    }

    function getMoodAttribute(){

        if($this->AttitudeC >= 80 && $this->AttitudeT >= 80 && $this->AttitudeO >= 80)
            return 3;
        else if(($this->AttitudeC > 50 && $this->AttitudeC < 80)  || 
                ($this->AttitudeT > 50 && $this->AttitudeT < 80) ||
                ($this->AttitudeO > 50 && $this->AttitudeO < 80))
            return 2;
        else
            return 1;
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

    function idGames(){

        $arrayGames = $this->BoxScore()
        ->select('GameNo')
        ->distinct()
        ->get()
        ->toarray();

        $idGames  = [];

        foreach($arrayGames as $v){
            array_push($idGames, $v['GameNo']);
        }

        return $idGames;
    }

    function getTotalValueAttribute(){
        return $this->ContractYear1 +
        $this->ContractYear2 +
        $this->ContractYear3 +
        $this->ContractYear4 +
        $this->ContractYear5;
    }

    function getFAYearAttribute(){

        return $this->currentSeason() + $this->ContractYearsLeft;

    }

    function getContractTypeAttribute(){

        $identifier = "CT";
        $key = $this->PlayerID . "_" . $identifier;
        $value = "";

        if (!Cache::has($key)){

            $team = Team::findorfail($this->TeamID);

            $array = $team->getHTMLTeamRatings()
            ->filterXPath('//table[@class="ui selectable basic table"][2]/tbody/tr')
            ->each(function ($tr) {

                $text = $tr->text();
                $pos = strpos($text, $this->Full_Name);
                
                if($pos){
                    try{

                        if(!strpos($text, "(DLG)")){
                            $aux = explode("(", $tr->text());
                            $aux2 = explode(")", $aux[1]);
                            return $aux2[0];
                        }else{
                            $aux = explode("(DLG)", $tr->text());
                            $aux2 = explode("(", $aux[1]);
                            $aux3 = explode(")", $aux2[1]);
                            return $aux3[0];
                        }

                    }catch (ErrorException $e){

                        return "";

                    }
                }    
            }); 

            foreach($array as $type){
                if($type <> "" && $type <> "DLG"){
                    $value = $type;
                }
            }

            Cache::put($key, $value, 86400);
            
        }return Cache::get($key); 

    }

    function getPIEAttribute(){

        $identifier = "PIE";
        $key = $this->PlayerID . "_" . $identifier;

        /* PIE Formula=(PTS + FGM + FTM - FGA - FTA + DREB + (.5 * OREB) + AST + STL + (.5 * BLK) - PF - TO) 
        / (GmPTS + GmFGM + GmFTM - GmFGA - GmFTA + GmDREB + (.5 * GmOREB) + GmAST + GmSTL + (.5 * GmBLK) - GmPF - GmTO */

        if (!Cache::has($key)){

             //PTS + FGM + FTM - FGA - FTA + DREB + (.5 * OREB) + AST + STL + (.5 * BLK) - PF - TO)
            $part1 = $this->boxScore()
            ->selectRaw("sum(Points + FGM + FTM - FGA - FTA + DRebs + (0.5 * Orebs) + Assists + Steals + (0.5 * Blocks) - Fouls - Turnovers) AS PIE1")
            ->get()
            ->toArray();

            //(GmPTS + GmFGM + GmFTM - GmFGA - GmFTA + GmDREB + (.5 * GmOREB) + GmAST + GmSTL + (.5 * GmBLK) - GmPF - GmTO
            $part2 = BoxScore::
            selectRaw("sum(Points + FGM + FTM - FGA - FTA + DRebs + (0.5 * Orebs) + Assists + Steals + (0.5 * Blocks) - Fouls - Turnovers) AS PIE2")
            ->whereIn('GameNo', $this->idGames())
            ->get()
            ->toArray();

            $pie[0] = $part1[0]['PIE1'];
            $pie[1] = $part2[0]['PIE2'];

            $value = round($pie[0] / $pie[1] * 100, 2);

            Cache::put($key, $value, 86400);

        }return Cache::get($key);

    }

    function getHTMLPlayer(){
        $client = new HttpBrowser(HttpClient::create());
        return $client->request('GET', 
        "/html/" . $this->UniqueID . ".html");  
    }

    function getHTMLTeamRatings(){
        $client = new HttpBrowser(HttpClient::create());
        return $client->request('GET', 
        "/html/" . $this->team->TeamAbbrev . "" 
        . $this->team->TeamName. "_Ratings.html");  
    }

    function getHTMLTeamRoster(){

        $client = new HttpBrowser(HttpClient::create());

        if($this->TeamID <> 0)
            return $client->request('GET', 
            "/html/" . $this->team->TeamAbbrev . "" 
            . $this->team->TeamName. "_Roster.html"); 
        else{
            return $client->request('GET', 
            "/html/" . "FA.html"); 
        } 
    }

    function searchResult($value){

        return $this->getHTMLPlayer()
        ->filterXPath($value)
        ->each(function ($node) {
            $string = explode(":", $node->text());
            return $string[1];   
        });      
    }

    function getInjuryAttribute(){

        try{

            return $this->getHTMLPlayer()
            ->filterXPath('//div[@class="ui red mini label"][1]')
            ->eq(0)
            ->text();

        }catch(InvalidArgumentException $e){
            return "";
        }

    }

    function getExtensionElegibleAttribute(){

        return explode(" : ", $this->getHTMLPlayer()
        ->filterXPath('//div[@class="ui list"][4]
        /div[@class="item"][7]
        /div[@class="content"]')
        ->text())[1];

    }

    function getOptionElegibleAttribute(){

        return explode(" : ", $this->getHTMLPlayer()
        ->filterXPath('//div[@class="ui list"][4]
        /div[@class="item"][8]
        /div[@class="content"]')
        ->text())[1];

    }

    function getPlayerOptionAttribute(){

        $this->getHTMLTeamRatings()
        ->filterXPath('//table[@class="ui selectable basic table"][2]
        /tbody
        /tr')
        ->each(function ($tr) {
            if(str_contains($tr->text(), "(PO)") &&
                str_contains($tr->text(), $this->Full_Name)){

                    return true;

                }

        }); 

        return false;

    }

    function getTeamOptionAttribute(){

        $this->getHTMLTeamRatings()
        ->filterXPath('//table[@class="ui selectable basic table"][2]
        /tbody
        /tr')
        ->each(function ($tr) {
            if(str_contains($tr->text(), "(TO)") &&
                str_contains($tr->text(), $this->Full_Name)){

                    return true;

                }

        }); 

        return false;

    }

    function getAchievementsArray($crawler){

        $achievements = $crawler;

        return array(
            "Points" => $achievements[0],
            "Assists" => $achievements[1],
            "Rebounds" => $achievements[2],
            "Blocks" => $achievements[3],
            "Steals" => $achievements[4],
            "Double Doubles" => $achievements[5],
            "Triple Doubles" => $achievements[6],
            "All Star Games" => $achievements[7],
            "Titles Won" => $achievements[8],
            "Player of the Game" => $achievements[9],
            "Player of the Week" => $achievements[10],
            "Player of the Month" => $achievements[11],
            "Rookie of the Month" => $achievements[12],
        );
    }

    function getAllPER($id){

        if($id == 3)
            $identifier = "PER_RS";
        else
            $identifier = "PER_PO";

        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){

            $value = $this->getHTMLPlayer()
            ->filterXPath('//table[@class="ui selectable basic table"][' . $id . ']
                /tbody
                /tr')
            ->each(function ($tr) {
                return $tr->filterXPath("//td")
                ->eq(30)
                ->text();
              
            }); 
            
            Cache::put($key, $value, 86400);
            
        }return Cache::get($key);

    }
    
    function currentRating(){

        $identifier = "CR";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){

            $crawler = $this->getHTMLPlayer();

            $aux = $crawler
            ->filter('div')
            ->eq(21)
            ->evaluate('count(//i
                [@class="star icon"]
                [@style="color:#FFFFFF"])');
    
            $currentRating[0] = $aux[0];
    
            $aux = $crawler
            ->filter('div')
            ->eq(21)
            ->evaluate('count(//i
                [@class="star half icon"]
                [@style="color:#FFFFFF"])');
    
            $currentRating[1] = $aux[0];
            
            Cache::put($key, $currentRating, 86400);
            
        }return Cache::get($key);

    }

    function potentialRating(){

        $identifier = "PR";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){

            $crawler = $this->getHTMLPlayer();

            $aux = $crawler
            ->filter('div')
            ->eq(21)
            ->evaluate('count(//i
                [@class="star icon"]
                [@style="color:#F8F8F8"])');
    
            $potentialRating[0] = $aux[0];
    
            $aux = $crawler
            ->filter('div')
            ->eq(21)
            ->evaluate('count(//i
                [@class="star half icon"]
                [@style="color:#F8F8F8"])');
    
            $potentialRating[1] = $aux[0];
            
            Cache::put($key, $potentialRating, 86400);
            
        }return Cache::get($key);

    }

    function getPlayerType(){

        $identifier = "PT";
        $key = $this->PlayerID . "_" . $identifier;

        if (!Cache::has($key)){

            $crawler = $this->getHTMLTeamRoster()
            ->filterXPath("//table[@class='ui selectable basic table'][1]
            /tbody
            /tr")
            ->each(function ($tr){

                if(str_contains($tr->text(), $this->Full_Name)){
                    return $tr->filter('td')
                    ->eq(14)
                    ->filter('span')
                    ->each(function ($span){
                        return $span->attr('data-tooltip');
                    });

                }


            }); 

            $crawler = array_filter($crawler);
            $playerTypes = [];

            foreach($crawler as $aux)
                foreach($aux as $type)
                    array_push($playerTypes, $type);

            Cache::put($key, $playerTypes, 86400*365);
    
        }return Cache::get($key);

    }

    function getPlayerTypeIconsAttribute(){

        $types = $this->getPlayerType();
        $icons = [];

        foreach($types as $type){

            switch($type){

                case "Bucket Getter":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Bucket Getter" class="fa-solid black fa-fill"></i>');
                    break;

                case "Sharpshooter":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Sharpshooter"class="fa-solid black fa-crosshairs"></i>');
                    break;
        
                case "Attacker":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Attacker" class="fa-solid black fa-bolt-lightning"></i>');
                    break;
                    
                case "Paint Dominator":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Paint Dominator" class="fa-solid black fa-paint-roller"></i>');
                    break;

                case "Ball Magician":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Ball Magician" class="fa-solid black fa-hat-wizard"></i>');
                    break;

                case "Playmaker":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Playmaker" class="fa-solid black fa-wand-magic-sparkles"></i>');
                    break;
                    
                case "Defender":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Defender" class="fa-solid black fa-shield"></i>');
                    break;
                    
                case "Clean Up":
                    array_push($icons, '<i data-toggle="tooltip" data-placement="top" title="Clean Up" class="fa-solid black fa-paintbrush"></i>');
                    break;

            }

        }

        return $icons;

    }

}

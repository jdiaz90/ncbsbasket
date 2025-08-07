<?php

namespace App\Models;

use ErrorException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Coach extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'CoachID';
    protected $connection = 'sqlite2';
    public $incrementing = false;

    function coachTeam(){
        return $this->hasOne(Team::class, 'TeamID', 'TeamID');
    }

/*     function awards(){
        return $this->hasMany(Award::class, 'PlayerID', 'UniqueID');
    }  */

    function coachHistory(){
        return $this->hasMany(CoachHistory::class, 'CoachID', 'CoachID');
    }

    function getFullNameAttribute(){

        return $this->FirstName . " " . $this->LastName;

    }

    function getFranchiseAttribute(){

        if($this->TeamID <> 0)
            return $this->coachTeam->CityName . " " .$this->coachTeam->TeamName;
        return "Free Agent";

    }

    function getPlayerPhotoAttribute(){

        return "/images/nonplayers/" . $this->FirstName . "_" .  str_replace(" ", "_", $this->LastName) . ".png";

    }

    function getURLTeamAttribute(){
        return "/team/"
        . $this->TeamID;
    }

    function getTeamColorAttribute(){

        try{
            
            $hex = $this->coachTeam->TeamColor;
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            return "rgba(" . $r . ", " . $g .", ". $b. ", 0.5)";

        }catch(ErrorException $e){
            
            return "rgba(128, 128, 0, 0.5)";

        }

    }

    function getTeamColor2Attribute(){

        try{
            
            $hex = $this->coachTeam->TeamColor;
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            return "rgb(" . $r . ", " . $g .", ". $b . ")";

        }catch(ErrorException $e){
            
            return "rgb(128, 128, 0)";

        }

    }

    function getHTMLTeamRoster(){

        $client = new HttpBrowser(HttpClient::create());

        if($this->TeamID > 0){
            return $client->request('GET', 
            "/html/" . $this->coachTeam->TeamAbbrev . "" 
            . $this->coachTeam->TeamName. "_Roster.html");  
        }

        return $client->request('GET', 
        "/html/FACoach.html");  

    }

    function getCoaches($i=2){

        return $this->getHTMLTeamRoster()
        ->filterXPath("//table[" . $i ."]
        /tbody
        /tr")
        ->each(function ($node) {
            return $node->text();   
        });   
    
    }

    function getCoach($i=2){

        $coaches = $this->getCoaches($i);
        $position = 0;

        foreach($coaches as $coach){
            if (str_contains($coach, $this->Full_Name))
                return $position + 1;
            $position++;
        }

        return -1;

    }

    function getCoachOtherInfo(){

        $coach = $this->getCoach();
        $arrayCoach = [];

        if($coach > -1){

            $info = $this->getHTMLTeamRoster()
            ->filterXPath("//table[2]
            /tbody
            /tr[" . $coach. "]");

            switch($coach){

                    case 1:
                        $arrayCoach['Job'] = "Head Coach";
                        break;
                    case 2:
                        $arrayCoach['Job'] = "1st Assistant Coach";
                        break;
                    case 3:
                        $arrayCoach['Job'] = "2nd Assistant Coach";
                        break;
                    case 4:
                        $arrayCoach['Job'] = "3rd Assistant Coach";
                        break;

            }

            $winLosses = explode("-", $info->filter('td')->eq(2)->text());

            if($winLosses[0] == ""){

                $arrayCoach['Wins'] = 0; 
                $arrayCoach['Losses'] = 0; 

            }else{

                $losses = explode(" (", $winLosses[1])[0];

                $arrayCoach['Wins'] = $winLosses[0]; 
                $arrayCoach['Losses'] = $losses; 

            }

            $arrayCoach['CareerPO'] = $info->filter('td')->eq(4)->text();
            $arrayCoach['CareerTitles'] = $info->filter('td')->eq(5)->text();
            $arrayCoach['Experience'] = $info->filter('td')->eq(6)->text();
            $arrayCoach['Salary'] = $info->filter('td')->eq(7)->text();

        }else{

            $arrayCoach['Job'] = "General Manager";
            $arrayCoach['Wins'] = 0;
            $arrayCoach['Losses'] = 0;
            $arrayCoach['CareerPO'] = 0;
            $arrayCoach['CareerTitles'] = 0;
            $arrayCoach['Experience'] = 0;
            $arrayCoach['Salary'] = 0;

        }

        return $arrayCoach;

    }

    function getFACoachOtherInfo(){

        $coach = $this->getCoach(1);
        $arrayCoach = [];

        $info = $this->getHTMLTeamRoster()
        ->filterXPath("//table[1]
        /tbody
        /tr[" . $coach. "]");

      try{

        $arrayCoach['Job'] = "Unemployed";

        $winLosses = explode("-", $info->filter('td')->eq(3)->text());
        $losses = explode(" (", $winLosses[1])[0];
 
        $arrayCoach['Wins'] = $winLosses[0]; 
        $arrayCoach['Losses'] = $losses; 
        $arrayCoach['Experience'] = $info->filter('td')->eq(2)->text();
        $arrayCoach['CareerPO'] = $info->filter('td')->eq(4)->text();
        $arrayCoach['CareerTitles'] = $info->filter('td')->eq(5)->text();
        $arrayCoach['Salary'] = 0;

        return $arrayCoach;

      }catch(InvalidArgumentException $e){
      
        return abort(404);

      }
      
    }

    function getPersonalityTextAttribute(){

        if($this->Personality == 75 ||
            $this->Personality == 10 ||
            $this->Personality == 9)
            return "Excelent";

        if($this->Personality == 8 ||
            $this->Personality == 7)
            return "Good";

        if($this->Personality == 6 ||
            $this->Personality == 5)
            return "Normal";
        
        if($this->Personality == 4 ||
            $this->Personality == 3)
            return "Poor";

        if($this->Personality == 2 ||
            $this->Personality == 1)
            return "Terrible";
    }

    function getGreedAttribute(){

        if($this->CoachGreed == 9)
            return "Very High";

        if($this->CoachGreed == 8)
            return "High";

        if($this->CoachGreed == 7)
            return "Good";
        
        if($this->CoachGreed == 6||
            $this->CoachGreed == 5)
            return "Average";

        if($this->CoachGreed == 4 ||
            $this->CoachGreed == 3)
            return "Low";

        if($this->CoachGreed == 2)
            return "Very Low";
    }

    function getPrefPlayersAttribute(){

        if($this->CoachPrefPlayers == 10 ||
            $this->CoachPrefPlayers == 9)
            return "Heavily Favors Veteran Players";

        if($this->CoachPrefPlayers == 8 ||
            $this->CoachPrefPlayers == 7)
            return "Prefers Veteran Players";

        if($this->CoachPrefPlayers == 6 ||
            $this->CoachPrefPlayers == 5)
            return "No Preferences";
        
        if($this->CoachPrefPlayers == 4 ||
            $this->CoachPrefPlayers == 3)
            return "Prefers Young Players";

        if($this->CoachPrefPlayers == 2 ||
            $this->CoachPrefPlayers == 1)
            return "Heavily Favors Young Players";
            
    }

    function getPrefRotationAttribute(){

        if($this->CoachPrefRotation == 10 ||
            $this->CoachPrefRotation == 9)
            return "Heavily Favors Deep Bench";

        if($this->CoachPrefRotation == 8 ||
            $this->CoachPrefRotation == 7)
            return "Prefers Deep Bench";

        if($this->CoachPrefRotation == 6 ||
            $this->CoachPrefRotation == 5)
            return "Balanced Rotation";
        
        if($this->CoachPrefRotation == 4 ||
            $this->CoachPrefRotation == 3)
            return "Prefers Short Bench";

        if($this->CoachPrefRotation == 2 ||
            $this->CoachPrefRotation == 1)
            return "Heavily Favors Short Bench";
            
    }

    function getPrefTempoAttribute(){

        if($this->CoachPrefTempo == 10 ||
            $this->CoachPrefTempo == 9)
            return "Very Fast Pace";

        if($this->CoachPrefTempo == 8 ||
            $this->CoachPrefTempo == 7)
            return "Fast Pace";

        if($this->CoachPrefTempo == 6 ||
            $this->CoachPrefTempo == 5)
            return "Average Pace";
        
        if($this->CoachPrefTempo == 4 ||
            $this->CoachPrefTempo == 3)
            return "Slow Pace";

        if($this->CoachPrefTempo == 2 ||
            $this->CoachPrefTempo == 1)
            return "Very Slow Pace";
            
    }

    function getPrefTempoListAttribute(){

        if($this->CoachPrefTempo == 10 ||
            $this->CoachPrefTempo == 9)
            return "Very Fast";

        if($this->CoachPrefTempo == 8 ||
            $this->CoachPrefTempo == 7)
            return "Fast";

        if($this->CoachPrefTempo == 6 ||
            $this->CoachPrefTempo == 5)
            return "Average";
        
        if($this->CoachPrefTempo == 4 ||
            $this->CoachPrefTempo == 3)
            return "Slow";

        if($this->CoachPrefTempo == 2 ||
            $this->CoachPrefTempo == 1)
            return "Very Slow";
            
    }

    function getPrefTempoOrderAttribute(){

        if($this->CoachPrefTempo == 10 ||
            $this->CoachPrefTempo == 9)
            return 5;

        if($this->CoachPrefTempo == 8 ||
            $this->CoachPrefTempo == 7)
            return 4;

        if($this->CoachPrefTempo == 6 ||
            $this->CoachPrefTempo == 5)
            return 3;
        
        if($this->CoachPrefTempo == 4 ||
            $this->CoachPrefTempo == 3)
            return 2;

        if($this->CoachPrefTempo == 2 ||
            $this->CoachPrefTempo == 1)
            return 1;
            
    }
    
    function getPrefCrashOBoardAttribute(){

        if($this->CoachPrefCrashOReb == 10 ||
            $this->CoachPrefCrashOReb == 9)
            return "Always Crash";

        if($this->CoachPrefCrashOReb == 8 ||
            $this->CoachPrefCrashOReb == 7)
            return "Usually Crash";

        if($this->CoachPrefCrashOReb == 6 ||
            $this->CoachPrefCrashOReb == 5)
            return "Sometimes Crash";
        
        if($this->CoachPrefCrashOReb == 4 ||
            $this->CoachPrefCrashOReb == 3)
            return "Rarely Crash";

        if($this->CoachPrefCrashOReb == 2 ||
            $this->CoachPrefCrashOReb == 1)
            return "Never Crash";
            
    }

    function getPrefIntensityAttribute(){

        if($this->CoachPrefPressure == 10 ||
        $this->CoachPrefPressure == 9)
        return "Tenacious";

        if($this->CoachPrefPressure == 8 ||
            $this->CoachPrefPressure == 7)
            return "Slightly High";

        if($this->CoachPrefPressure == 6 ||
            $this->CoachPrefPressure == 5)
            return "Normal";
        
        if($this->CoachPrefPressure == 4 ||
            $this->CoachPrefPressure == 3)
            return "Slightly Low";

        if($this->CoachPrefPressure == 2 ||
            $this->CoachPrefPressure == 1)
            return "Sag";
            
    }

    function getPrefIntensityListAttribute(){

        if($this->CoachPrefPressure == 10 ||
            $this->CoachPrefPressure == 9)
            return "Very High";

        if($this->CoachPrefPressure == 8 ||
            $this->CoachPrefPressure == 7)
            return "High";

        if($this->CoachPrefPressure == 6||
            $this->CoachPrefPressure == 5)
            return "Average";
        
        if($this->CoachPrefPressure == 4||
            $this->CoachPrefPressure == 3)
            return "Low";

        if($this->CoachPrefPressure == 2||
            $this->CoachPrefPressure == 1)
            return "Very Low";
   
    }
    
    function getPrefIntensityOrderAttribute(){

        if($this->CoachPrefPressure == 10 ||
            $this->CoachPrefPressure == 9)
            return 5;

        if($this->CoachPrefPressure == 8 ||
            $this->CoachPrefPressure == 7)
            return 4;

        if($this->CoachPrefPressure == 6||
            $this->CoachPrefPressure == 5)
            return 3;
        
        if($this->CoachPrefPressure == 4||
            $this->CoachPrefPressure == 3)
            return 2;

        if($this->CoachPrefPressure == 2||
            $this->CoachPrefPressure == 1)
            return 1;
   
    } 

    function getPrefCrashDBoardAttribute(){

        if($this->CoachPrefCrashDReb == 10 ||
            $this->CoachPrefCrashDReb == 9)
            return "Always Crash";

        if($this->CoachPrefCrashDReb == 8 ||
            $this->CoachPrefCrashDReb == 7)
            return "Usually Crash";

        if($this->CoachPrefCrashDReb == 6 ||
            $this->CoachPrefCrashDReb == 5)
            return "Sometimes Crash";
        
        if($this->CoachPrefCrashDReb == 4 ||
            $this->CoachPrefCrashDReb == 3)
            return "Rarely Crash";

        if($this->CoachPrefCrashDReb == 2 ||
            $this->CoachPrefCrashDReb == 1)
            return "Never Crash";
            
    }

    function getPrefFCDefenseAttribute(){

        if($this->CoachPrefFullCtD == 10 ||
            $this->CoachPrefFullCtD == 9)
            return "Always Pressure";

        if($this->CoachPrefFullCtD == 8 ||
            $this->CoachPrefFullCtD == 7)
            return "Usually Pressure";

        if($this->CoachPrefFullCtD == 6||
            $this->CoachPrefFullCtD == 5)
            return "Sometimes Pressure";
        
        if($this->CoachPrefFullCtD == 4 ||
            $this->CoachPrefFullCtD == 3 ||
            $this->CoachPrefFullCtD == 2 ||
            $this->CoachPrefFullCtD == 1)
            return "Rarely Pressure";
   
    } 
    
    function getPrefZoneDefenseAttribute(){

        if($this->CoachPrefHalfCtZoneD == 10 ||
            $this->CoachPrefHalfCtZoneD == 9)
            return "Always Zone";

        if($this->CoachPrefHalfCtZoneD == 8 ||
            $this->CoachPrefHalfCtZoneD == 7)
            return "Usually Zone";

        if($this->CoachPrefHalfCtZoneD == 6||
            $this->CoachPrefHalfCtZoneD == 5)
            return "Sometimes Zone";
        
        if($this->CoachPrefHalfCtZoneD == 4 ||
            $this->CoachPrefHalfCtZoneD == 3)
            return "Rarely Zone";

        if($this->CoachPrefHalfCtZoneD == 2 ||
            $this->CoachPrefHalfCtZoneD == 1)
            return "Never Zone";
   
    } 


}

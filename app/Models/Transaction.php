<?php

namespace App\Models;

use ErrorException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Transaction extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $connection = 'sqlite';
    protected $primaryKey = 'Key';

    function team(){
        return $this->hasOne(Team::class, "TeamID", "TeamID")
        ->orderBy('Key', 'desc');
    }

    function player(){
        return $this->hasOne(Player::class, "UniqueID", "PlayerID");
    }

    function day(){
        return $this->hasOne(Day::class, "ID", "Day");
    }

    function formerPlayer(){
        
        try{

            return SeasonStat::select('Team')
            ->selectRaw('PlayerName as Name')
            ->where('PlayerID', $this->PlayerID)
            ->orderBy('Key', 'desc')
            ->limit(1)
            ->get()[0];

        }catch (ErrorException $e){

            $collection = new Collection;
            $array = [];
            $array['Name'] = $this->PlayerName;
            $collection->push($array);
            
            return $collection[0];

        }

    }

    function getcoachIDAttribute(){
        
        $coaches = Coach::
        select("CoachID","FirstName", "LastName")
        ->get();

        foreach($coaches as $coach)

            if($coach->Full_Name == $this->PlayerName)
                return $coach->CoachID;
            
        return 0;

    }

    function getContractLengthAttribute(){

        if(str_contains($this->Transaction, "1 years")){
            return 1;
        }

        if(str_contains($this->Transaction, "2 years")){
            return 2;
        }

        if(str_contains($this->Transaction, "3 years")){
            return 3;
        }

        if(str_contains($this->Transaction, "4 years")){
            return 4;
        }

        if(str_contains($this->Transaction, "5 years")){
            return 5;
        }

        return 0;

    }

    function playersTrade(){

        $transaction = $this->Transaction;
        $re = '/,? PG |,? SG |,? SF |,? PF |,? C |,? [0-9]{4,5} /m';

        $trade = explode(" trade", $transaction)[1];
        $trade = explode(" for ", $trade);

        $team = [];

        $team[0] = preg_split($re, $trade[0]);
        $team[1] = preg_split($re, $trade[1]);


        $names = Player::select("PlayerID", "Position")
        ->selectraw('FirstName || " " || LastName as Name')
        ->get();

        $positions = [
            0 => " PG ",
            1 => " SG ",
            2 => " SF ",
            3 => " PF ",
            4 => " C ",
        ];

        foreach($positions as $position){
            $transaction = str_replace($position, "", $transaction);
        }


        foreach($team[0] as $player){
            
            foreach($names as $name){

                if(trim($player) == trim($name['Name'])) {  
                    $transaction = str_replace($player, ' <a href="/player/' . $name->PlayerID . '">
                    ' . $name->AbPosition . ' ' . $player . '</a>', $transaction);
                    break;
                }
                    
            }

        }

        foreach($team[1] as $player){
            
            foreach($names as $name){

                if(trim($player) == trim($name['Name'])) {  
                    $transaction = str_replace($player, ' <a href="/player/' . $name->PlayerID . '">
                    ' . $name->AbPosition . ' ' . $player . '</a>', $transaction);
                    break;
                }
                    
            }

        }

        return explode(" (", $transaction)[0];  

    }

    function getOtherTextAttribute(){

        try{

            if (str_contains($this->Transaction, 'Recalled')) {

                $aux = str_replace('Recalled', 'recall <a href="/player/' . $this->player->PlayerID .'">' . $this->player->AbPosition . " 
                " . $this->player->Full_Name . "</a>", $this->Transaction);

                return explode(" (",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Assigned')) {
                
                $aux = str_replace('Assigned', 'assign <a href="/player/' . $this->player->PlayerID .'">' . $this->player->AbPosition . " 
                " . $this->player->Full_Name . "</a>", $this->Transaction);

                return explode(" (",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'tender')) {

                $aux = str_replace("tender", '<a href="/player/' . $this->player->PlayerID .'">' 
                . $this->player->Full_Name . "</a> accepts a 1 year tender", $this->Transaction);

                $aux = str_replace('with', "from", $aux);

                $aux = str_replace($this->team->TeamName, $this->team->Franchise, $aux);

                $aux = explode('Signed a 1 year ', $aux)[1];

                return explode("(",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Signed') &&
                    !str_contains($this->Transaction, 'deal')) {
                
                $aux = str_replace('Signed', 'sign free agent <a href="/player/' . $this->player->PlayerID .'">' . $this->player->AbPosition . " 
                " . $this->player->Full_Name . "</a>", $this->Transaction);

                return explode(" by the",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Signed') &&
                str_contains($this->Transaction, 'deal')) {
            
                    $aux = $this->Transaction;
                    $aux = str_replace('Signed by the '. $this->team->TeamName .' as a free agent for a deal',
                    $this->team->Franchise. ' sign <a href="/player/'. $this->player->PlayerID.'">' . $this->PlayerName . '</a> to a 
                    ' . $this->contractLength .'-year contract', $aux);
    
                    $aux = str_replace(' over ' . $this->contractLength. ' years', '', $aux);

                    $aux = str_replace('(C)', '', $aux);
                    $aux = str_replace('(L)', '', $aux);

                    $aux = explode(" (", $aux)[0];
    
                    return $aux; 

            }

            else if (str_contains($this->Transaction, 'Released')) {
                
                $aux = str_replace('Released', '<a href="/player/' . $this->player->PlayerID .'">' . $this->player->AbPosition . " 
                " . $this->player->Full_Name . "</a> has been released by the " . $this->team->TeamName, $this->Transaction);

                return explode(" by the " . $this->team->TeamName . " (", $aux)[0]; 

            }

            else if (str_contains($this->Transaction, ' trade ')) {
                
                return $this->playersTrade(); 

            }

            else if (str_contains($this->Transaction, 'Had rookie option')) {

                $aux = str_replace('Had rookie option', 'have picked up the rookie option on <a href="/player/' . $this->player->PlayerID .'">' 
                . $this->player->Full_Name . "</a>", $this->Transaction);

                return explode(" picked up by ",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Draft rights exercised')) {

                $aux = str_replace('Draft rights exercised', 'exercise draft rights on <a href="/player/' . $this->player->PlayerID .'">' 
                . $this->player->Full_Name . "</a>", $this->Transaction);

                return explode(" by the",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Hired as head coach')) {

                $aux = $this->Transaction;
                $aux = str_replace('Hired as head coach by the '. $this->team->TeamName .' for a deal',
                'sign <a href="/coach/'. $this->coachID.'">' . $this->PlayerName . '</a> to a 
                ' . $this->contractLength .' year contract', $aux);

                $aux = str_replace('for ' . $this->contractLength. ' years',
                'for the job of head coach',
                $aux);

                $aux = str_replace('$$', '$', $aux);

                $aux = explode(" (", $aux)[0];

                return $aux; 

            }

            else if (str_contains($this->Transaction, 'Hired as general manager')) {

                $aux = $this->Transaction;
                $aux = str_replace('Hired as general manager by the '. $this->team->TeamName,
                'sign <a href="/coach/'. $this->coachID.'">' . $this->PlayerName . '</a> for the job of general manager',
                $aux);

                $aux = explode(" (", $aux)[0];

                return $aux; 

            }

            else if (str_contains($this->Transaction, 'Agreed to')) {

                $aux = str_replace('Agreed to ',
                '<a href="/player/'. $this->player->PlayerID.'">' . $this->player->AbPosition . ' ' . $this->PlayerName . '</a> agrees to sign ', $this->Transaction);

                $aux = explode(" (", $aux)[0];

                return $aux; 

            }

    
            return $this->Transaction;
        } catch(ErrorException $e){
    
            if (str_contains($this->Transaction, 'Recalled')) {

                $aux = str_replace('Recalled', 'recall <a href="/formerplayer/' . $this->PlayerID .'">'   . $this->formerPlayer()['Name'] . "</a>", $this->Transaction);

                return explode(" (",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Assigned')) {
                
                $aux = str_replace('Assigned', 'assign <a href="/formerplayer/' . $this->PlayerID .'">'   . $this->formerPlayer()['Name'] . "</a>", $this->Transaction);

                return explode(" (",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Signed')) {
                
                $aux = str_replace('Signed', 'sign free agent <a href="/formerplayer/' . $this->PlayerID .'">'   . $this->formerPlayer()['Name'] . "</a>", $this->Transaction);

                return explode(" by the",$aux)[0]; 

            }

            else if (str_contains($this->Transaction, 'Released')) {
                
                $aux = str_replace('Released', '<a href="/formerplayer/' . $this->PlayerID .'">'   . $this->formerPlayer()['Name'] . "</a> has been released by the " . $this->team->TeamName, $this->Transaction);

                return explode(" by the " . $this->team->TeamName . " (", $aux)[0]; 

            }
    
            //return $this->Transaction;

        }

    }
}



<?php

namespace App\Custom;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{

    function player(){
        return $this->hasMany(Player::class, 'UniqueID', 'PlayerID');
    }
    
    public function getReboundsAttribute(){
        return ($this->DRebs + $this->ORebs);
    }

    public function getFGPAttribute(){
        if($this->FGPct == "")
            return "000";
        return round($this->FGPct * 1000,  0);
    }

    public function getFTPAttribute(){
        if($this->FTPct == "")
            return "000";
        return round($this->FTPct * 1000,  0);
    }

    public function getFG3PPAttribute(){
        if($this->FG3PPct == "")
            return "000";
        return round($this->FG3PPct * 1000,  0);
    }
 
    public function getPERAttribute(){
        if($this->Minutes > 0)
         return (
            (
                $this->FGM * 85.910 +
                $this->Steals * 53.897 +
                $this->ThreePM * 51.757 +
                $this->FTM * 46.845 +
                $this->Blocks * 39.190 +
                $this->ORebs * 39.190 + 
                $this->Assists * 34.677 +
                $this->DRebs * 14.707 -
                //$this->Fouls * 17.174 -
                ($this->FTA - $this->FTM) * 20.091 -
                ($this->FGA - $this->FGM) * 39.190 -
                $this->Turnovers * 53.897
            ) *
            (1/$this->Minutes)
        ); 
        return 0;
    } 

    public function getTSAttribute(){

        $shooting = $this->FGA + $this->FTA * 0.44;

        if($shooting > 0)
            return round((
                $this->Points * 50 / 
                $shooting
            ), 1) * 10;
        return 0;
        
    }

    public function getEFFAttribute(){
        $games = $this->G;

        if($games > 0)
            return round (((
                $this->Points + 
                $this->Rebounds + 
                $this->Assists + 
                $this->Steals + 
                $this->Blocks) 
                - (
                    ($this->FGA - $this->FGM) + 
                    ($this->FTA - $this->FTM) + 
                    $this->Turnovers
            )) / $this->G, 1);
        return 0;
    }

}




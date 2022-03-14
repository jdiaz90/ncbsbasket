<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonPrev extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'SeasonPrev';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'TeamID';
    protected $connection = 'sqlite';

    
    function team(){
        return $this->hasOne(Team::class, 'TeamID', 'TeamID');
    }

    function coach(){
        return $this->hasOne(Coach::class, 'CoachID', 'CoachID');
    }

    function player1(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID1');
    }

    function player2(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID2');
    }

    function player3(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID3');
    }

    function player4(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID4');
    }

    function player5(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID5');
    }

    function player6(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID6');
    }

    function player7(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID7');
    }

    function player8(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID8');
    }

    function player9(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID9');
    }

    function player10(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID10');
    }

    function player11(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID11');
    }

    function player12(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID12');
    }

    function getConferenceLogoAttribute(){

        return "/images/logos/conf" . $this->ConfID . "logo.png";

    }

}

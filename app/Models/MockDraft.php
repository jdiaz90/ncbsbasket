<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockDraft extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'MockDraft';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'PlayerID';

    function team(){
        return $this->hasOne(Team::class, 'TeamID', 'PickTeam');
    }

    function player(){
        return $this->hasOne(Player::class, 'PlayerID');
    }

    function otherInfo(){
        return $this->hasOne(Rookie::class, 'RookieID', 'PlayerID');
    }
    
}

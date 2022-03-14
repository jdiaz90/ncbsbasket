<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayoffRound extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'PlayoffRounds';
    protected $primaryKey = "_rowid_";

    function hometeam(){
        return $this->hasOne(Team::class, 'TeamID', 'HomeID');
    }

    function awayteam(){
        return $this->hasOne(Team::class, 'TeamID', 'AwayID');
    }
}

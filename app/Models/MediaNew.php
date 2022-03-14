<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaNew extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $connection = 'sqlite';
    protected $table = 'MediaNews';  
    protected $primaryKey ="_rowid_";
    public $incrementing = true;

    function days(){
        return $this->hasOne(Day::class, "Id", "Day");
    }

    function mainTeam(){
        return $this->hasOne(Team::class, "TeamID", "MainTeam");
    }

    function player(){
        return $this->hasOne(Player::class, "PlayerID", "RefID");
    }
    
}

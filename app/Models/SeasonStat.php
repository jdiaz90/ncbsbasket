<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Custom\Stats;

class SeasonStat extends Stats
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'SeasonStats';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $connection = 'sqlite';
    protected $primaryKey = 'Key';

    function player(){
        return $this->hasOne(Player::class, 'UniqueID', 'PlayerID');
    }

    function getURLPlayerAttribute(){

        $players = Player::select("PlayerID", "UniqueID")
        ->where("UniqueID", $this->PlayerID)
        ->get();

        if($players->count() > 0)
            return "/player/" . $players[0]->PlayerID;
        return "/formerplayer/" . $this->PlayerID;

    }

}

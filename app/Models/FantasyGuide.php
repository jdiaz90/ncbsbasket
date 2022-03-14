<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FantasyGuide extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'FantasyGuide';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'PlayerID';
    public $incrementing = false;

    function player(){
        return $this->hasOne(Player::class, 'PlayerID', 'PlayerID');
    }

    function otherInfo(){
        return $this->hasOne(PlayerOtherInfo::class, 'RookieID', 'PlayerID');
    }
}

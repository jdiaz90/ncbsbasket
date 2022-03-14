<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopRookie extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TopRookies';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'PlayerID';
    protected $connection = 'sqlite';
    public $incrementing = false;

    function player(){
        return $this->hasOne(Player::class, 'PlayerID');
    }

    function otherInfo(){
        return $this->hasOne(Rookie::class, 'RookieID', 'PlayerID');
    }
}

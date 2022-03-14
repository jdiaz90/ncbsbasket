<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerOtherInfo extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'RookieID';
    protected $connection = 'sqlite';
    protected $table = "Players";
    public $incrementing = false;

    function player(){
        return $this->hasOne(Player::class, 'PlayerID', 'RookieID');
    }

}

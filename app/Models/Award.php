<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
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
        return $this->hasOne(Team::class, 'TeamID', 'TeamID');
    }

    function player(){
        return $this->hasOne(Player::class, 'PlayerID', 'UniqueID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Draft';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $connection = 'sqlite';

    function team(){
        return $this->hasOne(Team::class, 'TeamID', 'TeamID');
    }

    function player(){
        return $this->hasOne(Player::class, 'PlayerID', 'UniqueID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastStanding extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'PastStandings';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Key';
    protected $connexion = 'sqlite';

    function team(){
        return $this->hasOne(Team::class, "TeamID", "TeamID");
    }

}

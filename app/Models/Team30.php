<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team30 extends Model
{
    use HasFactory;
    protected $primaryKey = "TeamID";
    protected $table = "Teams30";
    protected $connection = "sqlite4";

    public $incrementing = false;

    function otherInfo(){
        return $this->hasOne(Team::class, "TeamID", "TeamID");
    }

}

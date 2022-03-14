<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachHistory extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'CoachHistory';
    protected $connection = 'sqlite';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Key';

    function team(){
        return $this->hasOne(Team::class, "TeamID", "TeamID")
        ->orderBy('Season', 'desc');
    }
}

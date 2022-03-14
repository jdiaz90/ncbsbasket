<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $connection = 'sqlite5';
    protected $primaryKey = 'ID';

    function getAwardWinnersDayAttribute(){

        $day = $this->Id - 1;
        $day = (string)$day;

        return Day::select("DayNumber")
        ->where("Id", $day)
        ->get()[0]['DayNumber'];
        
    }
}

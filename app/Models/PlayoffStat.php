<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Custom\Stats;

class PlayOffStat extends Stats
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'PlayOffStats';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $connection = 'sqlite';
    protected $primaryKey = 'Key';

}

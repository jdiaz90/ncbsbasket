<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    use HasFactory;
    protected $primaryKey = "_rowid_";
    protected $connection = "sqlite";

    public $incrementing = false;

}

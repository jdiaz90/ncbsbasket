<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryCap extends Model
{
    use HasFactory;

    protected $connection = 'sqlite5';
    protected $table = 'SalaryCap';
    protected $primaryKey = '_rowid_';
}

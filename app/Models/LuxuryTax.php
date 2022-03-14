<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuxuryTax extends Model
{
    use HasFactory;

    protected $connection = 'sqlite5';
    protected $table = 'LuxuryTax';
    protected $primaryKey = '_rowid_';
}

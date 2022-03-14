<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetiredCoach extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'RetiredCoaches';
    protected $primaryKey = "_rowid_";
    protected $connexion = "sqlite";
    public $incrementing = false;
}

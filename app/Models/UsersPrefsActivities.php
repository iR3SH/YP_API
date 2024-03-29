<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPrefsActivities extends Model
{
    use HasFactory;
    protected $fillable = [
        "idUserPref",
        "idActivity"
    ];
}

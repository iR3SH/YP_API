<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPreferences extends Model
{
    use HasFactory;

    protected $fillable = [
        "activities",
        "musicsStyles",
        "redFlages",
        "languages",
        "moviePref",
        "genderPref",
        "idUser",
    ];
}

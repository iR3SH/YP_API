<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        "timestamp",
        "reason",
        "isLifeTime",
        "idUser",
        "idAdmin",
    ];
}

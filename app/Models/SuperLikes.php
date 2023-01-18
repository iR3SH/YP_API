<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperLikes extends Model
{
    use HasFactory;

    protected $fillable = [
        "idUserWhoLiked",
        "idUserWhoBeLiked",
        "haveSee",
    ];
}

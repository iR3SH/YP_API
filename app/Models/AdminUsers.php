<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        "idUser",
        "grantedBy",
    ];
}

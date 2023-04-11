<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consoles extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];
}

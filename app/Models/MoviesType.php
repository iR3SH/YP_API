<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoviesType extends Model
{
    use HasFactory;
    protected $table = 'movies_type';
    protected $fillable = [
        "name",
    ];
}

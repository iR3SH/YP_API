<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avantages extends Model
{
    use HasFactory;

    protected $fillable = [
        "canUseExtraFilter",
        "canSeeWhoLiked",
        "canReceiveDailyExtraLike",
        "canGoBack",
        "isPremiumProfil",
        "price",
    ];
}

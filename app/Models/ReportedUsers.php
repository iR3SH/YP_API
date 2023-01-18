<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        "reason",
        "content",
        "reportedUser",
        "userWhoReported",
        "closedBy",
        "isClosed",
    ];
}

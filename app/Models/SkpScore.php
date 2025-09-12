<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkpScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'user_id',
        'month_1_score',
        'month_2_score',
        'month_3_score',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplineScore extends Model
{
    use HasFactory;
    protected $fillable = [
        'period_id',
        'user_id',
        'discipline_criterion_id',
        'score',
    ];
}

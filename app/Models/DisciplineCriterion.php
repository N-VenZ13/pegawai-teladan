<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Testing\Fluent\Concerns\Has;

class DisciplineCriterion extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_active'];
}

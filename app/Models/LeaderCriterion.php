<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderCriterion extends Model
{
    protected $fillable = ['name', 'description', 'target_type', 'is_active'];
}

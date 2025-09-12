<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['period_id', 'voter_id', 'target_id', 'status'];

    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }
}

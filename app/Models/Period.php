<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'sk_pegawai_path',
        'sertifikat_pegawai_path',
        'sk_ketua_tim_path',
        'sertifikat_ketua_tim_path', // <-- TAMBAHKAN INI
        'month_1_name',
        'month_2_name',
        'month_3_name'
    ];

    // app/Models/Period.php
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // app/Models/Period.php
    public function leaderAnswers()
    {
        return $this->hasMany(LeaderAnswer::class);
    }

    public function skpScores()
    {
        return $this->hasMany(SkpScore::class);
    }
}

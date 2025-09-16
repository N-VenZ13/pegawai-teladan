<?php

namespace App\Exports;

use App\Models\Assignment;
use App\Models\Period;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TeamLeaderPeerExport implements FromCollection, WithHeadings, WithTitle
{
    protected $period;

    public function __construct(Period $period)
    {
        $this->period = $period;
    }

    public function collection()
    {
        return $this->period->assignments()
            ->join('answers', 'assignments.id', '=', 'answers.assignment_id')
            ->join('users as voter', 'assignments.voter_id', '=', 'voter.id')
            ->join('users as target', 'assignments.target_id', '=', 'target.id')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->where('questions.type', 'ketua_tim') // <-- SATU-SATUNYA PERBEDAAN ADA DI SINI
            ->select('voter.name as voter_name', 'target.name as target_name', 'questions.text as question_text', 'answers.score')
            ->get();
    }

    public function headings(): array
    {
        return ['Nama Penilai', 'Nama Ketua Tim', 'Pertanyaan', 'Skor'];
    }

    public function title(): string
    {
        return 'Detail Penilaian Ketua Tim';
    }
}

<?php

namespace App\Exports;

use App\Models\Assignment;
use App\Models\Period;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PeerToPeerExport implements FromCollection, WithHeadings, WithTitle
{
    protected $period;

    public function __construct(Period $period)
    {
        $this->period = $period;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua jawaban peer-to-peer untuk periode ini
        return $this->period->assignments()
            ->join('answers', 'assignments.id', '=', 'answers.assignment_id')
            ->join('users as voter', 'assignments.voter_id', '=', 'voter.id')
            ->join('users as target', 'assignments.target_id', '=', 'target.id')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->where('questions.type', 'pegawai') // Hanya ambil penilaian antar pegawai
            ->select('voter.name as voter_name', 'target.name as target_name', 'questions.text as question_text', 'answers.score')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Definisikan header kolom untuk file Excel
        return [
            'Nama Penilai',
            'Nama Target',
            'Pertanyaan',
            'Skor',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        // Beri nama pada sheet Excel
        return 'Detail Penilaian Peer-to-Peer';
    }
}

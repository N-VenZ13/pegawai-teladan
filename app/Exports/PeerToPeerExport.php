<?php

namespace App\Exports;

use App\Models\Period;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray; // Ganti FromCollection
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PeerToPeerExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $period;
    protected $questions;

    public function __construct(Period $period)
    {
        $this->period = $period;
        // Ambil semua pertanyaan yang relevan untuk header
        $this->questions = Question::where('type', 'pegawai')->where('is_active', true)->get();
    }

    public function array(): array
    {
        // 1. Ambil semua pegawai yang dinilai (target)
        $targets = User::role('Pegawai')->where('is_ketua_tim', false)->orderBy('name')->get();

        // 2. Ambil semua skor rata-rata dalam satu query besar
        $averageScores = DB::table('assignments')
            ->join('answers', 'assignments.id', '=', 'answers.assignment_id')
            ->where('assignments.period_id', $this->period->id)
            ->groupBy('assignments.target_id', 'answers.question_id')
            ->select(
                'assignments.target_id',
                'answers.question_id',
                DB::raw('AVG(answers.score) as avg_score')
            )
            ->get()
            // Ubah menjadi format yang mudah diakses: ['targetId-questionId' => avg_score]
            ->keyBy(fn ($item) => $item->target_id . '-' . $item->question_id)
            ->map(fn ($item) => round($item->avg_score, 2));

        // 3. Bangun array data untuk Excel
        $data = [];
        foreach ($targets as $target) {
            $row = [];
            $row['name'] = $target->name; // Kolom pertama adalah nama
            
            $totalScore = 0;

            // Loop melalui setiap pertanyaan untuk membuat kolom
            foreach ($this->questions as $question) {
                $score = $averageScores->get($target->id . '-' . $question->id, 0);
                $row['question_' . $question->id] = $score;
                $totalScore += $score;
            }

            $row['total'] = round($totalScore, 2); // Kolom terakhir adalah total
            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        // Buat header dinamis
        $headings = ['Nama Pegawai'];

        foreach ($this->questions as $question) {
            $headings[] = $question->text; // Setiap teks pertanyaan menjadi header kolom
        }

        $headings[] = 'Total'; // Kolom header terakhir
        
        return $headings;
    }

    public function title(): string
    {
        return 'Rekap Peer-to-Peer Pegawai';
    }
}
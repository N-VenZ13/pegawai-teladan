<?php

namespace App\Exports;

use App\Models\DisciplineCriterion;
use App\Models\DisciplineScore;
use App\Models\LeaderAnswer;
use App\Models\LeaderCriterion;
use App\Models\Period;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class KetuaTimTeladanExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithMapping
{
    protected $period;
    protected $peerQuestions, $disciplineCriteria, $leaderCriteria;

    public function __construct(Period $period)
    {
        $this->period = $period;
        $this->peerQuestions = Question::where('type', 'ketua_tim')->where('is_active', true)->orderBy('id')->get();
        $this->disciplineCriteria = DisciplineCriterion::where('is_active', true)->orderBy('id')->get();
        $this->leaderCriteria = LeaderCriterion::whereIn('target_type', ['ketua_tim', 'semua'])->where('is_active', true)->orderBy('id')->get();
    }

    public function array(): array
    {
        $targets = User::role(['Pegawai', 'Kepala BPS'])->where('is_ketua_tim', true)->orderBy('name')->get();
        $peerScores = DB::table('assignments')->join('answers', 'assignments.id', '=', 'answers.assignment_id')
            ->where('assignments.period_id', $this->period->id)
            ->groupBy('assignments.target_id', 'answers.question_id')
            ->select('assignments.target_id', 'answers.question_id', DB::raw('SUM(answers.score) as total_score'))
            ->get()->groupBy('target_id');
        $disciplineScores = DisciplineScore::where('period_id', $this->period->id)->get()->groupBy('user_id');
        $leaderScores = LeaderAnswer::where('period_id', $this->period->id)->get()->groupBy('target_id');
        $skpScores = $this->period->skpScores()->get()->keyBy('user_id');
        $data = [];
        foreach ($targets as $target) {
            $rowData = ['user' => $target];
            $rowData['peer_scores'] = $peerScores->get($target->id, collect())->keyBy('question_id');
            $rowData['discipline_scores'] = $disciplineScores->get($target->id, collect())->keyBy('discipline_criterion_id');
            $rowData['leader_scores'] = $leaderScores->get($target->id, collect())->keyBy('leader_criterion_id');
            $rowData['skp_scores'] = $skpScores->get($target->id);
            $totalPeer = $rowData['peer_scores']->sum('total_score');
            $totalLeader = $rowData['leader_scores']->sum('score');
            $totalDiscipline = $rowData['discipline_scores']->sum('score');
            $totalSkp = ($rowData['skp_scores']->month_1_score ?? 0) + ($rowData['skp_scores']->month_2_score ?? 0) + ($rowData['skp_scores']->month_3_score ?? 0);
            $bobot_peer = 0.30; $bobot_leader = 0.30; $bobot_skp = 0.10; $bobot_discipline = 0.30;
            $finalScore = 
                ($totalPeer * $bobot_peer) +
                ($totalLeader * $bobot_leader) +
                ($totalSkp * $bobot_skp) +
                ($totalDiscipline * $bobot_discipline);
            $rowData['final_score'] = round($finalScore, 2);
            $data[] = $rowData;
        }
        usort($data, fn($a, $b) => $b['final_score'] <=> $a['final_score']);
        return $data;
    }

    public function headings(): array
    {
        $headings = ['Peringkat', 'Nama Ketua Tim'];
        foreach ($this->peerQuestions as $q) { $headings[] = $q->text; }
        $headings[] = 'Total Rekan';
        foreach ($this->disciplineCriteria as $c) { $headings[] = $c->name; }
        $headings[] = 'Total Disiplin';
        foreach ($this->leaderCriteria as $c) { $headings[] = $c->name; }
        $headings[] = 'Total Kepala BPS';
        $headings[] = 'SKP Bulan 1'; $headings[] = 'SKP Bulan 2'; $headings[] = 'SKP Bulan 3';
        $headings[] = 'Total SKP';
        $headings[] = 'NILAI AKHIR';
        return $headings;
    }
    
    public function map($row): array
    {
        static $rank = 0;
        $rank++;
        $mappedRow = [$rank, $row['user']->name];
        $totalPeer = 0;
        foreach ($this->peerQuestions as $q) {
            $score = $row['peer_scores']->get($q->id)->total_score ?? 0;
            $mappedRow[] = $score;
            $totalPeer += $score;
        }
        $mappedRow[] = $totalPeer;
        $totalDiscipline = 0;
        foreach ($this->disciplineCriteria as $c) {
            $score = $row['discipline_scores']->get($c->id)->score ?? 0;
            $mappedRow[] = $score;
            $totalDiscipline += $score;
        }
        $mappedRow[] = $totalDiscipline;
        $totalLeader = 0;
        foreach ($this->leaderCriteria as $c) {
            $score = $row['leader_scores']->get($c->id)->score ?? 0;
            $mappedRow[] = $score;
            $totalLeader += $score;
        }
        $mappedRow[] = $totalLeader;
        $totalSkp = ($row['skp_scores']->month_1_score ?? 0) + ($row['skp_scores']->month_2_score ?? 0) + ($row['skp_scores']->month_3_score ?? 0);
        $mappedRow[] = $row['skp_scores']->month_1_score ?? 0;
        $mappedRow[] = $row['skp_scores']->month_2_score ?? 0;
        $mappedRow[] = $row['skp_scores']->month_3_score ?? 0;
        $mappedRow[] = $totalSkp;
        $mappedRow[] = $row['final_score'];
        return $mappedRow;
    }

    public function title(): string
    {
        return 'Laporan Master Ketua Tim Teladan';
    }
}
<?php

namespace App\Exports;

use App\Http\Controllers\Admin\RecapController;
use App\Models\Period;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use \Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PegawaiTeladanExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
     

    protected $period;
    protected $recapData;

    public function __construct(Period $period)
    {
        $this->period = $period;
        // Panggil logika kalkulasi DENGAN PARAMETER 'pegawai'
        $recapController = new RecapController();
        $this->recapData = $recapController->calculateRecap($period, 'pegawai');
    }

    public function collection()
    {
        return $this->recapData;
    }

    public function headings(): array
    {
        return ['Peringkat', 'Nama', 'Jabatan', 'Nilai Rekan', 'Nilai Pimpinan', 'Nilai SKP', 'Nilai Disiplin', 'NILAI AKHIR'];
    }

    // Method `map` untuk mengubah format setiap baris
    public function map($row): array
    {
        // Peringkat akan kita tambahkan secara manual karena collection sudah diurutkan
        static $rank = 0;
        $rank++;

        return [
            $rank,
            $row['user']->name,
            $row['user']->jabatan,
            $row['peer_score'],
            $row['leader_score'],
            $row['skp_score'],
            $row['discipline_score'],
            $row['final_score'],
        ];
    }

    public function title(): string
    {
        return 'Rekapitulasi Pegawai Teladan';
    }
}

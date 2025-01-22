<?php

namespace App\Livewire;

use App\Models\InputSertif as ModelsRealisasi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Realisasi extends Component
{
    public function render()
    {
        $currentYear = date('Y');
        $currentMonth = sprintf("%02d", date('m')); // Menambahkan nol di depan jika diperlukan

        $data = ModelsRealisasi::select('kdcab', DB::raw('SUM(sertiftrn) AS total_sertiftrn'))
            ->whereIn('kdcab', ['01', '02', '03'])
            ->whereRaw('SUBSTR(tgl, 1, 4) = ?', [$currentYear])
            ->whereRaw('SUBSTR(tgl, 5, 2) = ?', [$currentMonth])
            ->groupBy('kdcab')
            ->get();

        return view('livewire.realisasi', ['realisasi' => $data]);
    }

    public function formatRupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

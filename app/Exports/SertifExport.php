<?php

namespace App\Exports;

use App\Models\InputSertif;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SertifExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return InputSertif::query();
    }

    public function headings(): array
    {
        return [
            'No Kontrak',
            'Nama',
            'No Tab',
            'Saldo Tab',
            'Saldo Blokir',
            'TF HIK',
            'TF Nasabah',
            'Sisa Saldo ATM',
            'Rek Pendamping',
            'Bank',
            'Kode AO',
            'User Input',
            'User Update',
            'Tanggal'
        ];
    }

    public function map($sertif): array
    {
        return [
            $sertif->nokontrak,
            $sertif->nama,
            $sertif->acdrop,
            $sertif->sahirrp,
            $sertif->saldoblok,
            $sertif->tfangs,
            $sertif->tfnsbh,
            $sertif->sahiratm,
            $sertif->rekpend,
            $sertif->bank,
            $sertif->kdaoh,
            $sertif->userinput,
            $sertif->userupdate,
            $sertif->created_at
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\InputSertif;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SertifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InputSertif::insert(
            [
                [
                    'nokontrak' => '42701222077',
                    'nama' => 'NINA',
                    'acdrop' => '1240100241',
                    'sahir' => '50000',
                    'saldoblok' => '50000',
                    'angsmdl' => '50000',
                    'angsmgn' => '50000',
                    'tgleff' => '24122024',
                    'tfangs' => '50000',
                    'tfnsbh' => '50000',
                    'sahiratm' => '50000',
                    'rekpend' => '607101020800530',
                    'bank' => 'BRI',
                    'kdaoh' => 'HNDR',
                    'userinput' => 'FREDI',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'nokontrak' => '42701222088',
                    'nama' => 'SINTA',
                    'acdrop' => '1240100241',
                    'sahir' => '50000',
                    'saldoblok' => '50000',
                    'angsmdl' => '50000',
                    'angsmgn' => '50000',
                    'tgleff' => '24122024',
                    'tfangs' => '50000',
                    'tfnsbh' => '50000',
                    'sahiratm' => '50000',
                    'rekpend' => '607101020800530',
                    'bank' => 'BRI',
                    'kdaoh' => 'HNDR',
                    'userinput' => 'FREDI',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'nokontrak' => '42701222088',
                    'nama' => 'BUDI',
                    'acdrop' => '1240100241',
                    'sahir' => '50000',
                    'saldoblok' => '50000',
                    'angsmdl' => '50000',
                    'angsmgn' => '50000',
                    'tgleff' => '24122024',
                    'tfangs' => '50000',
                    'tfnsbh' => '50000',
                    'sahiratm' => '50000',
                    'rekpend' => '607101020800530',
                    'bank' => 'BRI',
                    'kdaoh' => 'HNDR',
                    'userinput' => 'FREDI',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ]
        );
    }
}

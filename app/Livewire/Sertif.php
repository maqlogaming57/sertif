<?php

namespace App\Livewire;

use App\Models\InputSertif as ModelsSertif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Sertif extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nokontrak, $nama, $acdrop, $katakunci, $sertifId, $user;
    public $tfangs, $sertiftrn, $tfnsbh, $sahiratm, $rekpend, $bank, $termin;
    protected $listeners = ['dataStored' => 'refreshData'];
    public $start_date;
    public $end_date;


    public function refreshData()
    {
        $this->resetPage();
    }

    public function updatedTfangs($value)
    {
        $this->tfangs = str_replace('.', '', $value);
    }

    public function edit($id)
    {
        $sertif = ModelsSertif::findOrfail($id);

        $this->tfangs = $sertif->tfangs;
        $this->sertiftrn = $sertif->sertiftrn;
        $this->tfnsbh = $sertif->tfnsbh;
        $this->sahiratm = $sertif->sahiratm;
        $this->rekpend = $sertif->rekpend;
        $this->bank = $sertif->bank;
        $this->sertifId = $sertif->id;
    }

    public function export()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d', $this->start_date)->format('Ymd');
        $endDate = Carbon::createFromFormat('Y-m-d', $this->end_date)->format('Ymd');
        $data = ModelsSertif::where('sts', 'A')
            ->whereBetween('tgl', [$startDate, $endDate])->get();

        if ($data->isEmpty()) {
            session()->flash('message', 'Tidak ada data untuk diexport');
            return;
        }

        return new StreamedResponse(
            function () use ($data) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // Set header kolom
                $headers = [
                    'A1' => 'No Kontrak',
                    'B1' => 'Nama',
                    'C1' => 'No Tab',
                    'D1' => 'Saldo Tabungan',
                    'E1' => 'Saldo Blokir',
                    'F1' => 'Sertif Turun',
                    'G1' => 'Tf Ke Hikmah',
                    'H1' => 'Tf Ke Nasaba',
                    'I1' => 'Sisa Saldo ATM',
                    'J1' => 'Rekening Pendamping',
                    'K1' => 'Bank',
                    'L1' => 'Kode AO',
                    'M1' => 'Kode Cab',
                    'N1' => 'Termin',
                    'O1' => 'colbaru',
                    'P1' => 'Input User',
                    'Q1' => 'Update User',
                    'R1' => 'Tanggal',
                ];

                foreach ($headers as $cell => $value) {
                    $sheet->setCellValue($cell, $value);
                }

                // Isi data
                $rowNumber = 2;
                foreach ($data as $row) {
                    $sheet->setCellValue('A' . $rowNumber, $row->nokontrak);
                    $sheet->setCellValue('B' . $rowNumber, $row->nama);
                    $sheet->setCellValue('C' . $rowNumber, $row->acdrop);
                    $sheet->setCellValue('D' . $rowNumber, $row->sahirrp);
                    $sheet->setCellValue('E' . $rowNumber, $row->saldoblok);
                    $sheet->setCellValue('F' . $rowNumber, $row->sertiftrn);
                    $sheet->setCellValue('G' . $rowNumber, $row->tfangs);
                    $sheet->setCellValue('H' . $rowNumber, $row->tfnsbh);
                    $sheet->setCellValue('I' . $rowNumber, $row->sahiratm);
                    $sheet->setCellValue('J' . $rowNumber, $row->rekpend);
                    $sheet->setCellValue('K' . $rowNumber, $row->bank);
                    $sheet->setCellValue('L' . $rowNumber, $row->kdaoh);
                    $sheet->setCellValue('M' . $rowNumber, $row->kdcab);
                    $sheet->setCellValue('N' . $rowNumber, $row->termin);
                    $sheet->setCellValue('O' . $rowNumber, $row->colbaru);
                    $sheet->setCellValue('P' . $rowNumber, $row->userinput);
                    $sheet->setCellValue('Q' . $rowNumber, $row->userupdate);
                    $sheet->setCellValue('R' . $rowNumber, $row->tgl);
                    $rowNumber++;
                }

                $writer = new Xlsx($spreadsheet);

                // Set header untuk download
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="sertif-export-' . date('Y-m-d') . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="sertif-export-' . date('Y-m-d') . '.xlsx"',
            ]
        );
    }


    public function update()
    {
        $this->validate([
            'tfangs' => 'required|numeric',
            'sertiftrn' => 'required|numeric',
            'tfnsbh' => 'required|numeric',
            'sahiratm' => 'required|numeric',
            'rekpend' => 'required|numeric',
            'bank' => 'required|string',
        ]);

        $tfangs = (float)str_replace('.', '', $this->tfangs);
        $sertiftrn = (float)str_replace('.', '', $this->sertiftrn);
        $tfnsbh = (float)str_replace('.', '', $this->tfnsbh);
        $sahiratm = (float)str_replace('.', '', $this->sahiratm);
        $sertif = ModelsSertif::findOrFail($this->sertifId);

        $sertif->update([
            'tfangs' => $tfangs,
            'sertiftrn' => $sertiftrn,
            'termin' => $this->termin,
            'tfnsbh' => $tfnsbh,
            'sahiratm' => $sahiratm,
            'rekpend' => $this->rekpend,
            'bank' => $this->bank,
            'userupdate' => Auth::user()->name,
        ]);

        session()->flash('message', 'Data berhasil diperbarui.');
    }

    public function delete_confirmation($id)
    {
        $this->sertifId = $id;
    }

    public function delete()
    {
        $sertif = ModelsSertif::findOrfail($this->sertifId);
        $sertif->update([
            'sts' => 'N',
        ]);

        session()->flash('message', 'Data berhasil dihapus.');
    }

    public function clear()
    {
        $this->sertifId = null;
        $this->sertiftrn = '';
        $this->tfangs = '';
        $this->tfnsbh = '';
        $this->bank = '';
        $this->rekpend = '';
        $this->sahiratm = '';
    }

    public function render()
    {
        if ($this->katakunci != null) {
            $data = ModelsSertif::where('nokontrak', 'like', '%' . $this->katakunci . '%')
                ->orwhere('nama', 'like', '%' . $this->katakunci . '%')
                ->orderBy('nama', 'asc')->paginate(10);
        } else {
            $data = ModelsSertif::where('sts', 'A')
                ->orderby('updated_at', 'desc')->paginate(10);
        }
        return view('livewire.sertif', ['sertifs' => $data]);
    }
}

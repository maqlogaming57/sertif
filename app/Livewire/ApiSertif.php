<?php

namespace App\Livewire;

use App\Models\InputSertif as ModelInput;
use Livewire\Component;
use App\Services\SertifApiService;
use Illuminate\Support\Facades\Auth;

class ApiSertif extends Component
{
    public $katakunci = '';
    public $employee_selected_id = [];
    public $loading = false;
    public $error = null;
    public $selectAll = false;
    public $selectedData = null;
    public $dataSertifs = [];
    public $tfangs, $tfnsbh, $sertiftrn, $sahiratm, $rekpend, $bank, $tfangsrp, $tanggalInput;

    protected $sertifService;

    public function boot()
    {
        try {
            $this->sertifService = new SertifApiService();
        } catch (\Exception $e) {
            $this->error = "Konfigurasi API tidak ditemukan. Silakan hubungi administrator.";
        }
    }

    public function calculatePayment($months)
    {
        if (!$this->selectedData || !isset($this->selectedData['angsttl']) || !is_numeric($months)) {
            return;
        }

        $angsttl = (int)$this->selectedData['angsttl'];
        $extra = $months * 5000;
        $this->tfangs = ($angsttl * $months) + $extra;

        // Simpan nilai tfangs yang masih berupa angka untuk perhitungan selanjutnya
        $this->tfangsrp = number_format($this->tfangs, 0, ',', '.');  // Format ke dalam bentuk rupiah
    }

    public function store()
    {
        if (!$this->selectedData) {
            session()->flash('error', 'Tidak ada data pilih.');
            return;
        }

        $rules = [
            'tfangs' => 'required',
            'tfnsbh' => 'required',
            'rekpend' => 'required',
            'sahiratm' => 'required',
            'sertiftrn' => 'required',
        ];

        $messages = [
            'tfangs' => 'Angsuran Ke BPRS Hikmah Bahari tidak boleh kosong',
            'tfnsbh' => 'Transfer Ke Nasabah tidak boleh kosong',
            'rekpend' => 'Rekening Pendamping tidak boleh kosong',
            'sahiratm' => 'Sisa Saldo ATM tidak boleh kosong',
            'sertiftrn' => 'Sertif Turun tidak boleh kosong',
        ];

        $validateData = $this->validate($rules, $messages);

        $tfangs = (float)str_replace('.', '', $this->tfangsrp);
        $sertiftrn = (float)str_replace('.', '', $this->sertiftrn);
        $tfnsbh = (float)str_replace('.', '', $this->tfnsbh);
        $sahiratm = (float)str_replace('.', '', $this->sahiratm);
        $tanggalInput = now()->format('Ymd');

        ModelInput::create([
            'nokontrak' => $this->selectedData['nokontrak'] ?? null,
            'nama' => $this->selectedData['nama'] ?? null,
            'acdrop' => $this->selectedData['acdrop'] ?? null,
            'sahirrp' => $this->selectedData['sahirrp'] ?? null,
            'saldoblok' => $this->selectedData['saldoblok'] ?? null,
            'angsmgn' => $this->selectedData['tagmgn'] ?? null,
            'angsmdl' => $this->selectedData['tagmdl'] ?? null,
            'angsttl' => $this->selectedData['angsttl'] ?? null,
            'kdaoh' => $this->selectedData['kdaoh'] ?? null,
            'colbaru' => $this->selectedData['colbaru'],
            'kdcab' => $this->selectedData['kdcab'] ?? null,
            'tgleff' => $this->selectedData['tgleff'],
            'sertiftrn' => $sertiftrn,
            'tfangs' => $tfangs,
            'tfnsbh' => $tfnsbh,
            'rekpend' => $this->rekpend,
            'bank' => $this->bank,
            'sahiratm' => $sahiratm,
            'tgl' => $tanggalInput,
            'userinput' => Auth::user()->name,
        ]);

        session()->flash('message', 'Data berhasil disimpan.');
        $this->dispatch('dataStored');
        $this->clear();
    }

    public function clear()
    {
        $this->sertiftrn = '';
        $this->tfangsrp = '';
        $this->tfnsbh = '';
        $this->bank = '';
        $this->rekpend = '';
        $this->sahiratm = '';
    }
    public function render()
    {
        if ($this->error) {
            return view('livewire.api-sertif', [
                'dataSertifs' => []
            ]);
        }

        try {
            $this->loading = true;
            $data = $this->sertifService->getCustomers($this->katakunci);
            $this->dataSertifs = $data['data'] ?? [];
            return view('livewire.api-sertif', [
                'dataSertifs' => $this->dataSertifs,
            ]);
        } catch (\Exception $e) {
            $this->error = "Terjadi kesalahan saat mengambil data. Silakan coba lagi.";
            return view('livewire.api-sertif', [
                'dataSertifs' => []
            ]);
        } finally {
            $this->loading = false;
        }
    }

    public function updatedKatakunci()
    {
        $this->render();
    }

    public function selected($nokontrak)
    {
        $data = collect($this->dataSertifs)->firstWhere('nokontrak', $nokontrak);

        if ($data) {
            $this->selectedData = $data;
            $this->dispatch('showModal');
        } else {
            $this->selectedData = null;
        }
    }
}

<?php

namespace App\Livewire;

use App\Models\InputSertif as ModelInput;
use Livewire\Component;
use App\Services\SertifApiService;

class ApiSertif extends Component
{
    public $katakunci = '';
    public $employee_selected_id = [];
    public $loading = false;
    public $error = null;
    public $selectAll = false;
    public $selectedData = null;
    public $dataSertifs = [];
    public $tfangs, $tfnsbh, $sertiftrn, $sahiratm, $rekpend, $bank, $tfangsrp;

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

        // Bersihkan format angka dari pemisah ribuan
        $tfangs = (float)str_replace('.', '', $this->tfangsrp);
        $sertiftrn = (float)str_replace('.', '', $this->sertiftrn);
        $tfnsbh = (float)str_replace('.', '', $this->tfnsbh);
        $sahiratm = (float)str_replace('.', '', $this->sahiratm);

        ModelInput::create([
            'nokontrak' => $this->selectedData['nokontrak'] ?? null,
            'nama' => $this->selectedData['nama'] ?? null,
            'acdrop' => $this->selectedData['acdrop'] ?? null,
            'sahirrp' => $this->selectedData['sahirrp'] ?? null,
            'saldoblok' => $this->selectedData['saldoblok'] ?? null,
            'angsmgn' => $this->selectedData['angsmgn'] ?? null,
            'angsmdl' => $this->selectedData['angsmdl'] ?? null,
            'angsttl' => $this->selectedData['angsttl'] ?? null,
            'tgleff' => $this->selectedData['tgleff'] ?? now()->toDateString(), // Default ke tanggal sekarang
            'sertiftrn' => $sertiftrn, // Nilai bersih tanpa format
            'tfangs' => $tfangs,       // Nilai bersih tanpa format
            'tfnsbh' => $tfnsbh,       // Nilai bersih tanpa format
            'rekpend' => $this->rekpend,
            'bank' => $this->bank,
            'sahiratm' => $sahiratm,   // Nilai bersih tanpa format
        ]);

        session()->flash('success', 'Data berhasil disimpan.');
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

    // Di dalam komponen Livewire
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

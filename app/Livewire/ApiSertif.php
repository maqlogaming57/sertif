<?php

namespace App\Livewire;

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

    protected $sertifService;

    public function boot()
    {
        try {
            $this->sertifService = new SertifApiService();
        } catch (\Exception $e) {
            $this->error = "Konfigurasi API tidak ditemukan. Silakan hubungi administrator.";
        }
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

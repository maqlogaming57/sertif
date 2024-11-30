<?php

namespace App\Livewire;

use App\Models\InputSertif as ModelsSertif;
use Livewire\Component;
use Livewire\WithPagination;

class Sertif extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nokontrak, $nama, $acdrop, $katakunci;
    protected $listeners = ['dataStored' => 'refreshData'];

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->katakunci != null) {
            $data = ModelsSertif::where('nokontrak', 'like', '%' . $this->katakunci . '%')
                ->orwhere('nama', 'like', '%' . $this->katakunci . '%')
                ->orderBy('nama', 'asc')->paginate(10);
        } else {
            $data = ModelsSertif::orderby('updated_at', 'desc')->paginate(10);
        }
        return view('livewire.sertif', ['sertifs' => $data]);
    }
}

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
    public function render()
    {
        if ($this->katakunci != null) {
            $data = ModelsSertif::where('nokontrak', 'like', '%' . $this->katakunci . '%')
                ->orwhere('nama', 'like', '%' . $this->katakunci . '%')
                ->orderBy('nama', 'asc')->paginate(3);
        } else {
            $data = ModelsSertif::orderby('nama', 'asc')->paginate(3);
        }
        return view('livewire.sertif', ['dataSertifs' => $data]);
    }
}

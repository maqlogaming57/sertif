<?php

namespace App\Livewire;

use App\Models\InputSertif as ModelsSertif;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Sertif extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nokontrak, $nama, $acdrop, $katakunci, $sertifId, $user;
    public $tfangs, $sertiftrn, $tfnsbh, $sahiratm, $rekpend, $bank;
    protected $listeners = ['dataStored' => 'refreshData'];

    public function refreshData()
    {
        $this->resetPage();
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

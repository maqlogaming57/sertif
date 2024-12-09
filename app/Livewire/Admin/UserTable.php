<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTable extends Component
{
    use WithPagination; // Gunakan fitur paginasi Livewire

    public $search = '';
    public $name, $email, $password, $role;
    public $showModal = false; // Untuk mengatur modal visibility

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:1,2',
        ]);

        // Simpan data pengguna baru
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->closeModal();
        session()->flash('message', 'User berhasil ditambahkan');
    }

    public function render()
    {
        // Gunakan fitur pencarian dengan paginasi
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(5);

        return view('livewire.admin.user-table', [
            'users' => $users,
        ]);
    }
}

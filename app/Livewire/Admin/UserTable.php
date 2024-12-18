<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $email, $password, $role;
    public $showModal = false;
    public $showDeleteModal = false;
    public $isEdit = false;
    public $userId;
    public $userToDelete; // Menyimpan user yang akan dihapus

    public function openModal($isEdit = false, $id = null)
    {
        $this->isEdit = $isEdit;

        if ($isEdit && $id) {
            $user = User::find($id);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->password = ''; // Kosongkan password
        } else {
            $this->resetInputFields();
        }

        $this->showModal = true;
    }

    public function openDeleteModal($id)
    {
        $this->userToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->userId = null;
        $this->isEdit = false;
    }

    public function saveUser()
    {
        // dd($this->role);
        if ($this->isEdit) {
            $this->updateUser();
        } else {
            $this->createUser();
        }
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:1,2',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->closeModal();
        session()->flash('message', 'User berhasil ditambahkan');
    }

    public function updateUser()
    {
        // dd($this->role);
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required|',
        ]);

        $user = User::find($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        if ($this->password) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        $this->closeModal();
        session()->flash('message', 'User berhasil diperbarui');
    }

    public function deleteUser()
    {
        User::find($this->userToDelete)->delete();
        $this->closeDeleteModal();
        session()->flash('message', 'User berhasil dihapus');
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(25);

        return view('livewire.admin.user-table', [
            'users' => $users,
        ]);
    }
}

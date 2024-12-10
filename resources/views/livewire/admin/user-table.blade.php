<div>
    <!-- Modal Tambah/Edit -->
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEdit ? 'Edit User' : 'Tambah User' }}</h5>
                        <button type="button" class="close" wire:click="closeModal">×</button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveUser">
                            <div class="form-group">
                                <label>Nama</label>
                                <input wire:model="name" type="text" class="form-control">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input wire:model="email" type="email" class="form-control">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input wire:model="password" type="password" class="form-control"
                                    placeholder="{{ $isEdit ? 'Kosongkan jika tidak ingin mengubah' : '' }}">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select wire:model="role" class="form-control">
                                    <option value="">Pilih Role</option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEdit ? 'Update' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Hapus -->
    @if ($showDeleteModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="close" wire:click="closeDeleteModal">×</button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus user ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">Batal</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteUser">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
     @if (session()->has('message'))
            <div class="pt-3">
                <div x-data="{ visible: true }" x-init="setTimeout(() => visible = false, 5000)" x-show="visible" x-transition
                    class="alert alert-success">
                    {{ session('message') }}
                </div>
            </div>
        @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar User</h3>
            <div class="card-tools">
                <button class="btn btn-sm btn-success" wire:click="openModal(false)">Tambah +</button>
                <input wire:model="search" type="text" class="form-control" placeholder="Cari...">
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    wire:click="openModal(true, {{ $user->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger"
                                    wire:click="openDeleteModal({{ $user->id }})">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

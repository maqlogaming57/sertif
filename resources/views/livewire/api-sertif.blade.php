{{-- resources/views/livewire/sertif-table.blade.php --}}
<div>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h3>INPUT SERTIF</h3>
        
        {{-- Error Message --}}
        @if ($error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Search Input --}}
        <div class="p-3 pt-3">
            <div class="input-group mb-3 w-25">
                <input type="text" 
                    class="form-control" 
                    placeholder="Cari berdasarkan nama..." 
                    wire:model.live="katakunci"
                    wire:loading.attr="enable">
                <span class="input-group-text">
                    <div wire:loading wire:target="katakunci">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                    <i class="bi bi-search" wire:loading.remove wire:target="katakunci"></i>
                </span>
            </div>
        </div>

        {{-- Selected Items Action --}}
        @if(count($employee_selected_id) > 0)
            <div class="mb-3">
                <button class="btn btn-danger btn-sm" wire:click="deleteSelected">
                    Hapus {{ count($employee_selected_id) }} data terpilih
                </button>
            </div>
        @endif

        {{-- Main Loading State --}}
        @if ($loading)
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Mengambil data...</p>
            </div>
        @else
            {{-- Data Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nokontrak</th>
                            <th>Nama</th>
                            <th>Notab</th>
                            <th>Kode AO</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataSertifs as $key => $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value['nokontrak'] ?? '-' }}</td>
                                <td>{{ $value['nama'] ?? '-' }}</td>
                                <td>{{ $value['acdrop'] ?? '-' }}</td>
                                <td>{{ $value['kdaoh'] ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-success btn-sm" 
                                            wire:click="selected({{ $value['nokontrak'] ?? $key }})"
                                            wire:loading.attr="disabled"
                                            data-toggle="modal" data-target="#exampleModalCenter">
                                            <i class="bi bi-pencil"></i> Pilih
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox-fill fs-2"></i>
                                        <p class="mt-2">Tidak ada data yang ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Empty State --}}
            @if(empty($dataSertifs))
                <div class="text-center py-4">
                    <i class="bi bi-inbox-fill fs-1 text-muted"></i>
                    <p class="mt-2 text-muted">Belum ada data yang tersedia</p>
                </div>
            @endif
        @endif
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" c>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Data Sertifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($selectedData)
                                    <p><strong>Nomor Kontrak:</strong> {{ $selectedData['nokontrak'] }}</p>
                                    <p><strong>Nama:</strong> {{ $selectedData['nama'] }}</p>
                                    <p><strong>Notab:</strong> {{ $selectedData['acdrop'] }}</p>
                                    <p><strong>Saldo Tabungan:</strong> {{number_format($selectedData['sahirrp'] ?? 0, 0, ',', '.') }}</p>
                                    <p><strong>Saldo Blokir:</strong> {{number_format($selectedData['saldoblok'] ?? 0, 0, ',', '.') }}</p>
                                    <p><strong>Angsurang Margin:</strong> {{ number_format($selectedData['angsmgn'] ?? 0, 0, ',', '.') }} </p>
                                    <p><strong>Angsuran Modal:</strong> {{ number_format($selectedData['angsmdl'] ?? 0, 0, ',', '.') }}</p>
                                    <p><strong>Kode AO:</strong> {{ $selectedData['kdaoh'] }}</p>
                                </div>
                                    <div class="col-md-6">
                                    <form wire:submit.prevent="saveData">
                                    <div class="form-group">
                                        <label for="input1">Angsuran Ke BPRS Hikmah Bahari</label>
                                        <input type="text" id="input1" class="form-control" wire:model="tfangs" value="{{ number_format(($selectedData['angsttl'] ?? 0) *3 + 15000, 0, ',', '.') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="input2">Transfer Ke Nasabah</label>
                                        <input type="text" id="input2" class="form-control" wire:model="tfnsbh">
                                    </div>
                                    <div class="form-group">
                                        <label for="input3">Sisa Saldo ATM</label>
                                        <input type="text" id="input3" class="form-control" wire:model="sahiratm">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan perubahan</button>
                </div>
            </div>
        </div>
    </div>

</div>
 
<script>
    window.addEventListener('showModal', event => {
    $('#exampleModalCenter').modal('show'); // Menampilkan modal menggunakan jQuery
});
</script>

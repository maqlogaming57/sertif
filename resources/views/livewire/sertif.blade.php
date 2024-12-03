<div>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h3>RIWAYAT SERTIF</h3>
        <div class="p-3 pt-3">
            <div class="d-flex justify-content-between">
                <!-- Input pertama -->
                <div class="input-group mb-3 w-25">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama..."
                        wire:model.live="katakunci" wire:loading.attr="enable">
                    <span class="input-group-text">
                        <div wire:loading wire:target="katakunci">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                        <i class="bi bi-search" wire:loading.remove wire:target="katakunci"></i>
                    </span>
                </div>

                <!-- Tombol export ke xlsx -->
                <div class="input-group mb-3 w-25">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Export to xlsx
                    </button>
                </div>
            </div>
        </div>
        {{ $sertifs->links() }}
        @if (session()->has('message'))
            <div class="pt-3">
                <div x-data="{ visible: true }" x-init="setTimeout(() => visible = false, 5000)" x-show="visible" x-transition
                    class="alert alert-success">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nokontrak</th>
                        <th>Nama</th>
                        <th>Notab</th>
                        <th>Saldo Tab</th>
                        <th>Saldo Blokir</th>
                        <th>Sertif Turun</th>
                        <th>TF HIK</th>
                        <th>TF Nasabah</th>
                        <th>Sisa Saldo Atm</th>
                        <th>Rek Pendamping</th>
                        <th>Bank</th>
                        <th>Kode AO</th>
                        <th>User Input</th>
                        <th>User Update</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sertifs as $key => $value)
                        <tr>
                            <td>{{ $sertifs->firstitem() + $key }}</td>
                            <td>{{ $value->nokontrak }}</td>
                            <td>{{ $value->nama }} </td>
                            <td>{{ $value->acdrop }}</td>
                            <td>{{ number_format($value->sahirrp ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($value->saldoblok ?? 0, 0, ',', '.') }}</td>
                             <td>{{ number_format($value->sertiftrn ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($value->tfangs ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($value->tfnsbh ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($value->sahiratm ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $value->rekpend }}</td>
                            <td>{{ $value->bank }}</td>
                            <td>{{ $value->kdaoh }}</td>
                            <td>{{ $value->userinput }}</td>
                            <td>{{ $value->userupdate }}</td>
                            <td>{{ $value->tgl }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModalCenter"
                                    wire:click="edit({{ $value->id }})">Edit</a>
                                <a wire:click="delete_confirmation({{ $value->id }})" class="btn btn-danger btn-sm"
                                    data-toggle="modal" data-target="#deleteModal">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $sertifs->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                      <input type="date" class="form-control" wire:model="start_date">
                      <input type="date" class="form-control" wire:model="end_date">
                    </div>
                        @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                        @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="export()">Export</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModal">Konfimasi Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah mau yakin akan menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                        wire:click="delete()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Riwayat Sertif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="input1">Angsuran Ke BPRS Hikmah Bahari</label>
                            <input type="text" id="input1" class="form-control" wire:model="tfangs"
                                oninput="formatRupiah(this)">
                        </div>
                        <div class="form-group">
                            <label for="input2">Sertif Turun</label>
                            <input type="text" id="input2" class="form-control" wire:model="sertiftrn"
                                oninput="formatRupiah(this)">
                        </div>
                        <div class="form-group">
                            <label for="input2">Transfer Ke Nasabah</label>
                            <input type="text" id="input2" class="form-control" wire:model="tfnsbh"
                                oninput="formatRupiah(this)">
                        </div>
                        <div class="form-group">
                            <label for="input3">Sisa Saldo ATM</label>
                            <input type="text" id="input3" class="form-control" wire:model="sahiratm"
                                oninput="formatRupiah(this)">
                        </div>
                        <div class="form-group">
                            <label for="input3">Rekening Pendamping</label>
                            <input type="text" class="form-control" wire:model="rekpend"
                                oninput="validateNumber(this)">
                        </div>
                        <div class="form-group">
                            <label for="input3">Bank</label>
                            <input type="text" class="form-control" wire:model="bank">
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            wire:click="update()">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

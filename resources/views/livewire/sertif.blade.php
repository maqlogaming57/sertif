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
                        <th>TF HIK</th>
                        <th>TF Nasabah</th>
                        <th>Sisa Saldo Atm</th>
                        <th>Rek Pendamping</th>
                        <th>Bank</th>
                        <th>Kode AO</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sertifs as $key => $value)
                        <tr>
                            <td>{{ $sertifs->firstitem() + $key }}</td>
                            <td>{{ $value->nokontrak }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->acdrop }}</td>
                            <td>{{ $value->sahirrp }}</td>
                            <td>{{ $value->saldoblok }}</td>
                            <td>{{ $value->tfangs }}</td>
                            <td>{{ $value->tfnsbh }}</td>
                            <td>{{ $value->sahiratm }}</td>
                            <td>{{ $value->rekpend }}</td>
                            <td>{{ $value->bank }}</td>
                            <td>{{ $value->kdaoh }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModalCenter">Edit</a>
                                <a wire:click="delete_confirmation({{ $value->id }})" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $sertifs->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="date" class="form-control">
                <input type="date" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Export</button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</div>


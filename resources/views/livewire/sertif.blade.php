<div>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h3>RIWAYAT SERTIF</h3>
        <div class="p-3 pt-3">
            <input type="text" class="form-control mb-3 w-25" placeholder="Search..." wire:model.live="katakunci">
        </div>
        {{-- @if ($employee_selected_id)
        <a wire:click="delete_confirmation('')" class="btn btn-danger btn-sm mb-3" data-bs-toggle="modal"
            data-bs-target="#exampleModal">Del {{ count($employee_selected_id) }} data</a>
    @endif --}}
        {{ $sertifs->links() }}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
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
                            <td>{{ $value->sahir }}</td>
                            <td>{{ $value->saldoblok }}</td>
                            <td>{{ $value->tfangs }}</td>
                            <td>{{ $value->tfnsbh }}</td>
                            <td>{{ $value->sahiratm }}</td>
                            <td>{{ $value->rekpend }}</td>
                            <td>{{ $value->bank }}</td>
                            <td>{{ $value->kdaoh }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                <a wire:click="edit({{ $value->id }})" class="btn btn-warning btn-sm">Edit</a>
                                <a wire:click="delete_confirmation({{ $value->id }})" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $sertifs->links() }}
    </div>
</div>

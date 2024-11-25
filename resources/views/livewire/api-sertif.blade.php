<div class="my-3 p-3 bg-body rounded shadow-sm">
    <h3>INPUT SERTIF</h3>
    <div class="p-3 pt-3">
        <input type="text" class="form-control mb-3 w-25" placeholder="Search..." wire:model.live="katakunci">
    </div>
    {{-- @if ($employee_selected_id)
        <a wire:click="delete_confirmation('')" class="btn btn-danger btn-sm mb-3" data-bs-toggle="modal"
            data-bs-target="#exampleModal">Del {{ count($employee_selected_id) }} data</a>
    @endif --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th class="col-md-1">No</th>
                <th class="col-md-3">Nokontrak</th>
                <th class="col-md-3">Nama</th>
                <th class="col-md-2">Notab</th>
                <th class="col-md-2">Kode Produk</th>
                <th class="col-md-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($dataSertifs as $key => $value)
                <tr>
                    <td><input type="checkbox" wire:key="{{ $value->id }}" value="{{ $value->id }}"
                            wire:model.live="employee_selected_id"></td>
                    <td>{{ $dataSertifs->firstitem() + $key }}</td>
                    <td>{{ $value->nokontrak }}</td>
                    <td>{{ $value->nama }}</td>
                    <td>{{ $value->acdrop }}</td>
                    <td>
                        <a wire:click="edit({{ $value->id }})" class="btn btn-warning btn-sm">Edit</a>
                        <a wire:click="delete_confirmation({{ $value->id }})" class="btn btn-danger btn-sm"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>

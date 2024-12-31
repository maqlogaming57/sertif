<div>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        @if ($errors->any())
            <div class="pt-3">
                <div x-data="{ visible: true }" x-init="setTimeout(() => visible = false, 5000)" x-show="visible" x-transition
                    class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
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
        <h3>INPUT SERTIF</h3>

        {{-- Error Message --}}
        @if ($error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
            </div>
        @endif

        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="input-group mb-3 w-25 w-md-25 align-items-center">
                <input type="text" class="form-control" placeholder="Masukan nama / nokontrak"
                    wire:model.defer="katakunci">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary d-flex align-items-center" wire:click="cariData" wire:loading.attr="disabled">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <!-- Spinner Loading -->
                    <div class="ms-2" wire:loading wire:target="cariData">
                        <div class="spinner-border spinner-border-sm" role="status">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

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
                    <thead class="thead-dark">
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
                                            wire:loading.attr="disabled" data-toggle="modal"
                                            data-target="#exampleModalCenter">
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

            @if (empty($dataSertifs))
                <div class="text-center py-4">
                    <i class="bi bi-inbox-fill fs-1 text-muted"></i>
                    <p class="mt-2 text-muted">Belum ada data yang tersedia</p>
                </div>
            @endif
        @endif
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                @if ($selectedData)
                                    <p><strong>Nomor Kontrak:</strong> {{ $selectedData['nokontrak'] }}</p>
                                    <p><strong>Nama:</strong> {{ $selectedData['nama'] }}</p>
                                    <p><strong>Notab:</strong> {{ $selectedData['acdrop'] }}</p>
                                    <p><strong>Saldo Tabungan:</strong>
                                        {{ number_format($selectedData['sahirrp'] ?? 0, 0, ',', '.') }}</p>
                                    <p><strong>Saldo Blokir:</strong>
                                        {{ number_format($selectedData['saldoblok'] ?? 0, 0, ',', '.') }}</p>
                                    <p><strong>Angsurang Margin:</strong>
                                        {{ number_format($selectedData['tagmgn'] ?? 0, 0, ',', '.') }} </p>
                                    <p><strong>Angsuran Modal:</strong>
                                        {{ number_format($selectedData['tagmdl'] ?? 0, 0, ',', '.') }}</p>
                                    <p><strong>Kode AO:</strong> {{ $selectedData['kdaoh'] }}</p>
                                    <p><strong>Kode Loc:</strong> {{ $selectedData['kdcab'] }}</p>
                                    <p><strong>Tanggal Jatuh Tempo:</strong> {{ $selectedData['tgltagih'] }}</p>
                                    <p><strong>Kolekbilitas:</strong> {{ $selectedData['colbaru'] }}</p>
                                    <p class="text-danger"><span>*Perhatikan Kolekbilitas jika sakdo mencukupi tambahkan dengan tunggakan</span></p>
                                    <p><strong>Angsuran Modal + Margin:</strong>
                                        {{ number_format($selectedData['angsttl'] ?? 0, 0, ',', '.') }}</p>
                                    <button wire:click="calculatePayment(1)" class="btn btn-outline-primary me-2">1
                                        Bulan</button>
                                    <button wire:click="calculatePayment(2)" class="btn btn-outline-primary me-2">2
                                        Bulan</button>
                                    <button wire:click="calculatePayment(3)" class="btn btn-outline-primary">3
                                        Bulan</button>
                            </div>
                            <div class="col-md-6">
                                <form>
                                    <div class="form-group">
                                        <label for="input2">Sertif Turun</label>
                                        <input type="text" id="input2" class="form-control" wire:model="sertiftrn"
                                            oninput="formatRupiah(this)">
                                    </div>
                                    <div class="form-group">
                                        <label for="termin">Termin Ke</label>
                                        <select id="termin" class="custom-select" wire:model="termin">
                                            <option selected>Pilih Termin</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="input1">Angsuran Ke BPRS Hikmah Bahari</label>
                                        <input type="text" id="input1" class="form-control" wire:model="tfangsrp"
                                            oninput="formatRupiah(this)">
                                    </div>
                                    <div class="form-group">
                                        <label for="input2">Transfer Ke Nasabah</label>
                                        <input type="text" id="input2" class="form-control" wire:model="tfnsbh"
                                            oninput="formatRupiah(this)">
                                    </div>
                                    <div class="form-group">
                                        <label for="input3">Sisa Saldo ATM</label>
                                        <input type="text" id="input3" class="form-control"
                                            wire:model="sahiratm" oninput="formatRupiah(this)">
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
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                                        wire:click="store()">Simpan</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

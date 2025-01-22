@if (session()->has('message'))
    <div class="pt-3">
        <div x-data="{ visible: true }" x-init="setTimeout(() => visible = false, 5000)" x-show="visible" x-transition
            class="alert alert-success">
            {{ session('message') }}
        </div>
    </div>
@endif
<div class="card card-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Realisasi sertif turun bulan ini</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Cabang</th>
                    <th>Tanggal</th>
                    <th>Sertif Turun</th>
                </tr>
            </thead>
            <tbody>
                @foreach (['01' => 'Pusat', '02' => 'Batang', '03' => 'Purwokerto'] as $kdcab => $nama)
                    @php
                        $item = $realisasi->firstWhere('kdcab', $kdcab);
                        $total_sertiftrn = $item ? $item->total_sertiftrn : 0;
                    @endphp
                    <tr>
                        <td>{{ $nama }}</td>
                        <td>{{ date('M') }}</td> <!-- Sesuaikan tanggal sesuai kebutuhan -->
                        <td>{{ 'Rp ' . number_format($total_sertiftrn, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b>{{ 'Rp ' . number_format($realisasi->sum('total_sertiftrn'), 0, ',', '.') }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <div class="logo-container text-center mb-3">
        <img src="{{$pemesanan->kendaraan->image}}" class="rounded-circle" style="width: 100px; height: 100px;" alt="Logo">
        <p class="mt-2"><b>Konsumsi BBM  :  {{ number_format($pemesanan->kendaraan->konsumsi_bbm, 0, ',', '.') }}Liter</b></p>
        <p class="mt-2"><b>Jadwal Service:  {{ \Carbon\Carbon::parse($pemesanan->kendaraan->jadwal_service)->format('d-m-Y') }}</b></p>

    </div>
    <h5 class="small-h5">Status Supir :  @if ($pemesanan->user_approve_1_id)
        <i class="fas fa-check-circle" style="color: #63E6BE;"></i> Disetujui
    @else
        <i class="fas fa-times-circle text-danger"></i> Pending
    @endif</h5>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Nama Supir</th>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Nomer Supir</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $pemesanan->supir->nama_supir }}</td>
                    <td>{{ $pemesanan->supir->nomer }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h5 class="small-h5">Status Kepala Cabang :  @if ($pemesanan->user_approve_2_id)
        <i class="fas fa-check-circle" style="color: #63E6BE;"></i> Disetujui
    @else
        <i class="fas fa-times-circle text-danger"></i> Pending
    @endif</h5>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Nama Kepala Cabang</th>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Alamat Kantor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $pemesanan->pengelola->nama_pengelola }}</td>
                    <td>{{ $pemesanan->pengelola->cabang }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <h5 class="small-h5">Pengajuan Pesanan</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Kendaraan</th>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Nama Kendaraan</th>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Jenis Kendaraan</th>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Uang BBM</th>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Lokasi Tujuan</th>
                    <th style="background-color: #f8f9fa; border-color: #dee2e6;">Tanggal Berangkat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="{{ $pemesanan->kendaraan->image }}" style="max-width: 100px;" alt="Image"></td>
                    <td>{{ $pemesanan->kendaraan->nama_kendaraan }}</td>
                    <td>{{ $pemesanan->kendaraan->jenis_kendaraan }}</td>
                    <td>Rp {{ number_format($pemesanan->uang_bbm, 0, ',', '.') }}</td>
                    <td>{{ $pemesanan->lokasi_tujuan }}</td>
                    <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<style>

    .small-h5 {
        font-size: 13px;
    }
    .table th {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .table-responsive {
        margin-bottom: 15px;
        overflow-y: auto;
        max-height: 200px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
</style>

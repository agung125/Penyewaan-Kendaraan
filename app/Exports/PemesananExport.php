<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemesananExport implements FromCollection, WithHeadings
{
    protected $pemesanan;

    public function __construct(Pemesanan $pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    public function collection()
    {
        return collect([
            [
                'Nama Supir' => $this->pemesanan->supir->nama_supir,
                'Nomer Supir' => $this->pemesanan->supir->nomer,
                'Status Supir' => $this->pemesanan->user_approve_1_id ? 'Disetujui' : 'Pending',
                'Nama Kepala Cabang' => $this->pemesanan->pengelola->nama_pengelola,
                'Alamat Kantor' => $this->pemesanan->pengelola->cabang,
                'Status Kepala Cabang' => $this->pemesanan->user_approve_2_id ? 'Disetujui' : 'Pending',
                'Kendaraan' => $this->pemesanan->kendaraan->nama_kendaraan,
                'Jenis Kendaraan' => $this->pemesanan->kendaraan->jenis_kendaraan,
                'Uang BBM' => 'Rp ' . number_format($this->pemesanan->uang_bbm, 0, ',', '.'),
                'Lokasi Tujuan' => $this->pemesanan->lokasi_tujuan,
                'Tanggal Berangkat' => $this->pemesanan->tanggal_berangkat ? \Carbon\Carbon::parse($this->pemesanan->tanggal_berangkat)->format('d-m-Y') : null,
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Supir',
            'Nomer Supir',
            'Status Supir',
            'Nama Kepala Cabang',
            'Alamat Kantor',
            'Status Kepala Cabang',
            'Kendaraan',
            'Jenis Kendaraan',
            'Uang BBM',
            'Lokasi Tujuan',
            'Tanggal Berangkat',
        ];
    }
}


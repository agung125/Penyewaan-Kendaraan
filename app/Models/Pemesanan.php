<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function supir()
    {
        return $this->belongsTo(Supir::class, 'supir_id');
    }

    public function pengelola()
    {
        return $this->belongsTo(pengelola::class, 'pengelola_id');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }



    protected static function boot()
{
    parent::boot();

    static::saving(function ($pemesanan) {
        $kendaraan = Kendaraan::find($pemesanan->kendaraan_id);
        if ($kendaraan) {
            $kendaraan->status = $pemesanan->supir_id;
            $kendaraan->supir_id = $pemesanan->supir_id;
            $kendaraan->riwayat_pemaikaian = $pemesanan->tanggal_berangkat;
            $kendaraan->save();
        }
    });
}


}

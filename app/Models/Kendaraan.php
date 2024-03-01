<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDataForChart()
    {
        return $this->select('nama_kendaraan', 'riwayat_pemakaian', 'jadwal_service')->get();
    }


    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class,'kendaraan_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/kendaraans/' . $value),
        );
    }
}

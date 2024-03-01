<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class,'supir_id');
    }

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}

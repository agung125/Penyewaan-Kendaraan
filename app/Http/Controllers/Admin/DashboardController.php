<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $kendaraan = Kendaraan::all();
        foreach ($kendaraan as $k) {
            $jadwalService = Carbon::parse($k->jadwal_service);
            $selisih = now()->diffInDays($jadwalService);
            $k->selisih_hari = $selisih;
            $k->komentar = ($selisih <= 2) ? 'Harus Service ' . $k->nama_kendaraan : 'Normal ' . $k->nama_kendaraan;
        }

        return view('admin.dashboard.index', compact('kendaraan'));
    }



}

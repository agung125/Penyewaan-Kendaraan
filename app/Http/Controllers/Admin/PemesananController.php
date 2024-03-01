<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PemesananExport;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pemesanan;
use App\Models\pengelola;
use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::latest()->when(request()->q, function($pemesanans) {
            $pemesanans = $pemesanans->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    public function create()
    {
        $supirs = Supir::latest()->get();
        $kendaraans = Kendaraan::latest()->get();
        $pengelolas = pengelola::latest()->get();
        return view('admin.pemesanan.create', compact('supirs', 'kendaraans','pengelolas'));

    }

    public function store(Request $request)
    {

        // dd($request->all());
        $this->validate($request, [
            'supir_id' => 'required',
            'pengelola_id' => 'required',
            'kendaraan_id' => 'required',
            'uang_bbm' => 'required',
            'lokasi_tujuan' => 'required',
            'tanggal_berangkat' => 'required'
        ]);

        $pemesanan = Pemesanan::create([
            'supir_id' => $request->input('supir_id'),
            'pengelola_id' => $request->input('pengelola_id'),
            'kendaraan_id' => $request->input('kendaraan_id'),
            'uang_bbm' => $request->input('uang_bbm'),
            'lokasi_tujuan' => $request->input('lokasi_tujuan'),
            'tanggal_berangkat' => $request->input('tanggal_berangkat')
        ]);

        if($pemesanan){
            //redirect dengan pesan sukses
            return redirect()->route('admin.pemesanan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.pemesanan.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        return view('admin.pemesanan.show', compact('pemesanan'));
    }


    public function exportPemesanan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        return Excel::download(new PemesananExport($pemesanan), 'pemesanan.xlsx');
    }





    public function edit(Pemesanan $pemesanan)
    {
        return view('admin.pemesanan.edit', compact('pemesanan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemesanan $pemesanan)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$pemesanan->id
        ]);

        $pemesanan = Pemesanan::findOrFail($pemesanan->id);
        $pemesanan->update([
            'name' => $request->input('name'),
        ]);

        if($pemesanan){
            //redirect dengan pesan sukses
            return redirect()->route('admin.pemesanan.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.pemesanan.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();

        if($pemesanan){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

}

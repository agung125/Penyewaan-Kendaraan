<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::latest()->when(request()->q, function($kendaraans) {
            $kendaraans = $kendaraans->where('nama_kendaraan', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {

        return view('admin.kendaraan.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image',
            'nama_kendaraan'   => 'required',
            'jenis_kendaraan'   => 'required',
            'konsumsi_bbm'   => 'required',
            'jadwal_service'   => 'required'

        ]);

        $image = $request->file('image');
        $image->storeAs('public/kendaraans', $image->hashName());

        $kendaraan = Kendaraan::create([
            'image'     => $image->hashName(),
            'nama_kendaraan'   => $request->input('nama_kendaraan'),
            'jenis_kendaraan'   => $request->input('jenis_kendaraan'),
            'konsumsi_bbm'   => $request->input('konsumsi_bbm'),
            'jadwal_service'   => $request->input('jadwal_service')
        ]);

        $kendaraans = new Kendaraan();
        $kendaraans->kendaraan_id = $kendaraan->id;
        $kendaraan->save();

        if($kendaraan){
            //redirect dengan pesan sukses
            return redirect()->route('admin.kendaraan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.kendaraan.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $kendaraan = Kendaraan::findOrFail($id);
        $image = Storage::disk('local')->delete('public/kendaraans/'.basename($kendaraan->image));
        $kendaraan->delete();

        if($kendaraan){
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

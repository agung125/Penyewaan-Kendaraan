<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\pengelola;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PengelolaController extends Controller
{

    public function index()
    {
        $pengelolas = pengelola::latest()->when(request()->q, function($pengelolas) {
            $pengelolas = $pengelolas->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.pengelola.index', compact('pengelolas'));
    }


    public function create()
    {
        $roles = Role::latest()->get();
        return view('admin.pengelola.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'cabang' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);


        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'user_id' => null,
        ]);

        $user->assignRole($request->input('role'));

        $pengelola = new pengelola();
        $pengelola->pengelola_id = $user->id;
        $pengelola->nama_pengelola = $user->name;
        $pengelola->cabang =  $request->input('cabang');
        $pengelola->save();

        $user->user_id = $pengelola->id;
        $user->save();

        if ($pengelola) {
            // Redirect dengan pesan sukses
            return redirect()->route('admin.pengelola.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            // Redirect dengan pesan error
            return redirect()->route('admin.pengelola.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(pengelola $pengelola)
    {
        return view('admin.pengelola.edit', compact('pengelola'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pengelola $pengelola)
    {
        $this->validate($request, [
            'nama_pengelola' => 'required',
            'cabang' => 'required'
        ]);

        $pengelola = pengelola::findOrFail($pengelola->id);
        $pengelola->update([
            'nama_pengelola' => $request->input('nama_pengelola'),
            'cabang' => $request->input('cabang'),

        ]);

        if($pengelola){
            //redirect dengan pesan sukses
            return redirect()->route('admin.pengelola.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.pengelola.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $pengelola = pengelola::findOrFail($id);
        $pengelola->delete();

        if($pengelola){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }






    public function approvePemesanan($pemesananId)
    {
        $pemesanan = Pemesanan::findOrFail($pemesananId);

        if ($pemesanan->user_approve_2_id) {
            return redirect()->back()->with('error', 'Pemesanan sudah disetujui oleh pengelola sebelumnya');
        }

        $pemesanan->user_approve_2_id = auth()->user()->id;
        $pemesanan->save();

        return redirect()->back()->with('success', 'Pemesanan berhasil disetujui oleh pengelola');
    }

    public function rejectPemesanan($pemesananId)
    {
        $pemesanan = Pemesanan::findOrFail($pemesananId);


        if ($pemesanan->user_approve_2_id) {
            return redirect()->back()->with('error', 'Pemesanan sudah ditolak oleh pengelola sebelumnya');
        }

        $pemesanan->user_approve_2_id = auth()->user()->id;
        $pemesanan->status = 'tidak disetujui';
        $pemesanan->save();

        return redirect()->back()->with('success', 'Pemesanan berhasil ditolak oleh pengelola');
    }



}

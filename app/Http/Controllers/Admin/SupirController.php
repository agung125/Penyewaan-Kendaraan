<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Supir;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SupirController extends Controller
{

    public function index()
    {
        $supirs = Supir::latest()->when(request()->q, function($supirs) {
            $supirs = $supirs->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.supir.index', compact('supirs'));
    }

    public function create()
    {
        $roles = Role::latest()->get();
        return view('admin.supir.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'nomer' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'user_id' => null, // Set default value to null
        ]);

        $user->assignRole($request->input('role'));

        $supir = new Supir();
        $supir->supir_id = $user->id;
        $supir->nama_supir = $user->name;
        $supir->nomer = $request->input('nomer');
        $supir->save();


        $user->user_id = $supir->id;
        $user->save();

        if ($user && $supir) {
            // Redirect with success message
            return redirect()->route('admin.supir.index')->with('success', 'Data Berhasil Disimpan!');
        } else {
            // Redirect with error message
            return redirect()->route('admin.supir.index')->with('error', 'Data Gagal Disimpan!');
        }
    }

    public function edit(Supir $supir)
    {
        return view('admin.supir.edit', compact('supir'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supir $supir)
    {
        $this->validate($request, [
            'nama_supir' => 'required'
        ]);

        $supir = Supir::findOrFail($supir->id);
        $supir->update([
            'nama_supir' => $request->input('nama_supir'),
            'nomer' => $request->input('nomer'),

        ]);

        if($supir){
            //redirect dengan pesan sukses
            return redirect()->route('admin.supir.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.supir.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $supir = Supir::findOrFail($id);
        $supir->delete();

        if($supir){
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


        if ($pemesanan->user_approve_1_id) {
            return redirect()->back()->with('error', 'Pemesanan sudah disetujui oleh supir sebelumnya');
        }

        // Setujui pemesanan oleh supir
        $pemesanan->user_approve_1_id = auth()->user()->id;
        $pemesanan->save();

        return redirect()->back()->with('success', 'Pemesanan berhasil disetujui oleh supir');
    }

    public function rejectPemesanan($pemesananId)
    {
        $pemesanan = Pemesanan::findOrFail($pemesananId);

        if ($pemesanan->user_approve_1_id) {
            return redirect()->back()->with('error', 'Pemesanan sudah ditolak oleh supir sebelumnya');
        }
        $pemesanan->user_approve_1_id = auth()->user()->id;
        $pemesanan->status = 'tidak disetujui';
        $pemesanan->save();

        return redirect()->back()->with('success', 'Pemesanan berhasil ditolak oleh supir');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SatuanObatController extends Controller
{
    //
    public function index()
    {
        // Mengambil semua data satuan obat yang belum dihapus
        $satuans = Obat::getSatuanObat();
        return view('admin.satuan_obat.index', compact('satuans'));
    }

    public function create()
    {
        return view('admin.satuan_obat.create');
    }

    public function store(Request $request)
    {
        $satuanObat = $request->validate([
            'nama' => 'nullable|string|max:50',
        ]);
        // dd($satuanObat);
    
        Obat::insertSatuan($satuanObat);
    
        return redirect()->route('admin.satuan_obat.index')->with('success', 'Satuan Obat berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Ambil data satuan obat berdasarkan ID
        $editsatuan = DB::table('satuan_obat')->where('id', $id)->first();
        return view('admin.satuan_obat.edit', compact('editsatuan'));
    }

    public function update(Request $request, $id)
    {
        $satuanObat = $request->validate([
            'nama' => 'nullable|string|max:50',
        ]);
    
        DB::table('satuan_obat')->where('id', $id)->update($satuanObat);
    
        return redirect()->route('admin.satuan_obat.index')->with('success', 'Satuan obat berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Hapus data satuan obat berdasarkan ID
        DB::table('satuan_obat')->where('id', $id)->update(['deleted_at' => now()]);
    
        return redirect()->route('admin.satuan_obat.index')->with('success', 'Satuan obat berhasil dihapus');
    }
}

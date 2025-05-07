<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ObatController extends Controller
{
    // Menampilkan daftar obat
    public function index()
    {
        // Mengambil semua data obat yang belum dihapus
        $obats = Obat::getAll(); 
        return view('admin.obat.index', compact('obats'));
    }

    // Menampilkan form untuk membuat obat baru
    public function create()
    {   
        $formulas = Obat::getWithFormula(); // Adjusted to not require an $id
        $satuans = Obat::getSatuanObat();
        return view('admin.obat.create', compact('formulas','satuans'));
    }

    // Menyimpan data obat baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_obat' => 'required|string|max:255',
            'nama_obat' => 'required|string|max:255',
            'bentuk_sediaan' => 'nullable|string|max:255',
            'golongan' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'formula_id' => 'required|integer',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|integer',
            'satuan' => 'nullable|string|max:50',
        ]);
    
        // dd($data);
        $data['inserted_user'] = Auth::user()->name ?? 'admin';
        $data['updated_user'] = Auth::user()->name ?? 'admin';
    
        Obat::insert($data);
    
        return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil ditambahkan');
    }
    

    // Menampilkan form untuk mengedit data obat
    public function edit($id)
{
    // Ambil data obat berdasarkan ID
    $obat = Obat::findById($id);

    // Ambil formula sesuai dengan formula_id pada obat
    $formula = DB::table('formula')
                 ->where('id', $obat->formula_id)
                 ->whereNull('deleted_at')
                 ->first();

    if (!$obat) {
        return redirect()->route('admin.obat.index')->with('error', 'Obat tidak ditemukan');
    }

    // Ambil semua data formula untuk dropdown
    $formulas = DB::table('formula')->whereNull('deleted_at')->get();
    $satuan = Obat::getSatuanObat();

    return view('admin.obat.edit', compact('obat', 'formulas', 'formula','satuan'));
}


    // Mengupdate data obat
    public function update($id, Request $request)
{
    
    $data = $request->validate([
            'kode_obat' => 'required|string|max:255',
            'nama_obat' => 'required|string|max:255',
            'bentuk_sediaan' => 'nullable|string|max:255',
            'golongan' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'formula_id' => 'required|integer',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|integer',
            'satuan' => 'nullable|string|max:50',
    ]);

    $data['updated_user'] = Auth::user()->name ?? 'admin';
    // dd($data);

    Obat::updateById($id, $data);

    return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil diperbarui');
}


    // Menghapus data obat
    public function destroy($id)
    {
        // Menghapus data obat berdasarkan ID
        Obat::deleteById($id);

        // Redirect ke halaman index dan beri pesan sukses
        return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil dihapus');
    }

    // Menampilkan detail obat
    // public function show($id)
    // {
    //     // Mencari data obat berdasarkan ID
    //     $obat = Obat::findById($id);

    //     if (!$obat) {
    //         return redirect()->route('admin.obat.index')->with('error', 'Obat tidak ditemukan');
    //     }

    //     return view('admin.obat.show', compact('obat'));
    // }


}

<?php

namespace App\Http\Controllers;

use App\Models\Asuransi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AsuransiController extends Controller
{
    public function index()
    {
        $asuransi = Asuransi::getAll();
        return view('admin.asuransi.index', compact('asuransi'));
    }

    public function create()
    {
        $jenis_asuransi = DB::select("SELECT * FROM js_asuransi");
        return view('admin.asuransi.create', compact('jenis_asuransi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'nullable|string|max:20',
            'jenis' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        Asuransi::insert([
            'nama' => $request->nama,
            'no_tlp' => $request->no_tlp,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'inserted_user' => auth()->id(),
            'updated_user' => auth()->id(),
        ]);

        return redirect()->route('admin.asuransi.index')->with('success', 'Asuransi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $asuransi = Asuransi::findById($id);
        $jenis_asuransi = DB::select("SELECT * FROM js_asuransi");

        return view('admin.asuransi.edit', compact('asuransi', 'jenis_asuransi'));
    }

    public function update(Request $request, $id)
    {
        // $id = Crypt::decrypt(payload: $id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'nullable|string|max:20',
            'jenis' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        Asuransi::updateById($id, [
            'nama' => $request->nama,
            'no_tlp' => $request->no_tlp,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'updated_user' => auth()->id(),
        ]);

        return redirect()->route('admin.asuransi.index')->with('success', 'Asuransi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        Asuransi::deleteById($id);

        return redirect()->route('admin.asuransi.index')->with('success', 'Asuransi berhasil dihapus.');
    }
}

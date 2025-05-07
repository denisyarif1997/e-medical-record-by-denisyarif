<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formula;

class FormulaController extends Controller
{
    //
    public function index()
    {
        // Mengambil semua data formula yang belum dihapus
        $formulas = Formula::getAll();
        return view('admin.formula.index', compact('formulas'));
    }
    public function create()
    {
        return view('admin.formula.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'faktor' => 'required|numeric',
        ]);

        Formula::create($data);

        return redirect()->route('admin.formula.index')->with('success', 'Formula berhasil ditambahkan');
    }
    public function edit($id)
    {
        // Ambil data formula berdasarkan ID
        $formula = Formula::getById($id);

        return view('admin.formula.edit', compact('formula'));
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'faktor' => 'required|numeric',
        ]);

        Formula::where('id', $id)->update($data);

        return redirect()->route('admin.formula.index')->with('success', 'Formula berhasil diperbarui');
    }
    public function destroy($id)
    {
        // Hapus data formula berdasarkan ID
        Formula::where('id', $id)->delete();

        return redirect()->route('admin.formula.index')->with('success', 'Formula berhasil dihapus');
    }
}

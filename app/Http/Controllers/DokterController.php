<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Dokter;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = DB::select("
            SELECT 
                d.*, 
                s.nama_spesialis 
            FROM dokters d
            LEFT JOIN spesialis s ON d.spec_code = s.code 
            WHERE d.deleted_at IS NULL
            ORDER BY d.id DESC
        ");

        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $spesialis = DB::table('spesialis')->get();
        return view('admin.dokter.create', compact('spesialis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'spec_code' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
        ]);

        DB::table('dokters')->insert([
            'nama' => $request->nama,
            'spec_code' => $request->spec_code,
            'no_hp' => $request->no_hp,
            'inserted_user' => auth()->id(),
            'updated_user' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $dokter = DB::table('dokters')->where('id', $id)->first();
        $spesialis = DB::table('spesialis')->get();

        return view('admin.dokter.edit', compact('dokter', 'spesialis'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'spec_code' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
        ]);

        DB::table('dokters')->where('id', $id)->update([
            'nama' => $request->nama,
            'spec_code' => $request->spec_code,
            'no_hp' => $request->no_hp,
            'updated_user' => auth()->id(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $dokter = Dokter::findOrFail($id);
        $dokter->delete(); // Soft delete
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }
}

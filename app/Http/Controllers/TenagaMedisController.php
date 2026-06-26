<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\TenagaMedis;
use Illuminate\Support\Facades\DB;

class TenagaMedisController extends Controller
{
    public function index()
    {
        $tenagaMedis = DB::select("
            SELECT 
                tm.*, 
                s.nama_spesialis 
            FROM tenaga_medis tm
            LEFT JOIN spesialis s ON tm.spec_code = s.code 
            WHERE tm.deleted_at IS NULL
            ORDER BY tm.id DESC
        ");

        return view('admin.tenaga_medis.index', compact('tenagaMedis'));
    }

    public function create()
    {
        $spesialis = DB::table('spesialis')->get();
        return view('admin.tenaga_medis.create', compact('spesialis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'spec_code' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'str' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|string|max:10',
        ]);

        DB::table('tenaga_medis')->insert([
            'nama' => $request->nama,
            'type' => $request->type,
            'spec_code' => $request->spec_code,
            'no_hp' => $request->no_hp,
            'str' => $request->str,
            'jenis_kelamin' => $request->jenis_kelamin,
            'inserted_user' => auth()->id(),
            'updated_user' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.tenaga_medis.index')->with('success', 'Tenaga Medis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $tenagaMedis = DB::table('tenaga_medis')->where('id', $id)->first();
        $spesialis = DB::table('spesialis')->get();

        return view('admin.tenaga_medis.edit', compact('tenagaMedis', 'spesialis'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'spec_code' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'str' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|string|max:10',
        ]);

        DB::table('tenaga_medis')->where('id', $id)->update([
            'nama' => $request->nama,
            'type' => $request->type,
            'spec_code' => $request->spec_code,
            'no_hp' => $request->no_hp,
            'str' => $request->str,
            'jenis_kelamin' => $request->jenis_kelamin,
            'updated_user' => auth()->id(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.tenaga_medis.index')->with('success', 'Tenaga Medis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $tenagaMedis = TenagaMedis::findOrFail($id);
        $tenagaMedis->delete(); // Soft delete
        return redirect()->route('admin.tenaga_medis.index')->with('success', 'Tenaga Medis berhasil dihapus.');
    }
}
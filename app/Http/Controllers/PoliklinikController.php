<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoliklinikController extends Controller
{
    public function index()
    {
        $poliklinik = DB::table('poliklinik')
            ->join('dokters', 'poliklinik.dokter_id', '=', 'dokters.id')
            ->select('poliklinik.*', 'dokters.nama as dokter_nama')
            ->whereNull('dokters.deleted_at')
            ->get();

        return view('admin.poliklinik.index', compact('poliklinik'));
    }

    public function create()
    {
        // Mendapatkan daftar dokter untuk dropdown
        $dokters = DB::table('dokters')
        ->whereNull('deleted_at')
        ->get();
        return view('admin.poliklinik.create', compact('dokters'));
    }

    public function store(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'nama' => 'required|string|max:255',
        'dokter_id' => 'required|integer',
        'waktu_mulai' => 'required|date_format:H:i',
        'waktu_selesai' => 'required|date_format:H:i',
        'hari' => 'required|string|max:50',
    ]);

    // Get the authenticated user's name
    $userName = auth()->user()->id;

    // Create a new Poliklinik record
    DB::table('poliklinik')->insert([
        'nama' => $request->nama,
        'dokter_id' => $request->dokter_id,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
        'hari' => $request->hari,
        'inserted_user' => $userName,  // Set the inserted_user to the authenticated user's name
        'updated_user' => $userName,  // Set the updated_user to the authenticated user's name
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.poliklinik.index')->with('success', 'Poliklinik created successfully!');
}


    public function edit($id)
    {
        // Mengambil data poliklinik berdasarkan ID
        $id = decrypt($id);
        $poliklinik = Poliklinik::findOrFail($id);
        $dokters = DB::table('dokters')
        ->whereNull('deleted_at')
        ->get();        return view('admin.poliklinik.edit', compact('poliklinik', 'dokters'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'dokter_id' => 'required|integer|exists:dokters,id',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'hari' => 'required|string|max:50',
        ]);

        $poliklinik = Poliklinik::findOrFail($id);
        $poliklinik->update([
            'nama' => $request->nama,
            'dokter_id' => $request->dokter_id,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'hari' => $request->hari,
            'updated_user' => auth()->id(),
        ]);

        return redirect()->route('admin.poliklinik.index')->with('success', 'Poliklinik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Decrypt the ID to get the actual integer value
        $id = decrypt($id);
    
        // Now you can safely use the decrypted $id
        DB::table('poliklinik')->where('id', $id)->delete();
    
        return redirect()->route('admin.poliklinik.index')->with('success', 'Poliklinik deleted successfully!');
    }
}    
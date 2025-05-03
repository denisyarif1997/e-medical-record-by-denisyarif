<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Asuransi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class PasienController extends Controller
{
    public function index()
{
    $pasiens = DB::select('
   SELECT p.*, a.nama as nama_asuransi
    FROM pasiens p
    JOIN asuransi a ON p.asuransi_id = a.id
    where p.deleted_at is null and a.deleted_at is null
    ORDER BY p.id DESC
');

    return view('admin.pasien.index', compact('pasiens')); // Kirim data pasien ke view
}


    public function create()
    {
        

        $asuransis = DB::select('select * from asuransi where deleted_at is null    ');
        return view('admin.pasien.create',compact('asuransis'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nik' => 'nullable|string|max:50',
        'nama' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'tanggal_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
        'penanggung' => 'nullable|string|max:100',
        'asuransi_id' => 'nullable|integer',
        'no_asuransi' => 'nullable|string|max:100',
    ]);

    
    // Create the new Pasien
    $pasien = Pasien::create([
        'nik' => $request->nik,
        'nama' => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'penanggung' => $request->penanggung,
        'asuransi_id' => $request->asuransi_id,
        'no_asuransi' => $request->no_asuransi,
        'inserted_user' => auth()->id(),
        'updated_user' => auth()->id(),
    ]);

    // Generate no_rekam_medis based on the new Pasien ID
    $pasien->no_rekam_medis = str_pad($pasien->id, 9, '0', STR_PAD_LEFT);

    // Save the Pasien record again to update no_rekam_medis
    $pasien->save();

    return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
}


    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $asuransis = Asuransi::getAll();
        $pasien = Pasien::findOrFail($id);
        return view('admin.pasien.edit', compact('pasien','asuransis'));
    }

    public function update(Request $request, $id)
{

    $id = Crypt::decrypt($id);
    
    // Validate the incoming data
    $request->validate([
        'nik' => 'nullable|string|max:50',
        'nama' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'tanggal_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
        'penanggung' => 'nullable|string|max:100',
        'asuransi_id' => 'nullable|integer',
        'no_asuransi' => 'nullable|string|max:100',
    ]);

    // Find the existing Pasien record
    $pasien = Pasien::findOrFail($id);

    // Update the Pasien record with the validated data
    $pasien->update([
        'nik' => $request->nik,
        'nama' => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'penanggung' => $request->penanggung,
        'asuransi_id' => $request->asuransi_id,
        'no_asuransi' => $request->no_asuransi,
        'updated_user' => auth()->id(), // Update the user who updated the record
    ]);

    // Redirect back to the pasien index page with a success message
    return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil diperbarui.');
}

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil dihapus.');
    }
}

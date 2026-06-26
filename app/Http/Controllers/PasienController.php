<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Asuransi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class PasienController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggalAwal', date('Y-m-d'));
        $tanggalAkhir = $request->input('tanggalAkhir', date('Y-m-d'));

        $pasiens = DB::select('
            SELECT p.*, a.nama as nama_asuransi
            FROM pasiens p
            JOIN asuransi a ON p.asuransi_id = a.id
            WHERE p.deleted_at IS NULL AND a.deleted_at IS NULL
            AND DATE(p.created_at) BETWEEN ? AND ?
            ORDER BY p.id DESC
        ', [$tanggalAwal, $tanggalAkhir]);

        return view('admin.pasien.index', compact('pasiens', 'tanggalAwal', 'tanggalAkhir'));
    }


        public function create()
        {
            
            $asuransis = DB::select('select * from asuransi where deleted_at is null    ');
            return view('admin.pasien.create',compact('asuransis'));
        }

        public function store(Request $request)
    {

        if (!empty($request->nik)) {
        $cekNik = Pasien::whereNull('deleted_at')
            ->where('nik', $request->nik)
            ->exists();

        if ($cekNik) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'NIK sudah digunakan.');
        }
    }
        $request->validate([
            'nik' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'status_pernikahan' => 'nullable|string|max:50',
            'golongan_darah' => 'nullable|string|max:5',
            'kewarganegaraan' => 'nullable|string|max:100',
            'suku' => 'nullable|string|max:100',
            'bahasa' => 'nullable|string|max:100',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'nama_pasangan' => 'nullable|string|max:255',
            'kontak_darurat_nama' => 'nullable|string|max:255',
            'kontak_darurat_hubungan' => 'nullable|string|max:100',
            'kontak_darurat_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'penanggung' => 'nullable|string|max:100',
            'asuransi_id' => 'nullable|integer',
            'no_asuransi' => 'nullable|string|max:100',
        ]);

        // Create the new Pasien
        $pasien = Pasien::create(array_merge($request->all(), [
            'inserted_user' => auth()->id(),
            'updated_user' => auth()->id(),
        ]));

        // Generate no_rekam_medis based on the new Pasien ID
        $pasien->no_rekam_medis = str_pad($pasien->id, 9, '0', STR_PAD_LEFT);
        $pasien->save();

        return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $asuransis = DB::select('select * from asuransi where deleted_at is null');
        $pasien = Pasien::findOrFail($id);
        return view('admin.pasien.edit', compact('pasien', 'asuransis'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

          if (!empty($request->nik)) {
        $cekNik = Pasien::whereNull('deleted_at')
            ->where('nik', $request->nik)
            ->exists();

        if ($cekNik) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'NIK sudah digunakan.');
        }
    }
        
        $request->validate([
            'nik' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'status_pernikahan' => 'nullable|string|max:50',
            'golongan_darah' => 'nullable|string|max:5',
            'kewarganegaraan' => 'nullable|string|max:100',
            'suku' => 'nullable|string|max:100',
            'bahasa' => 'nullable|string|max:100',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'nama_pasangan' => 'nullable|string|max:255',
            'kontak_darurat_nama' => 'nullable|string|max:255',
            'kontak_darurat_hubungan' => 'nullable|string|max:100',
            'kontak_darurat_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'penanggung' => 'nullable|string|max:100',
            'asuransi_id' => 'nullable|integer',
            'no_asuransi' => 'nullable|string|max:100',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update(array_merge($request->all(), [
            'updated_user' => auth()->id(),
        ]));

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

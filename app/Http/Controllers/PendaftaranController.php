<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


use App\Models\Pasien;


class PendaftaranController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::getAll(); // Mengambil semua data pendaftaran
        // dd($pendaftarans);
        return view('admin.pendaftaran.index', compact('pendaftarans')); // Mengirim data ke view
    }

    public function create(Request $request)
    {
        // Ambil pasien berdasarkan ID dari parameter (jika ada)
        $pasien = null;
        if ($request->has('pasien_id')) {
            $pasien = DB::table('pasiens')
                ->where('id', $request->input('pasien_id'))
                ->whereNull('deleted_at')
                ->first();
        }

        // Ambil data untuk dropdown
        $dokters = DB::table('dokters')
            ->join('poliklinik', 'poliklinik.dokter_id', '=', 'dokters.id')
            ->select('dokters.*', 'dokters.nama as dokter_nama', 'poliklinik.nama as nama_poli', 'poliklinik.id as poli_id')
            ->whereNull('dokters.deleted_at')
            ->whereNull('poliklinik.deleted_at')
            ->get();


        $polikliniks = DB::table('poliklinik')->get();
        $asuransis = DB::table('asuransi')->get();

        return view('admin.pendaftaran.create', compact('dokters', 'polikliniks', 'asuransis', 'pasien'));
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'pasien_id' => 'required|integer',
            'tanggal_daftar' => 'required|date',
            'dokter_id' => 'required|integer',
            'status' => 'required|string',
            'asuransi_id' => 'required|integer',
            'no_asuransi' => 'required|string',
        ]);

        // Ambil poli_id berdasarkan dokter_id
        $poli = DB::table('poliklinik')
            ->where('dokter_id', $request->dokter_id)
            ->whereNull('deleted_at')
            ->first();

        if (!$poli) {
            return back()->withErrors('Poli untuk dokter ini tidak ditemukan.');
        }

        // Siapkan data untuk disimpan
        $data = [
            'pasien_id' => $request->pasien_id,
            'tanggal_daftar' => $request->tanggal_daftar,
            'poli_id' => $poli->id, // didapat dari query
            'dokter_id' => $request->dokter_id,
            'status' => $request->status,
            'inserted_user' => auth()->id(),
            'updated_user' => auth()->id(),
            'id_asuransi' => $request->asuransi_id,
            'no_asuransi' => $request->no_asuransi,
        ];

        // Simpan ke database
        Pendaftaran::insert($data);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }


    public function edit($id)
{
    $id = Crypt::decrypt(payload: $id);

    $data = Pendaftaran::findById($id);

    if (!$data) {
        return redirect()->route('admin.pendaftaran.index')->withErrors('Data pendaftaran tidak ditemukan.');
    }

    // Ambil semua dokter + poliklinik terkait
    $dokters = DB::table('dokters')
        ->join('poliklinik', 'poliklinik.dokter_id', '=', 'dokters.id')
        ->select('dokters.*', 'dokters.nama as dokter_nama', 'poliklinik.nama as nama_poli', 'poliklinik.id as poli_id')
        ->whereNull('dokters.deleted_at')
        ->whereNull('poliklinik.deleted_at')
        ->get();

    $asuransis = DB::table('asuransi')->get();
    $pasien = DB::table('pasiens')->where('id', $data->pasien_id)->first();



    return view('admin.pendaftaran.edit', compact('data', 'dokters', 'asuransis','pasien'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'pasien_id' => 'required|integer',
        'tanggal_daftar' => 'required|date',
        'dokter_id' => 'required|integer',
        'status' => 'required|string',
        'asuransi_id' => 'required|integer',
        'no_asuransi' => 'required|string',
    ]);

    // Ambil poli_id berdasarkan dokter_id
    $poli = DB::table('poliklinik')
        ->where('dokter_id', $request->dokter_id)
        ->whereNull('deleted_at')
        ->first();

    if (!$poli) {
        return back()->withErrors('Poli untuk dokter ini tidak ditemukan.');
    }

    $data = [
        'pasien_id'     => $request->pasien_id,
        'tanggal_daftar'=> $request->tanggal_daftar,
        'poli_id'       => $poli->id,
        'dokter_id'     => $request->dokter_id,
        'status'        => $request->status,
        'updated_user'  => auth()->id(),
        'id_asuransi'   => $request->asuransi_id,
        'no_asuransi'   => $request->no_asuransi,
    ];

    Pendaftaran::updateById($id, $data);

    return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil diperbarui.');
}


    public function destroy($id)
    {
        // Hapus data pendaftaran berdasarkan ID
        Pendaftaran::deleteById($id);

        return redirect()->route('admin.pendaftaran.index')->with('error', 'Pendaftaran berhasil dihapus.');
    }


    public function cariPasien(Request $request)
    {
        $search = $request->input('search');
        $filterBy = $request->input('filter_by');

        $pasiens = collect(); // kosong, tapi tetap Collection

        if ($search && $filterBy) {
            $pasiens = DB::table('pasiens')
                ->where($filterBy, 'ILIKE', "%{$search}%")
                ->whereNull('deleted_at')
                ->get();
        }

        return view('admin.pendaftaran.cari_pasien', compact('pasiens'));
    }

    public function cancelRegis($id)
    {
        $id = Crypt::decrypt(payload: $id);
        $cancelRegis = Pendaftaran::cancelRegis($id);
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil dibatalkan.');
    }


}

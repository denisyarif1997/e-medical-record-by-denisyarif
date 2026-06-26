<?php

namespace App\Http\Controllers;

use App\Models\AsesmenPerawat;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AsesmenPerawatController extends Controller
{
    public function index(Request $request)
    {

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $data = AsesmenPerawat::getRegisAskep($tanggalAwal, $tanggalAkhir);
        // dd($data);
        return view('admin.asesmen_perawat.index', compact('data'));
    }

    public function createWithId($id)
    {
        $asesmen = AsesmenPerawat::where('id_regis', $id)->first();

        if ($asesmen) {
            return redirect()->route('admin.asesmen_perawat.edit', $asesmen->id);
        }

        $createAsesmen = AsesmenPerawat::findById($id); // Pastikan metode ini ada di model
        // dd($createAsesmen);
        return view('admin.asesmen_perawat.create', compact('createAsesmen'));
    }

    public function store(Request $request)
    {
        // Validation for standard nursing assessment
        $request->validate([
            'id_regis' => 'required|exists:pendaftaran,id',
            'tujuan_kunjungan' => 'required|string',
            'keluhan_utama' => 'required|string',
            'pemeriksaan_fisik' => 'nullable|string',
            
            // Objective / TTV
            'keadaan_umum' => 'required|string',
            'sistolik' => 'nullable|string',
            'diastolik' => 'nullable|string',
            'nadi' => 'nullable|string',
            'pernapasan' => 'nullable|string',
            'suhu' => 'nullable|string',
            'tinggi_badan' => 'nullable|string',
            'berat_badan' => 'nullable|string',
            'imt' => 'nullable|string',
            
            // Additional assessment data (will be stored in JSON)
            'riwayat_alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'status_psikososial' => 'nullable|string',
            'adl_status' => 'nullable|string',
            'jatuh_risiko' => 'nullable|string',
            'nyeri_skala' => 'nullable|string',
            'nyeri_kualitas' => 'nullable|string',
            'gizi_mst_1' => 'nullable|string',
            'gizi_mst_2' => 'nullable|string',
            'masalah_keperawatan' => 'nullable|array',
            'rencana_keperawatan' => 'nullable|string',
        ]);

        $asesmenData = $request->except(['_token', 'id_regis']);

        AsesmenPerawat::create([
            'id_regis' => $request->id_regis,
            'asesmen' => $asesmenData,
            'inserted_user' => Auth::id(),
        ]);

        return redirect()->route('admin.asesmen_perawat.index')->with('success', 'Asesmen Keperawatan berhasil disimpan');
    }

    public function edit($id)
    {
        $asesmen = AsesmenPerawat::findOrFail($id);
        
        // Ensure asesmen is decoded if it's a string (though cast 'array' should handle it)
        if (is_string($asesmen->asesmen)) {
            $asesmen->asesmen = json_decode($asesmen->asesmen, true);
        }

        $regis = DB::table('pendaftaran as p')
            ->leftJoin('pasiens as pas', 'p.pasien_id', '=', 'pas.id')
            ->leftJoin('tenaga_medis as d', 'p.dokter_id', '=', 'd.id')
            ->leftJoin('poliklinik as pol', 'p.poli_id', '=', 'pol.id')
            ->leftJoin('asuransi as a', 'p.id_asuransi', '=', 'a.id')
            ->select(
                'p.*',
                'pas.no_rekam_medis',
                'pas.nama as nama_pasien',
                'd.nama as nama_dokter',
                'pol.nama as nama_poli',
                'a.nama as nama_asuransi'
            )
            ->where('p.id', $asesmen->id_regis)
            ->first();

        return view('admin.asesmen_perawat.edit', compact('asesmen', 'regis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_regis' => 'required|exists:pendaftaran,id',
            'tujuan_kunjungan' => 'required|string',
            'keluhan_utama' => 'required|string',
            'pemeriksaan_fisik' => 'nullable|string',
            'keadaan_umum' => 'required|string',
            'sistolik' => 'nullable|string',
            'diastolik' => 'nullable|string',
            'nadi' => 'nullable|string',
            'pernapasan' => 'nullable|string',
            'suhu' => 'nullable|string',
            'tinggi_badan' => 'nullable|string',
            'berat_badan' => 'nullable|string',
            'imt' => 'nullable|string',
            'riwayat_alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'status_psikososial' => 'nullable|string',
            'adl_status' => 'nullable|string',
            'jatuh_risiko' => 'nullable|string',
            'nyeri_skala' => 'nullable|string',
            'nyeri_kualitas' => 'nullable|string',
            'gizi_mst_1' => 'nullable|string',
            'gizi_mst_2' => 'nullable|string',
            'masalah_keperawatan' => 'nullable|array',
            'rencana_keperawatan' => 'nullable|string',
        ]);

        $asesmen = AsesmenPerawat::findOrFail($id);
        $asesmenData = $request->except(['_token', '_method', 'id_regis']);

        $asesmen->update([
            'id_regis' => $request->id_regis,
            'asesmen' => $asesmenData,
            'updated_user' => Auth::id(),
        ]);

        return redirect()->route('admin.asesmen_perawat.index')->with('success', 'Asesmen Keperawatan berhasil diperbarui');
    }
}

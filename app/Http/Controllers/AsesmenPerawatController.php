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
    $request->validate([
        'id_regis' => 'required|exists:pendaftaran,id',
        'tujuan_kunjungan' => 'required|string',
        'keluhan_utama' => 'required|string',
        'keadaan_umum' => 'required|string',
        'sistolik' => 'required|string',
        'diastolik' => 'required|string',
        'nadi' => 'required|string',
        'pernapasan' => 'required|string',
        'suhu' => 'required|string',
        'tinggi_badan' => 'required|string',
        'berat_badan' => 'required|string',
        'imt' => 'required|string',
        'pemeriksaan_fisik' => 'nullable|string',
        // 'ttv' => 'nullable|array',
    ]);
// dd($request->all());
    AsesmenPerawat::create([
        'id_regis' => $request->id_regis,
        'asesmen' => [
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'keluhan_utama' => $request->keluhan_utama,
            'keadaan_umum' => $request->keadaan_umum,
            'sistolik' => $request->sistolik,
            'diastolik' => $request->diastolik,
            'nadi' => $request->nadi,
            'pernapasan' => $request->pernapasan,
            'suhu' => $request->suhu,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'imt' => $request->imt,
            'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
            // 'ttv' => $request->ttv,
        ],
        'inserted_user' => Auth::id(),
    ]);

    return redirect()->route('admin.asesmen_perawat.index')->with('success', 'Data berhasil disimpan');
}

    

    public function edit($id)
{
    // Ambil data asesmen perawat berdasarkan ID
    $asesmen = DB::table('asesmen_perawat')->where('id', $id)->first();
    // $asesmen->asesmen = json_decode($asesmen->asesmen, true);
    // dd(json_decode($asesmen->asesmen, true));

    // Ambil juga data registrasi terkait, jika perlu ditampilkan
    $regis = DB::table('pendaftaran as p')
        ->leftJoin('pasiens as pas', 'p.pasien_id', '=', 'pas.id')
        ->leftJoin('dokters as d', 'p.dokter_id', '=', 'd.id')
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
        
        // dd($asesmen);

    return view('admin.asesmen_perawat.edit', compact('asesmen', 'regis'));
}



    public function update(Request $request, $id)
{
    $request->validate([
        'id_regis' => 'required|exists:pendaftaran,id',
        'tujuan_kunjungan' => 'required|string',
        'keluhan_utama' => 'required|string',
        'keadaan_umum' => 'required|string',
        'sistolik' => 'required|string',
        'diastolik' => 'required|string',
        'nadi' => 'required|string',
        'pernapasan' => 'required|string',
        'suhu' => 'required|string',
        'tinggi_badan' => 'required|string',
        'berat_badan' => 'required|string',
        'imt' => 'required|string',
        'pemeriksaan_fisik' => 'required|string',
        'ttv' => 'nullable|array',
    ]);

    $asesmen = AsesmenPerawat::findOrFail($id);
    $asesmen->update([
        'id_regis' => $request->id_regis,
        'asesmen' => json_encode([
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'keluhan_utama' => $request->keluhan_utama,
            'keadaan_umum' => $request->keadaan_umum,
            'sistolik' => $request->sistolik,
            'diastolik' => $request->diastolik,
            'nadi' => $request->nadi,
            'pernapasan' => $request->pernapasan,
            'suhu' => $request->suhu,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'imt' => $request->imt,
            'pemeriksaan_fisik' => $request->pemeriksaan_fisik,
            'ttv' => $request->ttv,
        ]),
        'updated_user' => Auth::id(),
    ]);

    return redirect()->route('admin.asesmen_perawat.index')->with('success', 'Data berhasil diperbarui');
}

}

<?php

namespace App\Http\Controllers;

use App\Models\AsesmenMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenMedisController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $data = AsesmenMedis::getRegisAsmed($tanggalAwal, $tanggalAkhir);
        return view('admin.asesmen_medis.index', compact('data'));
    }

    public function createWithId($id)
    {
        $asesmen = AsesmenMedis::where('id_regis', $id)->first();

        if ($asesmen) {
            return redirect()->route('admin.asesmen_medis.edit', $asesmen->id);
        }

        $createAsesmen = AsesmenMedis::findById($id);
        $diagnosas = DB::table('diagnosa')->orderBy('name')->limit(10)->get();

        // dd($diagnosas);
        return view('admin.asesmen_medis.create', compact('createAsesmen', 'diagnosas'));
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
            'ttv' => 'nullable|array',

            'jenis_diagnosa' => 'required|in:icd,non_icd',
            'diagnosa_icd_id' => 'required_if:jenis_diagnosa,icd|nullable|exists:diagnosa,id',
            'diagnosa_non_icd' => 'required_if:jenis_diagnosa,non_icd|nullable|string',
        ]);

        $diagnosa = null;
        if ($request->jenis_diagnosa == 'icd') {
            $diagnosaRecord = DB::table('diagnosa')->where('id', $request->diagnosa_icd_id)->first();
            $diagnosa = [
                'type' => 'icd',
                'id' => $diagnosaRecord->id,
                'code' => $diagnosaRecord->code,
                'name' => $diagnosaRecord->name,
            ];
        } else {
            $diagnosa = [
                'type' => 'non_icd',
                'name' => $request->diagnosa_non_icd,
            ];
        }


        AsesmenMedis::create([
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
                'diagnosa' => $diagnosa,
            ]),
            'inserted_user' => Auth::id(),
        ]);

        // dd($request->all());
        return redirect()->route('admin.asesmen_medis.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $asesmen = DB::table('asesmen_medis')->where('id', $id)->first();
        $asesmen->asesmen = json_decode($asesmen->asesmen, true);

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

        $diagnosas = DB::table('diagnosa')->orderBy('name')->get();

        return view('admin.asesmen_medis.create', compact('asesmen', 'regis', 'diagnosas'));
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

            'jenis_diagnosa' => 'required|in:icd,non_icd',
            'diagnosa_icd_id' => 'required_if:jenis_diagnosa,icd|nullable|exists:diagnosa,id',
            'diagnosa_non_icd' => 'required_if:jenis_diagnosa,non_icd|nullable|string',
        ]);

        $diagnosa = null;
        if ($request->jenis_diagnosa == 'icd') {
            $diagnosaRecord = DB::table('diagnosa')->where('id', $request->diagnosa_icd_id)->first();
            $diagnosa = [
                'type' => 'icd',
                'id' => $diagnosaRecord->id,
                'code' => $diagnosaRecord->code,
                'name' => $diagnosaRecord->name,
            ];
        } else {
            $diagnosa = [
                'type' => 'non_icd',
                'name' => $request->diagnosa_non_icd,
            ];
        }

        $asesmen = AsesmenMedis::findOrFail($id);
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
                'diagnosa' => $diagnosa,
            ]),
            'updated_user' => Auth::id(),
        ]);

        return redirect()->route('admin.asesmen_medis.index')->with('success', 'Data berhasil diperbarui');
    }

    public function search(Request $request)
{
    $term = $request->get('q');
    $results = DB::table('diagnosas')
        ->select('id', 'code', 'name')
        ->where('code', 'ILIKE', "%$term%")
        ->orWhere('name', 'ILIKE', "%$term%")
        ->limit(20)
        ->get();

    return response()->json($results);
}

}

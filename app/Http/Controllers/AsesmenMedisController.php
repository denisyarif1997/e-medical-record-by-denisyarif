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
        $diagnosas = DB::table('diagnosa')->orderBy('name')->limit(1)->get();

        return view('admin.asesmen_medis.create', compact('createAsesmen', 'diagnosas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_regis' => 'required|exists:pendaftaran,id',
            'keluhan_utama' => 'required|string',
            'rps' => 'nullable|string',
            'rpd' => 'nullable|string',
            'rpk' => 'nullable|string',
            'riwayat_alergi' => 'nullable|string',
            'keadaan_umum' => 'nullable|string',
            'status_lokalis' => 'nullable|string',
            'jenis_diagnosa' => 'required|in:icd,non_icd',
            'diagnosa_icd_id' => 'required_if:jenis_diagnosa,icd|nullable|exists:diagnosa,id',
            'diagnosa_non_icd' => 'required_if:jenis_diagnosa,non_icd|nullable|string',
            'diagnosa_sekunder' => 'nullable|string',
            'terapi' => 'nullable|string',
            'rencana_lanjutan' => 'nullable|string',
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
            'asesmen' => [
                'subjective' => [
                    'keluhan_utama' => $request->keluhan_utama,
                    'rps' => $request->rps,
                    'rpd' => $request->rpd,
                    'rpk' => $request->rpk,
                    'riwayat_alergi' => $request->riwayat_alergi,
                ],
                'objective' => [
                    'keadaan_umum' => $request->keadaan_umum,
                    'status_lokalis' => $request->status_lokalis,
                ],
                'assessment' => [
                    'diagnosa' => $diagnosa,
                    'is_icd' => $request->jenis_diagnosa == 'icd',
                    'diagnosa_sekunder' => $request->diagnosa_sekunder,
                ],
                'plan' => [
                    'terapi' => $request->terapi,
                    'rencana_lanjutan' => $request->rencana_lanjutan,
                ],
            ],
            'inserted_user' => Auth::id(),
        ]);

        return redirect()->route('admin.asesmen_medis.index')->with('success', 'Asesmen Medis berhasil disimpan');
    }

    public function edit($id)
    {
        $asesmen = AsesmenMedis::findOrFail($id);
        
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

        $nurse = DB::table('asesmen_perawat')->where('id_regis', $asesmen->id_regis)->first();
        if ($nurse) {
            $nurse->asesmen = json_decode($nurse->asesmen, true);
        }

        return view('admin.asesmen_medis.edit', compact('asesmen', 'regis', 'nurse'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_regis' => 'required|exists:pendaftaran,id',
            'keluhan_utama' => 'required|string',
            'rps' => 'nullable|string',
            'rpd' => 'nullable|string',
            'rpk' => 'nullable|string',
            'riwayat_alergi' => 'nullable|string',
            'keadaan_umum' => 'nullable|string',
            'status_lokalis' => 'nullable|string',
            'jenis_diagnosa' => 'required|in:icd,non_icd',
            'diagnosa_icd_id' => 'required_if:jenis_diagnosa,icd|nullable|exists:diagnosa,id',
            'diagnosa_non_icd' => 'required_if:jenis_diagnosa,non_icd|nullable|string',
            'diagnosa_sekunder' => 'nullable|string',
            'terapi' => 'nullable|string',
            'rencana_lanjutan' => 'nullable|string',
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
            'asesmen' => [
                'subjective' => [
                    'keluhan_utama' => $request->keluhan_utama,
                    'rps' => $request->rps,
                    'rpd' => $request->rpd,
                    'rpk' => $request->rpk,
                    'riwayat_alergi' => $request->riwayat_alergi,
                ],
                'objective' => [
                    'keadaan_umum' => $request->keadaan_umum,
                    'status_lokalis' => $request->status_lokalis,
                ],
                'assessment' => [
                    'diagnosa' => $diagnosa,
                    'is_icd' => $request->jenis_diagnosa == 'icd',
                    'diagnosa_sekunder' => $request->diagnosa_sekunder,
                ],
                'plan' => [
                    'terapi' => $request->terapi,
                    'rencana_lanjutan' => $request->rencana_lanjutan,
                ],
            ],
            'updated_user' => Auth::id(),
        ]);

        return redirect()->route('admin.asesmen_medis.index')->with('success', 'Asesmen Medis berhasil diperbarui');
    }

    public function search(Request $request)
    {
        $term = $request->get('q');
        $results = DB::table('diagnosa')
            ->select('id', 'code', 'name')
            ->where('code', 'LIKE', "%$term%")
            ->orWhere('name', 'LIKE', "%$term%")
            ->limit(20)
            ->get();

        return response()->json($results);
    }
}

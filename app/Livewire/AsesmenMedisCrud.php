<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AsesmenPerawat;


class AsesmenMedisCrud extends Component
{
    public $asesmen = [];
    public $data;
    public $id_regis;
    public $pasiens = [];
    public $obat = [];
    public $procedure = [];

    public function mount()
    {
        // Ambil data pasien yang belum dihapus dan status aktif
        $this->pasiens = DB::select("
           SELECT
    p.id AS id_regis,
    pas.no_rekam_medis,
    pas.nama AS nama_pasien,
    pol.nama AS nama_poli,
    d.nama AS nama_dokter,
    a.nama AS nama_asuransi,
    ap.id AS id_asesmen_perawat,
    ap.deleted_at AS deleted_at_perawat,
    am.id AS id_asesmen_medis,
    p.created_at as tanggal_regis,
    CASE 
        WHEN ap.id IS NOT NULL AND ap.deleted_at IS NULL AND am.id IS NULL THEN 'Sudah Asesmen Perawat - Belum Asesmen Medis'
        WHEN ap.id IS NULL OR ap.deleted_at IS NOT NULL THEN 'Belum Asesmen Perawat'
        WHEN am.id IS NOT NULL THEN 'Sudah Asesmen Medis'
        ELSE 'Status Tidak Diketahui'
    END AS status
FROM pendaftaran p
LEFT JOIN pasiens pas ON p.pasien_id = pas.id
LEFT JOIN poliklinik pol ON p.poli_id = pol.id
LEFT JOIN dokters d ON p.dokter_id = d.id
LEFT JOIN asuransi a ON p.id_asuransi = a.id
LEFT JOIN asesmen_perawat ap ON p.id = ap.id_regis
LEFT JOIN asesmen_medis am ON p.id = am.id_regis
WHERE p.deleted_at IS NULL AND p.status = '1'
ORDER BY p.created_at DESC
        ");
        // dd($this->pasiens);
    }

   public function selectPasien($id)
{
    $this->id_regis = $id;
    $this->obat = $asesmen['obat'] ?? [];
    $this->procedure = $asesmen['procedure'] ?? [];

    // Ambil data dari join asesmen_perawat + pendaftaran + pasien + dokter + dll
    $this->data = DB::table('asesmen_perawat AS ap')
        ->join('pendaftaran AS p', 'ap.id_regis', '=', 'p.id')
        ->join('pasiens AS pas', 'p.pasien_id', '=', 'pas.id')
        ->join('poliklinik AS pol', 'p.poli_id', '=', 'pol.id')
        ->join('dokters AS d', 'p.dokter_id', '=', 'd.id')
        ->leftJoin('asuransi AS a', 'p.id_asuransi', '=', 'a.id')
        ->leftJoin('asesmen_medis AS am', 'ap.id_regis', '=', 'am.id_regis')
        ->select(
            'p.id AS id_regis',
            'pas.nama AS nama_pasien',
            'pas.no_rekam_medis',
            'p.created_at AS tanggal_regis',
            'pol.nama AS nama_poli',
            'd.nama AS nama_dokter',
            'a.nama AS nama_asuransi',
             DB::raw("COALESCE(ap.asesmen::jsonb, am.asesmen::jsonb) AS asesmen"),
            'am.id AS id_asesmen_medis'
        )
        ->where('ap.id_regis', $id)
        ->whereNull('ap.deleted_at')
        ->first();
        // dd($this->data);

    // Decode json asesmen (dari asesmen medis jika ada, atau perawat jika tidak ada)
    if ($this->data && $this->data->asesmen) {
        $this->asesmen = json_decode($this->data->asesmen, true);
    }
}
    public function resetFields()
    {
        $this->id_regis = null;
        $this->asesmen = [];
        $this->obat = [];
        $this->procedure = [];
    }


    public function render()
    {
        // Data pasien untuk tabel
        $pasiens = DB::table('pendaftaran AS p')
            ->join('pasiens AS pas', 'p.pasien_id', '=', 'pas.id')
            ->join('poliklinik AS pol', 'p.poli_id', '=', 'pol.id')
            ->join('dokters AS d', 'p.dokter_id', '=', 'd.id')
            ->leftJoin('asuransi AS a', 'p.id_asuransi', '=', 'a.id')
            ->leftJoin('asesmen_perawat AS ap', function ($join) {
                $join->on('p.id', '=', 'ap.id_regis')->whereNull('ap.deleted_at');
            })
            ->leftJoin('asesmen_medis AS am', 'p.id', '=', 'am.id_regis')
            ->whereNull('p.deleted_at')
            ->where('p.status', 1)
            ->select(
                'p.id AS id_regis',
                'pas.nama AS nama_pasien',
                'pas.no_rekam_medis',
                'pol.nama AS nama_poli',
                'd.nama AS nama_dokter',
                'a.nama AS nama_asuransi',
                'p.created_at AS tanggal_regis',
                DB::raw("CASE
                    WHEN am.id IS NOT NULL THEN 'Sudah Asesmen Medis'
                    WHEN ap.id IS NOT NULL THEN 'Sudah Asesmen Perawat'
                    ELSE 'Belum Asesmen Perawat'
                END AS status")
            )
            ->orderByDesc('p.created_at')
            ->get();

        return view('livewire.asesmen-medis-crud', [
            'pasiens' => $pasiens,
        ]);
    }


    public function save()
{
    $this->validate([
        'id_regis' => 'required|numeric',
        'asesmen.keluhan_utama' => 'required|string|max:255',
        'asesmen.tujuan_kunjungan' => 'required|string|max:255',
    ]);

    $this->asesmen['obat'] = $this->obat;
    $this->asesmen['procedure'] = $this->procedure;

    // Cek apakah sudah ada data asesmen medis untuk id_regis
    $existing = DB::table('asesmen_medis')
        ->where('id_regis', $this->id_regis)
        ->first();

    if ($existing) {
        // Jika sudah ada, update
        DB::update("UPDATE asesmen_medis 
            SET asesmen = ?, updated_user = ?, updated_at = now()
            WHERE id_regis = ?", [
            json_encode($this->asesmen),
            Auth::id(),
            $this->id_regis
        ]);

        session()->flash('message', 'Asesmen berhasil diperbarui!');
    } else {
        // Jika belum ada, insert
        DB::insert("INSERT INTO asesmen_medis 
            (id_regis, asesmen, inserted_user, updated_user, created_at, updated_at) 
            VALUES (?, ?, ?, ?, now(), now())", [
            $this->id_regis,
            json_encode($this->asesmen),
            Auth::id(),
            Auth::id(),
        ]);

        session()->flash('message', 'Asesmen berhasil disimpan!');
    }

    // Reset form
    $this->reset(['asesmen', 'id_regis', 'obat', 'procedure']);
    $this->mount(); // Refresh daftar pasien
}


    public function tambahObat()
    {
        $this->obat[] = '';
    }

    public function hapusObat($index)
    {
        unset($this->obat[$index]);
        $this->obat = array_values($this->obat); // reset indeks
    }

    public function tambahTindakan()
    {
        $this->procedure[] = '';
    }

    public function hapusTindakan($index)
    {
        unset($this->procedure[$index]);
        $this->procedure = array_values($this->procedure); // reset indeks
    }
}

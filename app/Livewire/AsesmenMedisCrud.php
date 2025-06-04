<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AsesmenMedisCrud extends Component
{
    public $asesmen = [];
    public $data;
    public $id_regis;
    public $pasiens = [];
    public $obat = [];
    public $procedure = [];
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = $this->endDate = date('Y-m-d');
        $this->loadPasiens();
    }

    public function updatedStartDate() { $this->loadPasiens(); }
    public function updatedEndDate() { $this->loadPasiens(); }

    public function render()
    {
        return view('livewire.asesmen-medis-crud', [
            'pasiens' => $this->pasiens,
        ]);
    }

    public function loadPasiens()
    {
        $query = DB::table('pendaftaran AS p')
            ->join('pasiens AS pas', 'p.pasien_id', '=', 'pas.id')
            ->join('poliklinik AS pol', 'p.poli_id', '=', 'pol.id')
            ->join('dokters AS d', 'p.dokter_id', '=', 'd.id')
            ->leftJoin('asuransi AS a', 'p.id_asuransi', '=', 'a.id')
            ->leftJoin('asesmen_perawat AS ap', function ($join) {
                $join->on('p.id', '=', 'ap.id_regis')->whereNull('ap.deleted_at');
            })
            ->leftJoin('asesmen_medis AS am', 'p.id', '=', 'am.id_regis')
            ->whereNull('p.deleted_at')
            ->where('p.status', '1')
            ->when($this->startDate && $this->endDate, function ($q) {
                $q->whereBetween(DB::raw('DATE(p.created_at)'), [$this->startDate, $this->endDate]);
            })
            ->select(
                'p.id AS id_regis',
                'pas.no_rekam_medis',
                'pas.nama AS nama_pasien',
                'pol.nama AS nama_poli',
                'd.nama AS nama_dokter',
                'a.nama AS nama_asuransi',
                'p.created_at as tanggal_regis',
                DB::raw("CASE 
                    WHEN am.id IS NOT NULL THEN 'Sudah Asesmen Medis'
                    WHEN ap.id IS NOT NULL THEN 'Sudah Asesmen Perawat - Belum Asesmen Medis'
                    ELSE 'Belum Asesmen Perawat' END AS status")
            )
            ->orderByDesc('p.created_at');

        $this->pasiens = $query->get();
    }

    public function selectPasien($id)
    {
        $this->resetFields();
        $this->id_regis = $id;
    
        // Ambil data pendaftaran dan pasien
        $this->data = DB::selectOne("
            SELECT p.id AS id_regis, pas.nama AS nama_pasien, pas.no_rekam_medis,
                   pol.nama AS nama_poli, d.nama AS nama_dokter, a.nama AS nama_asuransi
            FROM pendaftaran p
            JOIN pasiens pas ON p.pasien_id = pas.id
            JOIN poliklinik pol ON p.poli_id = pol.id
            JOIN dokters d ON p.dokter_id = d.id
            LEFT JOIN asuransi a ON p.id_asuransi = a.id
            WHERE p.id = ? AND p.deleted_at IS NULL", [$id]);
    
        if (!$this->data) {
            $this->resetFields();
            session()->flash('message', 'Data pendaftaran tidak ditemukan.');
            return;
        }
    
        // Cek apakah sudah ada asesmen medis
        $medis = DB::selectOne("SELECT asesmen FROM asesmen_medis WHERE id_regis = ?", [$id]);
    
        if ($medis && $medis->asesmen) {
            $this->asesmen = json_decode($medis->asesmen, true) ?? [];
        } else {
            // Jika belum ada asesmen medis, ambil dari asesmen perawat (jika belum dihapus)
            $perawat = DB::selectOne("SELECT asesmen FROM asesmen_perawat WHERE id_regis = ? AND deleted_at IS NULL", [$id]);
    
            if ($perawat && $perawat->asesmen) {
                $this->asesmen = json_decode($perawat->asesmen, true) ?? [];
            }
        }
    
        // Ambil obat dan tindakan jika ada
        $this->obat = $this->asesmen['obat'] ?? [];
        $this->procedure = $this->asesmen['procedure'] ?? [];
        // dd($this->asesmen);
    }
    
    


    private function loadAsesmenData($id)
    {
        $this->asesmen = [];

        $medis = DB::selectOne("SELECT asesmen FROM asesmen_medis WHERE id_regis = ?", [$id]);
        if ($medis && $data = json_decode($medis->asesmen, true)) {
            $this->asesmen = $data;
            return;
        }

        $perawat = DB::selectOne("SELECT asesmen FROM asesmen_perawat WHERE id_regis = ? AND deleted_at IS NULL", [$id]);
        if ($perawat && $data = json_decode($perawat->asesmen, true)) {
            $this->asesmen = $data;
        }
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

        $exists = DB::table('asesmen_medis')->where('id_regis', $this->id_regis)->exists();

        if ($exists) {
            DB::update("UPDATE asesmen_medis SET asesmen = ?, updated_user = ?, updated_at = NOW() 
                WHERE id_regis = ?", [
                json_encode($this->asesmen),
                Auth::id(),
                $this->id_regis
            ]);
            session()->flash('message', 'Asesmen diperbarui!');
        } else {
            DB::insert("INSERT INTO asesmen_medis (id_regis, asesmen, inserted_user, updated_user, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())", [
                $this->id_regis,
                json_encode($this->asesmen),
                Auth::id(),
                Auth::id(),
            ]);
            session()->flash('message', 'Asesmen disimpan!');
        }

        $this->resetFields();
        $this->loadPasiens();
    }

    public function resetFields()
    {
        $this->id_regis = null;
        $this->asesmen = [];
        $this->obat = [];
        $this->procedure = [];
    }

    public function tambahObat() { $this->obat[] = ''; }
    public function hapusObat($i) { unset($this->obat[$i]); $this->obat = array_values($this->obat); }

    public function tambahTindakan() { $this->procedure[] = ''; }
    public function hapusTindakan($i) { unset($this->procedure[$i]); $this->procedure = array_values($this->procedure); }
}

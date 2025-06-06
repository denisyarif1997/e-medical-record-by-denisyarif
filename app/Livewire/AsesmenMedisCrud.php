<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Diagnosas;
use App\Models\Obat;

class AsesmenMedisCrud extends Component
{
    public $asesmen = [];
    public $data;
    public $id_regis;
    public $pasiens = [];
    public $obat = [];
    public $procedure = [];
    public $diagnosa = [];
    public $diagnosaResults = [];
    public $diagnosaSearch = [];
    public $startDate;
    public $endDate;
    public $searchObat = [];

    public function mount()
    {
        $this->startDate = $this->endDate = date('Y-m-d');
        $this->loadPasiens();
        $this->obat = [];
        $this->diagnosa = [['type' => 'icd', 'icd' => null, 'non_icd' => '']];
        $this->diagnosaSearch = [''];
    }

    public function updatedStartDate()
    {
        $this->loadPasiens();
    }
    public function updatedEndDate()
    {
        $this->loadPasiens();
    }

    public function render()
    {
        return view('livewire.asesmen-medis-crud', [
            'pasiens' => $this->pasiens,
        ]);
    }

    public function loadPasiens()
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $sql = "
           SELECT
    p.id AS id_regis,
    pas.no_rekam_medis,
    pas.nama AS nama_pasien,
    ap.asesmen AS asesmen_perawat,
    pol.nama AS nama_poli,
    d.nama AS nama_dokter,
    a.nama AS nama_asuransi,
    p.created_at AS tanggal_regis,
    CASE
        WHEN am2.deleted_at IS NOT NULL THEN 'Sudah Asesmen Perawat - Belum Asesmen Medis'
        WHEN am.id IS NOT NULL THEN 'Sudah Asesmen Medis'
        WHEN ap.id IS NOT NULL THEN 'Sudah Asesmen Perawat - Belum Asesmen Medis'
        ELSE 'Belum Asesmen Perawat'
    END AS status
FROM
    pendaftaran p
JOIN pasiens pas ON
    p.pasien_id = pas.id
JOIN poliklinik pol ON
    p.poli_id = pol.id
JOIN dokters d ON
    p.dokter_id = d.id
LEFT JOIN asuransi a ON
    p.id_asuransi = a.id
LEFT JOIN asesmen_perawat ap ON
    p.id = ap.id_regis
    AND ap.deleted_at IS NULL
LEFT JOIN asesmen_medis am ON
    p.id = am.id_regis AND am.deleted_at IS NULL
LEFT JOIN asesmen_medis am2 ON
    am2.id_regis = p.id
WHERE
    p.deleted_at IS NULL
                AND p.status = '1'
                " . ($startDate && $endDate ? "AND DATE(p.created_at) BETWEEN ? AND ?" : "") . "
            ORDER BY p.created_at DESC
        ";

        $bindings = $startDate && $endDate ? [$startDate, $endDate] : [];

        $this->pasiens = DB::select($sql, $bindings);
        // dd($this->pasiens);
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
        $this->diagnosa = $this->asesmen['diagnosa'] ?? [['type' => 'icd', 'icd' => null, 'non_icd' => '']];

        // Sync search array
        $this->diagnosaSearch = array_map(function ($d) {
            return ($d['type'] == 'icd' && !empty($d['icd'])) ? $d['icd']['code'] . ' - ' . $d['icd']['name'] : $d['non_icd'];
        }, $this->diagnosa);
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
            'obat.*.qty' => 'required|integer|min:1',
        ], [
            'obat.*.qty.min' => 'Qty minimal 1',
        ]);

        $this->asesmen['obat'] = $this->obat;
        $this->asesmen['procedure'] = $this->procedure;
        $this->asesmen['diagnosa'] = $this->diagnosa;

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
        $this->diagnosa = [['type' => 'icd', 'icd' => null, 'non_icd' => '']];
        $this->diagnosaSearch = [''];
        $this->diagnosaResults = [];
    }

    public function tambahObat()
    {
        $this->obat[] = [
            'nama' => '',
            'signa' => '',
            'cara_pakai' => '',
            'qty' => 1,
        ];
    }
    
    public function updatedObat($value, $name)
    {
        // Dikosongkan, kita akan memanggil searchObat secara langsung dari view
    }

    public function searchObat($index, $query)
    {
        if (strlen($query) < 2) {
            $this->searchObat[$index] = [];
            return;
        }

        $this->searchObat[$index] = Obat::where('nama_obat', 'ILIKE', "%{$query}%")
            ->limit(10)
            ->pluck('nama_obat')
            ->toArray();
    }

    public function selectObat($index, $nama)
    {
        $this->obat[$index]['nama'] = $nama;
        $this->searchObat[$index] = [];
    }

    public function searchNamaObat($index, $query)
    {
        // Dikosongkan agar tidak ada pencarian otomatis
    }

    public function hapusObat($i)
    {
        unset($this->obat[$i]);
        $this->obat = array_values($this->obat);
        // Hapus baris kosong di akhir jika ada (dan lebih dari 1 baris)
        while (count($this->obat) > 1 && empty($this->obat[count($this->obat) - 1]['nama'])) {
            array_pop($this->obat);
        }
    }

    public function tambahTindakan()
    {
        $this->procedure[] = '';
    }
    public function hapusTindakan($i)
    {
        unset($this->procedure[$i]);
        $this->procedure = array_values($this->procedure);
    }

    public function tambahDiagnosa()
    {
        $this->diagnosa[] = ['type' => 'icd', 'icd' => null, 'non_icd' => ''];
        $this->diagnosaSearch[] = '';
    }

    public function hapusDiagnosa($index)
    {
        unset($this->diagnosa[$index]);
        $this->diagnosa = array_values($this->diagnosa);
        
        unset($this->diagnosaSearch[$index]);
        $this->diagnosaSearch = array_values($this->diagnosaSearch);
        
        if (isset($this->diagnosaResults[$index])) {
            unset($this->diagnosaResults[$index]);
            $this->diagnosaResults = array_values($this->diagnosaResults);
        }
    }

    public function searchDiagnosa($index)
    {
        if (strlen($this->diagnosaSearch[$index] ?? '') < 2) {
            $this->diagnosaResults[$index] = [];
            return;
        }

        $searchTerm = "%{$this->diagnosaSearch[$index]}%";
        $this->diagnosaResults[$index] = DB::select(
            "SELECT code, name FROM diagnosa WHERE code ILIKE ? OR name ILIKE ? LIMIT 10",
            [$searchTerm, $searchTerm]
        );
    }

    public function updatedDiagnosaSearch($query)
    {
        // Dikosongkan agar tidak ada pencarian otomatis
    }

    public function selectIcdDiagnosa($index, $code, $name)
    {
        $this->diagnosa[$index]['icd'] = ['code' => $code, 'name' => $name];
        $this->diagnosaSearch[$index] = "$code - $name";
        $this->diagnosaResults[$index] = [];
    }
}


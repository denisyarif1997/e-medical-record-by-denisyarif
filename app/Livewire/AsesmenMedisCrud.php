<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Obat;

class AsesmenMedisCrud extends Component
{
    public $asesmen = [];
    public $data;
    public $id_regis;
    public $pasiens = [];
    public $nurseData = [];
    
    // Prescription Properties
    public $resep_jadi = [];
    public $resep_racik = [];
    
    public $procedure = [];
    public $diagnosa = [];
    public $diagnosaResults = [];
    public $diagnosaSearch = [];
    public $startDate;
    public $endDate;
    
    // Search Results
    public $searchObatJadi = [];
    public $searchObatRacik = []; // [racikIndex => [komponenIndex => [results]]]

    public function mount()
    {
        $this->startDate = $this->endDate = date('Y-m-d');
        $this->loadPasiens();
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
        return view('livewire.asesmen-medis-crud');
    }

public function loadPasiens()
{
    $this->pasiens = [];
    $startDate = $this->startDate;
    $endDate = $this->endDate;

    if ($startDate && $endDate && $endDate < $startDate) {
        $endDate = $startDate;
        $this->endDate = $startDate;
    }

    $whereDate = '';
    $bindings = [];

    if ($startDate && $endDate) {
        $whereDate = "AND p.created_at::date BETWEEN ? AND ?";
        $bindings = [$startDate, $endDate];
    } elseif ($startDate) {
        $whereDate = "AND p.created_at::date >= ?";
        $bindings = [$startDate];
    } elseif ($endDate) {
        $whereDate = "AND p.created_at::date <= ?";
        $bindings = [$endDate];
    }

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
                WHEN am.id IS NOT NULL THEN 'Sudah Asesmen Medis'
                WHEN ap.id IS NOT NULL THEN 'Sudah Asesmen Perawat - Belum Asesmen Medis'
                ELSE 'Belum Asesmen Perawat'
            END AS status
        FROM
            pendaftaran p
        JOIN pasiens pas ON p.pasien_id = pas.id
        JOIN poliklinik pol ON p.poli_id = pol.id
        JOIN tenaga_medis d ON p.dokter_id = d.id
        LEFT JOIN asuransi a ON p.id_asuransi = a.id
        LEFT JOIN asesmen_perawat ap ON p.id = ap.id_regis AND ap.deleted_at IS NULL
        LEFT JOIN asesmen_medis am ON p.id = am.id_regis AND am.deleted_at IS NULL
        WHERE
            p.deleted_at IS NULL
            AND p.status = '1'
            {$whereDate}
        ORDER BY p.created_at DESC
    ";

    $this->pasiens = DB::select($sql, $bindings);
}
    public function selectPasien($id)
    {
        $this->resetFields();
        $this->id_regis = $id;

        $this->data = DB::selectOne("
            SELECT p.id AS id_regis, pas.nama AS nama_pasien, pas.no_rekam_medis,
                   pol.nama AS nama_poli, d.nama AS nama_dokter, a.nama AS nama_asuransi
            FROM pendaftaran p
            JOIN pasiens pas ON p.pasien_id = pas.id
            JOIN poliklinik pol ON p.poli_id = pol.id
            JOIN tenaga_medis d ON p.dokter_id = d.id
            LEFT JOIN asuransi a ON p.id_asuransi = a.id
            WHERE p.id = ? AND p.deleted_at IS NULL", [$id]);

        $perawat = DB::selectOne("SELECT asesmen FROM asesmen_perawat WHERE id_regis = ? AND deleted_at IS NULL", [$id]);
        if ($perawat && $perawat->asesmen) {
            $this->nurseData = json_decode($perawat->asesmen, true) ?? [];
        }

        $medis = DB::selectOne("SELECT asesmen FROM asesmen_medis WHERE id_regis = ? AND deleted_at IS NULL", [$id]);
        if ($medis && $medis->asesmen) {
            $this->asesmen = json_decode($medis->asesmen, true) ?? [];
        } else {
            $this->asesmen = [
                'subjective' => [
                    'keluhan_utama' => $this->nurseData['keluhan_utama'] ?? '',
                    'rps' => '', 'rpd' => '', 'rpk' => '',
                    'riwayat_alergi' => $this->nurseData['riwayat_alergi'] ?? '',
                ],
                'objective' => ['status_lokalis' => '', 'keadaan_umum' => $this->nurseData['keadaan_umum'] ?? ''],
                'assessment' => ['diagnosa_sekunder' => ''],
                'plan' => ['terapi' => '', 'rencana_lanjutan' => ''],
            ];
        }

        $this->resep_jadi = $this->asesmen['resep_jadi'] ?? [];
        $this->resep_racik = $this->asesmen['resep_racik'] ?? [];
        $this->procedure = $this->asesmen['procedure'] ?? [];
        $this->diagnosa = $this->asesmen['diagnosa'] ?? [['type' => 'icd', 'icd' => null, 'non_icd' => '']];

        $this->diagnosaSearch = array_map(function ($d) {
            return ($d['type'] == 'icd' && !empty($d['icd'])) ? $d['icd']['code'] . ' - ' . $d['icd']['name'] : ($d['non_icd'] ?? '');
        }, $this->diagnosa);
    }

    public function save()
    {
        $this->validate([
            'id_regis' => 'required|numeric',
            'asesmen.subjective.keluhan_utama' => 'required|string|max:255',
            'diagnosa.0.icd' => 'required_if:diagnosa.0.type,icd',
            'diagnosa.0.non_icd' => 'required_if:diagnosa.0.type,non_icd|string|min:1',
        ]);

        $this->asesmen['resep_jadi'] = $this->resep_jadi;
        $this->asesmen['resep_racik'] = $this->resep_racik;
        $this->asesmen['procedure'] = $this->procedure;
        $this->asesmen['diagnosa'] = $this->diagnosa;

        $exists = DB::table('asesmen_medis')->where('id_regis', $this->id_regis)->whereNull('deleted_at')->exists();

        if ($exists) {
            DB::update("UPDATE asesmen_medis SET asesmen = ?, updated_user = ?, updated_at = NOW() WHERE id_regis = ?", [
                json_encode($this->asesmen), Auth::id(), $this->id_regis
            ]);
            session()->flash('message', 'Asesmen Medis diperbarui!');
        } else {
            DB::insert("INSERT INTO asesmen_medis (id_regis, asesmen, inserted_user, updated_user, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())", [
                $this->id_regis, json_encode($this->asesmen), Auth::id(), Auth::id(),
            ]);
            session()->flash('message', 'Asesmen Medis disimpan!');
        }

        $this->resetFields();
        $this->loadPasiens();
    }

    public function resetFields()
    {
        $this->id_regis = null;
        $this->asesmen = [];
        $this->nurseData = [];
        $this->resep_jadi = [];
        $this->resep_racik = [];
        $this->procedure = [];
        $this->diagnosa = [['type' => 'icd', 'icd' => null, 'non_icd' => '']];
        $this->diagnosaSearch = [''];
        $this->diagnosaResults = [];
        $this->searchObatJadi = [];
    }

    // --- Resep Obat Jadi ---
    public function tambahResepJadi()
    {
        $this->resep_jadi[] = ['obat_id' => '', 'nama_obat' => '', 'signa' => '', 'qty' => 1];
    }
    
    public function hapusResepJadi($index)
    {
        unset($this->resep_jadi[$index]);
        $this->resep_jadi = array_values($this->resep_jadi);
    }

    public function searchingObatJadi($index, $query)
    {
        if (strlen($query) < 2) {
            $this->searchObatJadi[$index] = [];
            return;
        }
        $this->searchObatJadi[$index] = DB::select("SELECT id, nama_obat FROM master_obat WHERE nama_obat ILIKE ? AND deleted_at IS NULL LIMIT 10", ["%{$query}%"]);
    }

    public function selectObatJadi($index, $id, $nama)
    {
        $this->resep_jadi[$index]['obat_id'] = $id;
        $this->resep_jadi[$index]['nama_obat'] = $nama;
        $this->searchObatJadi[$index] = [];
    }

    // --- Resep Obat Racik ---
    public function tambahResepRacik()
    {
        $this->resep_racik[] = [
            'nama_racikan' => '',
            'sediaan' => 'Pulveres',
            'signa' => '',
            'qty' => 1,
            'komponen' => [
                ['obat_id' => '', 'nama_obat' => '', 'dosis' => '']
            ]
        ];
    }

    public function hapusResepRacik($index)
    {
        unset($this->resep_racik[$index]);
        $this->resep_racik = array_values($this->resep_racik);
    }

    public function tambahKomponenRacik($racikIndex)
    {
        $this->resep_racik[$racikIndex]['komponen'][] = ['obat_id' => '', 'nama_obat' => '', 'dosis' => ''];
    }

    public function hapusKomponenRacik($racikIndex, $kompIndex)
    {
        unset($this->resep_racik[$racikIndex]['komponen'][$kompIndex]);
        $this->resep_racik[$racikIndex]['komponen'] = array_values($this->resep_racik[$racikIndex]['komponen']);
    }

    public function searchingObatRacik($racikIndex, $kompIndex, $query)
    {
        if (strlen($query) < 2) {
            $this->searchObatRacik[$racikIndex][$kompIndex] = [];
            return;
        }
        $this->searchObatRacik[$racikIndex][$kompIndex] = DB::select("SELECT id, nama_obat FROM master_obat WHERE nama_obat ILIKE ? AND deleted_at IS NULL LIMIT 10", ["%{$query}%"]);
    }

    public function selectObatRacik($racikIndex, $kompIndex, $id, $nama)
    {
        $this->resep_racik[$racikIndex]['komponen'][$kompIndex]['obat_id'] = $id;
        $this->resep_racik[$racikIndex]['komponen'][$kompIndex]['nama_obat'] = $nama;
        $this->searchObatRacik[$racikIndex][$kompIndex] = [];
    }

    // --- Other Methods ---
    public function tambahTindakan() { $this->procedure[] = ''; }
    public function hapusTindakan($i) { unset($this->procedure[$i]); $this->procedure = array_values($this->procedure); }
    public function tambahDiagnosa() { $this->diagnosa[] = ['type' => 'icd', 'icd' => null, 'non_icd' => '']; $this->diagnosaSearch[] = ''; }
    public function hapusDiagnosa($index) { unset($this->diagnosa[$index]); $this->diagnosa = array_values($this->diagnosa); unset($this->diagnosaSearch[$index]); $this->diagnosaSearch = array_values($this->diagnosaSearch); }
    public function searchDiagnosa($index) {
        if (strlen($this->diagnosaSearch[$index] ?? '') < 2) { $this->diagnosaResults[$index] = []; return; }
        $searchTerm = "%{$this->diagnosaSearch[$index]}%";
        $this->diagnosaResults[$index] = DB::select("SELECT id, code, name FROM diagnosa WHERE code ILIKE ? OR name ILIKE ? LIMIT 10", [$searchTerm, $searchTerm]);
    }
    public function selectIcdDiagnosa($index, $id, $code, $name) {
        $this->diagnosa[$index]['icd'] = ['id' => $id, 'code' => $code, 'name' => $name];
        $this->diagnosaSearch[$index] = "$code - $name";
        $this->diagnosaResults[$index] = [];
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TelaahFarmasi extends Component
{
    public $pasiens = [];
    public $id_regis;
    public $data;
    public $medicalData = [];
    public $telaah = [
        'adm' => ['identitas' => false, 'berat_badan' => false, 'nama_dokter' => false, 'tanggal' => false],
        'pharm' => ['bentuk' => false, 'dosis' => false, 'stabilitas' => false, 'rute' => false],
        'clinical' => ['indikasi' => false, 'interaksi' => false, 'alergi' => false, 'duplikasi' => false]
    ];
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = $this->endDate = date('Y-m-d');
        $this->loadPasiens();
    }

    public function loadPasiens()
    {
        $sql = "
            SELECT p.id AS id_regis, pas.no_rekam_medis, pas.nama AS nama_pasien,
                   am.asesmen, p.created_at
            FROM pendaftaran p
            JOIN pasiens pas ON p.pasien_id = pas.id
            JOIN asesmen_medis am ON p.id = am.id_regis
            WHERE am.deleted_at IS NULL
            AND p.deleted_at IS NULL
            AND DATE(p.created_at) BETWEEN ? AND ?
            ORDER BY p.created_at DESC
        ";
        $this->pasiens = DB::select($sql, [$this->startDate, $this->endDate]);
    }

    public function selectPasien($id)
    {
        $this->id_regis = $id;
        $this->data = DB::selectOne("
            SELECT p.id AS id_regis, pas.nama AS nama_pasien, pas.no_rekam_medis,
                   pol.nama AS nama_poli, d.nama AS nama_dokter
            FROM pendaftaran p
            JOIN pasiens pas ON p.pasien_id = pas.id
            JOIN poliklinik pol ON p.poli_id = pol.id
            JOIN tenaga_medis d ON p.dokter_id = d.id
            WHERE p.id = ?", [$id]);

        $medis = DB::selectOne("SELECT asesmen FROM asesmen_medis WHERE id_regis = ?", [$id]);
        $this->medicalData = json_decode($medis->asesmen, true) ?? [];
        
        // Load existing telaah if exists (we'll store it in am.asesmen['telaah_farmasi'])
        $this->telaah = $this->medicalData['telaah_farmasi'] ?? [
            'adm' => ['identitas' => false, 'berat_badan' => false, 'nama_dokter' => false, 'tanggal' => false],
            'pharm' => ['bentuk' => false, 'dosis' => false, 'stabilitas' => false, 'rute' => false],
            'clinical' => ['indikasi' => false, 'interaksi' => false, 'alergi' => false, 'duplikasi' => false]
        ];
    }

    public function save()
    {
        $this->medicalData['telaah_farmasi'] = $this->telaah;
        $this->medicalData['telaah_farmasi_user'] = Auth::id();
        $this->medicalData['telaah_farmasi_time'] = now();

        DB::update("UPDATE asesmen_medis SET asesmen = ? WHERE id_regis = ?", [
            json_encode($this->medicalData),
            $this->id_regis
        ]);

        session()->flash('message', 'Telaah Farmasi berhasil disimpan!');
        $this->id_regis = null;
        $this->loadPasiens();
    }

    public function render()
    {
        return view('livewire.telaah-farmasi');
    }
}

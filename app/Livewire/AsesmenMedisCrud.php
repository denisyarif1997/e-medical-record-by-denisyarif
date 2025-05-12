<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AsesmenMedisCrud extends Component
{
    public $asesmen = [];
    public $asesmen_id, $id_regis;
    public $pasiens = [];

    public function mount()
    {
        $this->pasiens = DB::select("
            SELECT p.id AS id_regis, pas.nama AS nama_pasien
            FROM pendaftaran p
            LEFT JOIN pasiens pas ON p.pasien_id = pas.id
            WHERE p.deleted_at IS NULL AND p.status = 1
            ORDER BY p.created_at DESC
        ");
    }

    public function selectPasien($id)
    {
        $this->id_regis = $id;
        $this->asesmen = [
            'tujuan_kunjungan' => '',
            'keluhan_utama' => '',
            'sistolik' => '',
            'diastolik' => '',
            'nadi' => '',
            'suhu' => '',
        ];
    }

    public function save()
    {
        $this->validate([
            'id_regis' => 'required',
            'asesmen.keluhan_utama' => 'required|string|max:255',
            'asesmen.tujuan_kunjungan' => 'required|string|max:255',
        ]);

        DB::insert("INSERT INTO asesmen_medis (id_regis, asesmen, inserted_user, updated_user) VALUES (?, ?, ?, ?)", [
            $this->id_regis,
            json_encode($this->asesmen),
            Auth::id(),
            Auth::id()
        ]);

        session()->flash('message', 'Asesmen berhasil disimpan!');
        $this->reset(['asesmen', 'id_regis']);
    }

    public function render()
    {
        return view('admin.asesmen_medis.index');
    }
}

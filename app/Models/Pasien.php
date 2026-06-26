<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use SoftDeletes;

    protected $table = 'pasiens';

    protected $fillable = [
        'no_rekam_medis',
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_pernikahan',
        'golongan_darah',
        'kewarganegaraan',
        'suku',
        'bahasa',
        'nama_ayah',
        'nama_ibu',
        'nama_pasangan',
        'kontak_darurat_nama',
        'kontak_darurat_hubungan',
        'kontak_darurat_hp',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'no_hp',
        'email',
        'penanggung',
        'no_asuransi',
        'asuransi_id',
        'inserted_user',
        'updated_user',
    ];

    protected $dates = [
        'tanggal_lahir',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // public function asuransi()
    // {
    //     return $this->belongsTo(Asuransi::class, 'asuransi_id');
    // }
}

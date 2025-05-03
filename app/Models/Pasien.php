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
        'alamat',
        'no_hp',
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

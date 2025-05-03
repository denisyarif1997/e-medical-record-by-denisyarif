<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    // Tentukan nama tabel (jika berbeda dari nama model yang sudah diubah menjadi plural otomatis)
    protected $table = 'dokters';


    

    // Tentukan kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama',
        'spec_code',
        'no_hp',
        'inserted_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Tentukan tipe data untuk kolom timestamp (jika menggunakan soft delete)
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Jika kamu ingin menggunakan soft delete, aktifkan fitur soft delete
    use \Illuminate\Database\Eloquent\SoftDeletes;
}

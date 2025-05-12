<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisHarga extends Model
{
    use HasFactory,SoftDeletes;

     protected $table = 'jenis_harga'; // <- tambahkan ini

     protected $fillable = [
        'nama', 'keterangan', 
        'inserted_user', 'updated_user', 'deleted_user'
    ];

   
}

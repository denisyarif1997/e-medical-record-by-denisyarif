<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poliklinik extends Model
{
    use SoftDeletes;

    protected $table = 'poliklinik';

    protected $fillable = [
        'nama',
        'dokter_id',
        'waktu_mulai',
        'waktu_selesai',
        'hari',
        'created_user',
    ];

    protected $dates = ['deleted_at'];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_user');
    }
}

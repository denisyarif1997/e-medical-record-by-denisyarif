<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenagaMedis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tenaga_medis';

    protected $fillable = [
        'nama',
        'type',
        'spec_code',
        'no_hp',
        'inserted_user',
        'updated_user',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
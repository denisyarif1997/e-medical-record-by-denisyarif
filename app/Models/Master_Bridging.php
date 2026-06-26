<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Master_Bridging extends Model
{
    use HasFactory;

    protected $table = 'master_bridgings';

    protected $fillable = [
        'jenis_bridging',
        'tipe_url',
        'url',
        'constid',
        'secret_key',
        'user_key',
        'token',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
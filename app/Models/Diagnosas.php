<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Diagnosas extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'diagnosa'; // <- tambahkan ini

     protected $fillable = [
        'code', 'name', 'description',
        // 'inserted_user', 'updated_user', 'deleted_user'
    ];
}

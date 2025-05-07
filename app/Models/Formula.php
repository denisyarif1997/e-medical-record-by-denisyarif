<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Formula extends Model
{
use SoftDeletes;

    protected $table = 'formula';


    protected $fillable = [
        'id', 'nama', 'keterangan', 'faktor'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public static function getAll()
{
    return DB::table('formula')->whereNull('deleted_at')->get();
}
    public function getById($id)
{
    return DB::table('formula')->where('id', $id)->whereNull('deleted_at')->first();
}


}
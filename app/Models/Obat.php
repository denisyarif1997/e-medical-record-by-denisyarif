<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'master_obat';

    protected $fillable = [
        'kode_obat', 
        'nama_obat', 
        'bentuk_sediaan', 
        'golongan', 
        'kategori', 
        'formula_id', 
        'stok', 
        'satuan', 
        'harga_beli', 
        'status'
    ];

    // Relasi ke tabel formula (jika menggunakan formula_id sebagai foreign key)
    public static function getWithFormula()
{
    return DB::select("
        SELECT * FROM formula where deleted_at is null
    ");
}



    // Menghitung harga jual dengan raw SQL berdasarkan harga beli dan faktor formula
    public static function getHargaJual($id)
    {
        return DB::table('master_obat as m')
            ->join('formula as f', 'm.formula_id', '=', 'f.id')
            ->where('m.id', $id)
            ->select('m.harga_beli', 'f.faktor', DB::raw('m.harga_beli * f.faktor as harga_jual'))
            ->first();
    }

    public static function getAll()
    {
        return DB::select("
            SELECT 
                m.*, 
                f.nama AS nama_formula,
                f.faktor,
                (m.harga_beli * f.faktor) AS harga_jual
            FROM master_obat m
            LEFT JOIN formula f ON m.formula_id = f.id
            WHERE m.deleted_at IS NULL
            ORDER BY m.id DESC
        ");
    }
    

    public static function insert($data)
    {
        DB::insert("
            INSERT INTO master_obat (nama_obat, kode_obat, bentuk_sediaan, golongan, kategori, satuan, harga_beli, formula_id, inserted_user, updated_user, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['nama_obat'],
            $data['kode_obat'],
            $data['bentuk_sediaan'],
            $data['golongan'],
            $data['kategori'],
            $data['satuan'],
            $data['harga_beli'],
            $data['formula_id'],
            $data['inserted_user'],
            $data['updated_user'],
        ]);
    }
    public static function findById($id)
    {
    $result = DB::select("
        SELECT 
            mo.*, 
            f.nama AS formula_name
        FROM master_obat mo
        LEFT JOIN formula f ON mo.formula_id = f.id
        WHERE mo.id = ?
    ", [$id]);

    return $result ? $result[0] : null;
    }

    public static function updateById($id, $data)
{
    DB::update("
    UPDATE master_obat
    SET 
        nama_obat = ?, 
        formula_id = ?, 
        harga_beli = ?, 
        stok = ?, 
        bentuk_sediaan = ?,
        golongan = ?,
        kategori = ?,
        updated_user = ?, 
        updated_at = NOW()
    WHERE id = ?
", [
    $data['nama_obat'],
    $data['formula_id'],
    $data['harga_beli'],
    $data['stok'],
    $data['bentuk_sediaan'],
    $data['golongan'],
    $data['kategori'],
    $data['updated_user'],
    $id
]);

}

public static function deleteById($id)
{
    DB::delete("update master_obat set deleted_at = now() where id = ?", [$id]);
}



}
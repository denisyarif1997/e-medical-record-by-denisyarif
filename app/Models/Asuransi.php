<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Asuransi
{
    public static function getAll()
    {
        return DB::select("
            SELECT 
                a.*, 
                j.nama AS jenis_asuransi
            FROM asuransi a
            LEFT JOIN js_asuransi j ON a.jenis = j.id
            where a.deleted_at is null
            ORDER BY a.id DESC
        ");
    }

    public static function insert($data)
    {
        DB::insert("
            INSERT INTO asuransi (nama, no_tlp, jenis, deskripsi, inserted_user, updated_user, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $data['nama'],
            $data['no_tlp'],
            $data['jenis'],
            $data['deskripsi'],
            $data['inserted_user'],
            $data['updated_user'],
        ]);
    }

    public static function findById($id)
    {
        $result = DB::select("
            SELECT 
                a.*, 
                j.nama AS jenis_asuransi
            FROM asuransi a
            LEFT JOIN js_asuransi j ON a.jenis = j.id
            WHERE a.id = ?
        ", [$id]);

        return $result ? $result[0] : null;
    }

    public static function updateById($id, $data)
    {
        DB::update("
            UPDATE asuransi 
            SET nama = ?, no_tlp = ?, jenis = ?, deskripsi = ?, updated_user = ?, updated_at = NOW()
            WHERE id = ?
        ", [
            $data['nama'],
            $data['no_tlp'],
            $data['jenis'],
            $data['deskripsi'],
            $data['updated_user'],
            $id
        ]);
    }

    public static function deleteById($id)
    {
        DB::delete("DELETE FROM asuransi WHERE id = ?", [$id]);
    }

    public static function count()
{
    $totalAsuransi = DB::table('asuransi')->count();
return $totalAsuransi;

 }

    

}

<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Pendaftaran
{
    public static function getAll()
    {
        return DB::select("
            SELECT 
                p.*,
                pas.no_rekam_medis AS no_rekam_medis, 
                pas.nama AS nama_pasien,
                pol.nama AS nama_poli,
                d.nama AS nama_dokter,
                a.nama AS nama_asuransi
            FROM pendaftaran p
            LEFT JOIN pasiens pas ON p.pasien_id = pas.id
            LEFT JOIN poliklinik pol ON p.poli_id = pol.id
            LEFT JOIN dokters d ON p.dokter_id = d.id
            LEFT JOIN asuransi a ON p.id_asuransi = a.id
            WHERE p.deleted_at IS NULL
            ORDER BY p.created_at DESC
        ");
    }

    public static function findById($id)
    {
        $data = DB::select("
            SELECT * FROM pendaftaran
            WHERE id = ? AND deleted_at IS NULL
        ", [$id]);

        return $data ? $data[0] : null;
    }

    public static function insert($data)
{
    return DB::insert("
        INSERT INTO pendaftaran (
            pasien_id, tanggal_daftar, poli_id, dokter_id, status,
            inserted_user, updated_user, created_at, updated_at,
            id_asuransi, no_asuransi
        ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)
    ", [
        $data['pasien_id'],
        $data['tanggal_daftar'],
        $data['poli_id'],
        $data['dokter_id'],
        $data['status'],
        $data['inserted_user'],
        $data['updated_user'],
        $data['id_asuransi'],  // sudah sesuai dengan field `asuransi_id` di database
        $data['no_asuransi']
    ]);
}


    public static function updateById($id, $data)
    {
        return DB::update("
            UPDATE pendaftaran SET
                pasien_id = ?, tanggal_daftar = ?, poli_id = ?, dokter_id = ?, status = ?,
                updated_user = ?, updated_at = NOW(), id_asuransi = ?, no_asuransi = ?
            WHERE id = ? AND deleted_at IS NULL
        ", [
            $data['pasien_id'],
            $data['tanggal_daftar'],
            $data['poli_id'],
            $data['dokter_id'],
            $data['status'],
            $data['updated_user'],
            $data['id_asuransi'],
            $data['no_asuransi'],
            $id
        ]);
    }

    public static function cancelRegis($id)
{
    return DB::update("UPDATE pendaftaran SET status = '2' WHERE id = ?", [$id]);
}


    public static function deleteById($id)
    {
        return DB::update("
            UPDATE pendaftaran SET deleted_at = NOW()
            WHERE id = ?
        ", [$id]);
    }
    

}

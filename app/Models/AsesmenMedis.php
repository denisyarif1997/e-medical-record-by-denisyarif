<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class AsesmenMedis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asesmen_medis';

    protected $fillable = [
        'id_regis',
        'asesmen',
        'inserted_user',
        'updated_user',
        'deleted_by',
    ];

    protected $casts = [
        'asesmen' => 'array', // Untuk memastikan asesmen di-cast sebagai array saat diakses
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_regis', 'id');
    }

    public static function getRegisAsmed($tanggalAwal = null, $tanggalAkhir = null)
    {
        $tanggalAwal = $tanggalAwal ?? date('Y-m-d');
        $tanggalAkhir = $tanggalAkhir ?? date('Y-m-d');
    
        return DB::select("
            SELECT
                p.*,
                p.id,
                pas.no_rekam_medis AS no_rekam_medis,
                pas.nama AS nama_pasien,
                pol.nama AS nama_poli,
                d.nama AS nama_dokter,
                a.nama AS nama_asuransi,
                am.id AS id_asemen,
                p.id AS id_regis
            FROM
                pendaftaran p
            LEFT JOIN pasiens pas ON p.pasien_id = pas.id
            LEFT JOIN poliklinik pol ON p.poli_id = pol.id
            LEFT JOIN dokters d ON p.dokter_id = d.id
            LEFT JOIN asuransi a ON p.id_asuransi = a.id
            LEFT JOIN asesmen_medis am ON p.id = am.id_regis 
            WHERE
                p.deleted_at IS NULL
                AND p.status = '1'
                AND DATE(p.created_at) BETWEEN ? AND ?
            ORDER BY
                p.created_at DESC
        ", [$tanggalAwal, $tanggalAkhir]);
    }
    

    

    public static function findById($id)
     {
        $result = DB::select("
            SELECT
    p.*,
    pas.no_rekam_medis AS no_rekam_medis,
    pas.nama AS nama_pasien,
    pol.nama AS nama_poli,
    d.nama AS nama_dokter,
    a.nama AS nama_asuransi,
    p.id AS id_regis,
    pas.tanggal_lahir AS tanggal_lahir,
    ap.id_regis as id_regisas,
    ap.asesmen->>'tujuan_kunjungan' AS tujuan_kunjungan,
    ap.asesmen->>'keluhan_utama' AS keluhan_utama,
    ap.asesmen->>'keadaan_umum' AS keadaan_umum,
    ap.asesmen->>'sistolik' AS sistolik,
    ap.asesmen->>'diastolik' AS diastolik,
    ap.asesmen->>'nadi' AS nadi,
    ap.asesmen->>'pernapasan' AS pernapasan,
    ap.asesmen->>'suhu' AS suhu,
    ap.asesmen->>'tinggi_badan' AS tinggi_badan,
    ap.asesmen->>'berat_badan' AS berat_badan,
    ap.asesmen->>'imt' AS imt,
    ap.asesmen->>'pemeriksaan_fisik' AS pemeriksaan_fisik
FROM
    pendaftaran p
LEFT JOIN pasiens pas ON p.pasien_id = pas.id
LEFT JOIN poliklinik pol ON p.poli_id = pol.id
LEFT JOIN dokters d ON p.dokter_id = d.id
LEFT JOIN asuransi a ON p.id_asuransi = a.id
LEFT JOIN asesmen_perawat ap ON ap.id_regis = p.id
WHERE
    p.id = ?
        ", [$id]);

        return $result ? $result[0] : null;
     }
    //     public static function getAsesmen($id)
//     {
//         return DB::select("
//             select
//                 p.*,
//                 pas.no_rekam_medis as no_rekam_medis,
//                 pas.nama as nama_pasien,
//                 pol.nama as nama_poli,
//                 d.nama as nama_dokter,
//                 a.nama as nama_asuransi
//             from
//                 asesmen_perawat p
//             left join pasiens pas on
//                 p.pasien_id = pas.id
//             left join poliklinik pol on
//                 p.poli_id = pol.id
//             left join dokters d on
//                 p.dokter_id = d.id
//             left join asuransi a on
//                 p.id_asuransi = a.id
//             where
//                 p.deleted_at is null
//                 and p.status = '1'
//                 and p.id = ?
//         ", [$id]);
//     }
}
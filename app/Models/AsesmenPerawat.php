<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class AsesmenPerawat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asesmen_perawat';

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

    public static function getRegisAskep()
    {
        return DB::select("
    select
	p.*,
    p.id,
	pas.no_rekam_medis as no_rekam_medis,
	pas.nama as nama_pasien,
	pol.nama as nama_poli,
	d.nama as nama_dokter,
	a.nama as nama_asuransi,
	ap.id as id_asemen
from
	pendaftaran p
left join pasiens pas on
	p.pasien_id = pas.id
left join poliklinik pol on
	p.poli_id = pol.id
left join dokters d on
	p.dokter_id = d.id
left join asuransi a on
	p.id_asuransi = a.id
left join asesmen_perawat ap on
	p.id = ap.id_regis 
where
	p.deleted_at is null
	and p.status = '1'
order by
	p.created_at desc
        ");
    }

    

    public static function findById($id)
     {
        $result = DB::select("
            select
             p.*,
             pas.no_rekam_medis as no_rekam_medis,
             pas.nama as nama_pasien,
             pol.nama as nama_poli,
             d.nama as nama_dokter,
             a.nama as nama_asuransi,
             p.id  as id_regis
        from
             pendaftaran p
        left join pasiens pas on
             p.pasien_id = pas.id
        left join poliklinik pol on
             p.poli_id = pol.id
        left join dokters d on
             p.dokter_id = d.id
        left join asuransi a on
             p.id_asuransi = a.id
        where
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
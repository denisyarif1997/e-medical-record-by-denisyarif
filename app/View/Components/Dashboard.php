<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Core counts
        $user = User::count();
        view()->share('user', $user);

        $category = Category::count();
        view()->share('category', $category);

        $product = Product::count();
        view()->share('product', $product);

        $collection = Collection::count();
        view()->share('collection', $collection);

        // Registration stats
        $pasientidakbatal = DB::selectOne("
            SELECT COUNT(*) as total
            FROM pendaftaran
            WHERE deleted_at IS NULL AND status = '1'
        ")->total;
        view()->share('pasientidakbatal', $pasientidakbatal);

        $pasienbatal = DB::table('pendaftaran')
            ->whereNull('deleted_at')
            ->where('status', '2')
            ->count();
        view()->share('pasienbatal', $pasienbatal);

        // Doctor count
        $dokterCount = DB::table('dokters')->whereNull('deleted_at')->count();
        view()->share('dokterCount', $dokterCount);

        // Today's registrations
        $todayRegistrations = DB::table('pendaftaran')
            ->whereNull('deleted_at')
            ->whereDate('created_at', today())
            ->count();
        view()->share('todayRegistrations', $todayRegistrations);

        // Total patients
        $totalPasien = DB::table('pasiens')->whereNull('deleted_at')->count();
        view()->share('totalPasien', $totalPasien);

        // Pending nurse assessments (pendaftaran tanpa asesmen perawat)
        $pendingNurseAssessment = DB::table('pendaftaran as p')
            ->leftJoin('asesmen_perawat as ap', 'p.id', '=', 'ap.pendaftaran_id')
            ->whereNull('p.deleted_at')
            ->where('p.status', '1')
            ->whereNull('ap.id')
            ->count();
        view()->share('pendingNurseAssessment', $pendingNurseAssessment);

        // Pending medical assessments (pendaftaran tanpa asesmen medis)
        $pendingMedisAssessment = DB::table('pendaftaran as p')
            ->leftJoin('asesmen_medis as am', 'p.id', '=', 'am.pendaftaran_id')
            ->whereNull('p.deleted_at')
            ->where('p.status', '1')
            ->whereNull('am.id')
            ->count();
        view()->share('pendingMedisAssessment', $pendingMedisAssessment);

        // Recent registrations (last 8)
        $recentRegistrations = DB::select("
            SELECT
                p.id,
                p.created_at,
                p.status,
                pas.nama AS nama_pasien,
                pas.no_rekam_medis,
                pol.nama AS nama_poli,
                d.nama AS nama_dokter
            FROM pendaftaran p
            LEFT JOIN pasiens pas ON p.pasien_id = pas.id
            LEFT JOIN poliklinik pol ON p.poli_id = pol.id
            LEFT JOIN dokters d ON p.dokter_id = d.id
            WHERE p.deleted_at IS NULL
            ORDER BY p.created_at DESC
            LIMIT 8
        ");
        view()->share('recentRegistrations', $recentRegistrations);

        // Registrations per day last 7 days (for spark chart data)
        $dailyStats = DB::select("
            SELECT
                DATE(created_at) AS day,
                COUNT(*) AS total
            FROM pendaftaran
            WHERE deleted_at IS NULL
              AND created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(created_at)
            ORDER BY day ASC
        ");
        view()->share('dailyStats', $dailyStats);

        // Top polyclinic
        $topPoliklinik = DB::select("
            SELECT pol.nama, COUNT(p.id) AS total
            FROM pendaftaran p
            LEFT JOIN poliklinik pol ON p.poli_id = pol.id
            WHERE p.deleted_at IS NULL
            GROUP BY pol.nama
            ORDER BY total DESC
            LIMIT 5
        ");
        view()->share('topPoliklinik', $topPoliklinik);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard');
    }
}

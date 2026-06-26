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
        // Parse selected month (default to current year-month)
        $selectedMonth = request('month');
        if (!$selectedMonth || !preg_match('/^\d{4}-\d{2}$/', $selectedMonth)) {
            $selectedMonth = date('Y-m');
        }
        $parts = explode('-', $selectedMonth);
        $year = (int)$parts[0];
        $month = (int)$parts[1];

        // English to Indonesian Month names map
        $monthsIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $selectedMonthName = $monthsIndo[$month] . ' ' . $year;

        view()->share('selectedMonth', $selectedMonth);
        view()->share('selectedMonthName', $selectedMonthName);

        // Core counts
        $user = User::count();
        view()->share('user', $user);

        $category = Category::count();
        view()->share('category', $category);

        $product = Product::count();
        view()->share('product', $product);

        $collection = Collection::count();
        view()->share('collection', $collection);

        // Registration stats filtered by month
        $pasientidakbatal = DB::table('pendaftaran')
            ->whereNull('deleted_at')
            ->where('status', '1')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        view()->share('pasientidakbatal', $pasientidakbatal);

        $pasienbatal = DB::table('pendaftaran')
            ->whereNull('deleted_at')
            ->where('status', '2')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        view()->share('pasienbatal', $pasienbatal);

        // Tenaga Medis count (all-time)
        $tenagaMedisCount = DB::table('tenaga_medis')->whereNull('deleted_at')->count();
        view()->share('tenagaMedisCount', $tenagaMedisCount);
        view()->share('dokterCount', $tenagaMedisCount); // keep for backward compat

        // Monthly registrations (used for Today's registrations KPI box)
        $todayRegistrations = DB::table('pendaftaran')
            ->whereNull('deleted_at')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        view()->share('todayRegistrations', $todayRegistrations);

        // New patients in selected month
        $totalPasien = DB::table('pasiens')
            ->whereNull('deleted_at')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        view()->share('totalPasien', $totalPasien);

        // Pending nurse assessments for this month
        $pendingNurseAssessment = DB::table('pendaftaran as p')
            ->leftJoin('asesmen_perawat as ap', 'p.id', '=', 'ap.id_regis')
            ->whereNull('p.deleted_at')
            ->where('p.status', '1')
            ->whereNull('ap.id')
            ->whereYear('p.created_at', $year)
            ->whereMonth('p.created_at', $month)
            ->count();
        view()->share('pendingNurseAssessment', $pendingNurseAssessment);

        // Pending medical assessments for this month
        $pendingMedisAssessment = DB::table('pendaftaran as p')
            ->leftJoin('asesmen_medis as am', 'p.id', '=', 'am.id_regis')
            ->whereNull('p.deleted_at')
            ->where('p.status', '1')
            ->whereNull('am.id')
            ->whereYear('p.created_at', $year)
            ->whereMonth('p.created_at', $month)
            ->count();
        view()->share('pendingMedisAssessment', $pendingMedisAssessment);

        // Recent registrations (last 8 of selected month)
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
            LEFT JOIN tenaga_medis d ON p.dokter_id = d.id
            WHERE p.deleted_at IS NULL
              AND EXTRACT(YEAR FROM p.created_at) = ?
              AND EXTRACT(MONTH FROM p.created_at) = ?
            ORDER BY p.created_at DESC
            LIMIT 8
        ", [$year, $month]);
        view()->share('recentRegistrations', $recentRegistrations);

        // Daily stats for selected month (groups by date)
        $dailyStats = DB::select("
            SELECT
                DATE(created_at) AS day,
                COUNT(*) AS total
            FROM pendaftaran
            WHERE deleted_at IS NULL
              AND EXTRACT(YEAR FROM created_at) = ?
              AND EXTRACT(MONTH FROM created_at) = ?
            GROUP BY DATE(created_at)
            ORDER BY day ASC
        ", [$year, $month]);
        view()->share('dailyStats', $dailyStats);

        // Top polyclinics of selected month
        $topPoliklinik = DB::select("
            SELECT pol.nama, COUNT(p.id) AS total
            FROM pendaftaran p
            LEFT JOIN poliklinik pol ON p.poli_id = pol.id
            WHERE p.deleted_at IS NULL
              AND EXTRACT(YEAR FROM p.created_at) = ?
              AND EXTRACT(MONTH FROM p.created_at) = ?
            GROUP BY pol.nama
            ORDER BY total DESC
            LIMIT 5
        ", [$year, $month]);
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

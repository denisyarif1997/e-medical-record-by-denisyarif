{{-- Dashboard RS — Modern Clean Design --}}
<style>
/* ── Reset & base ── */
.rs-dash * { box-sizing: border-box; }
.rs-dash { padding: 0; font-family: system-ui, -apple-system, sans-serif; color: #1a1a1a; }

/* ── Filter bar ── */
.rs-filter {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.rs-filter label { font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.4px; white-space: nowrap; }
.rs-filter input[type="month"] {
    border: 1px solid #e5e5e5;
    border-radius: 7px;
    padding: 7px 12px;
    font-size: 13px;
    color: #1a1a1a;
    background: #fafafa;
    outline: none;
    transition: border-color 0.15s;
}
.rs-filter input[type="month"]:focus { border-color: #185FA5; background: #fff; }
.rs-period-chip {
    margin-left: auto;
    font-size: 12px;
    font-weight: 600;
    color: #185FA5;
    background: #E6F1FB;
    padding: 5px 12px;
    border-radius: 20px;
    white-space: nowrap;
}

/* ── KPI cards ── */
.rs-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 1.5rem;
}
.rs-kpi {
    background: #f9f9f8;
    border-radius: 10px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    text-decoration: none;
    transition: background 0.15s;
    position: relative;
    overflow: hidden;
}
.rs-kpi:hover { background: #f0f0ee; text-decoration: none; }
.rs-kpi-icon { font-size: 16px; color: #b0b0a8; margin-bottom: 8px; }
.rs-kpi-val { font-size: 26px; font-weight: 600; line-height: 1; }
.rs-kpi-lbl { font-size: 12px; color: #6b7280; margin-top: 4px; }
.rs-kpi-foot {
    margin-top: 14px;
    padding-top: 10px;
    border-top: 1px solid #e5e5e5;
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Accent colors — angka saja */
.rs-kpi.blue  .rs-kpi-val { color: #185FA5; }
.rs-kpi.teal  .rs-kpi-val { color: #0F6E56; }
.rs-kpi.amber .rs-kpi-val { color: #854F0B; }
.rs-kpi.red   .rs-kpi-val { color: #A32D2D; }

/* ── Secondary info row ── */
.rs-info-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 1.5rem;
}
.rs-info-tile {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.rs-info-ikon {
    width: 42px;
    height: 42px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
}
.rs-info-ikon.blue   { background: #E6F1FB; color: #185FA5; }
.rs-info-ikon.purple { background: #EEEDFE; color: #534AB7; }
.rs-info-ikon.red    { background: #FCEBEB; color: #A32D2D; }
.rs-info-ikon.gray   { background: #F1EFE8; color: #5F5E5A; }
.rs-info-lbl { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; color: #9ca3af; }
.rs-info-val { font-size: 20px; font-weight: 600; color: #1a1a1a; line-height: 1.2; margin-top: 2px; }

/* ── Content panels ── */
.rs-panel-row {
    display: grid;
    gap: 14px;
    margin-bottom: 14px;
}
.rs-panel-row.col-8-4 { grid-template-columns: 2fr 1fr; }
.rs-panel-row.col-2   { grid-template-columns: 1fr 1fr; }

.rs-panel {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 12px;
    overflow: hidden;
}
.rs-panel-head {
    padding: 14px 18px;
    border-bottom: 1px solid #f0f0ee;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}
.rs-panel-head-left { display: flex; align-items: center; gap: 8px; }
.rs-panel-head i { font-size: 16px; color: #9ca3af; }
.rs-panel-head-title { font-size: 13px; font-weight: 600; color: #374151; }
.rs-panel-head-sub { font-size: 11px; color: #9ca3af; margin-top: 1px; }
.rs-panel-body { padding: 18px; }
.rs-panel-body.p0 { padding: 0; }

.rs-btn-sm {
    font-size: 12px;
    font-weight: 600;
    color: #185FA5;
    background: #E6F1FB;
    border: none;
    border-radius: 6px;
    padding: 5px 12px;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.15s;
    white-space: nowrap;
}
.rs-btn-sm:hover { background: #B5D4F4; color: #0C447C; text-decoration: none; }

/* ── Table ── */
.rs-tbl { width: 100%; border-collapse: collapse; font-size: 12px; }
.rs-tbl th {
    padding: 8px 14px;
    text-align: left;
    font-size: 10px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #f0f0ee;
    background: #fafafa;
}
.rs-tbl td { padding: 9px 14px; border-bottom: 1px solid #f9f9f8; vertical-align: middle; color: #374151; }
.rs-tbl tr:last-child td { border-bottom: none; }
.rs-tbl tr:hover td { background: #fafafa; }
.rs-tbl td strong { font-weight: 600; color: #1f2937; }
.rs-tbl .empty-td { text-align: center; color: #9ca3af; padding: 24px !important; font-size: 12px; font-style: italic; }
.rs-tbl .t-muted { font-size: 11px; color: #9ca3af; margin-top: 2px; }
.rs-tbl .t-accent { color: #185FA5; font-weight: 600; }

/* ── Badge ── */
.rs-badge { display: inline-flex; align-items: center; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 100px; }
.rs-badge.green  { background: #EAF3DE; color: #3B6D11; }
.rs-badge.red    { background: #FCEBEB; color: #A32D2D; }
.rs-badge.gray   { background: #F1EFE8; color: #5F5E5A; }

/* ── Chart ── */
.rs-chart-wrap { position: relative; width: 100%; height: 260px; }

/* ── Poli progress ── */
.rs-poli-item { margin-bottom: 14px; }
.rs-poli-item:last-child { margin-bottom: 0; }
.rs-poli-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 5px; }
.rs-poli-name { font-size: 12px; font-weight: 600; color: #374151; }
.rs-poli-count { font-size: 11px; color: #6b7280; }
.rs-progress { height: 6px; background: #f0f0ee; border-radius: 3px; overflow: hidden; }
.rs-progress-bar { height: 100%; border-radius: 3px; background: #185FA5; transition: width 0.6s ease; }
.rs-progress-bar.p1 { background: #185FA5; }
.rs-progress-bar.p2 { background: #0F6E56; }
.rs-progress-bar.p3 { background: #534AB7; }
.rs-progress-bar.p4 { background: #854F0B; }
.rs-progress-bar.p5 { background: #A32D2D; }

/* ── Quick links ── */
.rs-quicklinks { display: flex; flex-direction: column; gap: 8px; }
.rs-ql {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    text-decoration: none;
    color: #1a1a1a;
    transition: all 0.15s;
}
.rs-ql:hover { background: #f9f9f8; border-color: #d0d0d0; text-decoration: none; color: #1a1a1a; padding-left: 18px; }
.rs-ql-ikon {
    width: 36px;
    height: 36px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.rs-ql-ikon.blue   { background: #E6F1FB; color: #185FA5; }
.rs-ql-ikon.amber  { background: #FAEEDA; color: #854F0B; }
.rs-ql-ikon.red    { background: #FCEBEB; color: #A32D2D; }
.rs-ql-ikon.teal   { background: #E1F5EE; color: #0F6E56; }
.rs-ql-title { font-size: 13px; font-weight: 600; color: #1f2937; }
.rs-ql-sub { font-size: 11px; color: #9ca3af; margin-top: 1px; }
.rs-ql-arrow { margin-left: auto; font-size: 13px; color: #c0c0b8; flex-shrink: 0; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .rs-kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .rs-info-row { grid-template-columns: repeat(2, 1fr); }
    .rs-panel-row.col-8-4 { grid-template-columns: 1fr; }
}
@media (max-width: 560px) {
    .rs-kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .rs-info-row { grid-template-columns: repeat(2, 1fr); }
    .rs-panel-row.col-2 { grid-template-columns: 1fr; }
}
</style>

<div class="rs-dash">
    @role('admin')

    {{-- ── Filter Bar ── --}}
    <div class="rs-filter">
        <label for="month"><i class="fas fa-calendar-alt mr-1"></i>Periode laporan</label>
        <form method="GET" id="monthFilterForm" style="display:contents">
            <input type="month" name="month" id="month" value="{{ $selectedMonth }}" onchange="this.form.submit()">
        </form>
        <div class="rs-period-chip">{{ $selectedMonthName }}</div>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="rs-kpi-grid">
        <a href="{{ route('admin.pendaftaran.index') }}" class="rs-kpi blue">
            <i class="fas fa-calendar-day rs-kpi-icon"></i>
            <div class="rs-kpi-val">{{ $todayRegistrations }}</div>
            <div class="rs-kpi-lbl">Registrasi bulan ini</div>
            <div class="rs-kpi-foot"><span>Lihat pendaftaran</span><i class="fas fa-arrow-right" style="font-size:10px"></i></div>
        </a>
        <a href="{{ route('admin.pasien.index') }}" class="rs-kpi teal">
            <i class="fas fa-user-injured rs-kpi-icon"></i>
            <div class="rs-kpi-val">{{ $totalPasien }}</div>
            <div class="rs-kpi-lbl">Pasien baru bulan ini</div>
            <div class="rs-kpi-foot"><span>Kelola pasien</span><i class="fas fa-arrow-right" style="font-size:10px"></i></div>
        </a>
        <a href="{{ route('admin.asesmen_perawat.index') }}" class="rs-kpi amber">
            <i class="fas fa-user-nurse rs-kpi-icon"></i>
            <div class="rs-kpi-val">{{ $pendingNurseAssessment }}</div>
            <div class="rs-kpi-lbl">Antrian asesmen perawat</div>
            <div class="rs-kpi-foot"><span>Mulai asesmen</span><i class="fas fa-arrow-right" style="font-size:10px"></i></div>
        </a>
        <a href="{{ route('forms.asesmen_medis') }}" class="rs-kpi red">
            <i class="fas fa-stethoscope rs-kpi-icon"></i>
            <div class="rs-kpi-val">{{ $pendingMedisAssessment }}</div>
            <div class="rs-kpi-lbl">Antrian asesmen medis</div>
            <div class="rs-kpi-foot"><span>Mulai asesmen</span><i class="fas fa-arrow-right" style="font-size:10px"></i></div>
        </a>
    </div>

    {{-- ── Secondary Info Row ── --}}
    <div class="rs-info-row">
        <div class="rs-info-tile">
            <div class="rs-info-ikon blue"><i class="fas fa-users-cog"></i></div>
            <div>
                <div class="rs-info-lbl">Total users</div>
                <div class="rs-info-val">{{ $user }}</div>
            </div>
        </div>
        <div class="rs-info-tile">
            <div class="rs-info-ikon purple"><i class="fas fa-user-md"></i></div>
            <div>
                <div class="rs-info-lbl">Jumlah dokter</div>
                <div class="rs-info-val">{{ $dokterCount }}</div>
            </div>
        </div>
        <div class="rs-info-tile">
            <div class="rs-info-ikon red"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="rs-info-lbl">Registrasi batal</div>
                <div class="rs-info-val">{{ $pasienbatal }}</div>
            </div>
        </div>
        <div class="rs-info-tile">
            <div class="rs-info-ikon gray"><i class="fas fa-folder-open"></i></div>
            <div>
                <div class="rs-info-lbl">Total collections</div>
                <div class="rs-info-val">{{ $collection }}</div>
            </div>
        </div>
    </div>

    {{-- ── Chart & Poliklinik ── --}}
    <div class="rs-panel-row col-8-4">
        <div class="rs-panel">
            <div class="rs-panel-head">
                <div class="rs-panel-head-left">
                    <i class="fas fa-chart-line"></i>
                    <div>
                        <div class="rs-panel-head-title">Tren pendaftaran — {{ $selectedMonthName }}</div>
                        <div class="rs-panel-head-sub">Jumlah pendaftaran pasien harian</div>
                    </div>
                </div>
            </div>
            <div class="rs-panel-body">
                <div class="rs-chart-wrap">
                    <canvas id="registrationTrendChart"
                        role="img"
                        aria-label="Grafik tren pendaftaran pasien harian bulan {{ $selectedMonthName }}">
                        Data tren pendaftaran harian.
                    </canvas>
                </div>
            </div>
        </div>

        <div class="rs-panel">
            <div class="rs-panel-head">
                <div class="rs-panel-head-left">
                    <i class="fas fa-hospital-user"></i>
                    <div>
                        <div class="rs-panel-head-title">Kunjungan poliklinik</div>
                        <div class="rs-panel-head-sub">Distribusi terpopuler</div>
                    </div>
                </div>
            </div>
            <div class="rs-panel-body">
                @php
                    $poliArr  = is_array($topPoliklinik) ? $topPoliklinik : $topPoliklinik->toArray();
                    $maxTotal = count($poliArr) > 0 ? max(array_column($poliArr, 'total')) : 1;
                    $pColors  = ['p1','p2','p3','p4','p5'];
                @endphp
                @forelse($topPoliklinik as $idx => $poli)
                @php $pct = ($poli->total / $maxTotal) * 100; @endphp
                <div class="rs-poli-item">
                    <div class="rs-poli-row">
                        <span class="rs-poli-name">{{ $poli->nama ?? 'Umum' }}</span>
                        <span class="rs-poli-count">{{ $poli->total }} pasien</span>
                    </div>
                    <div class="rs-progress">
                        <div class="rs-progress-bar {{ $pColors[$idx % 5] }}" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding: 32px 0; font-size:12px; color:#9ca3af;">
                    <i class="fas fa-clinic-medical" style="font-size:20px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                    Belum ada data pendaftaran.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Tabel Pasien Terbaru & Quick Nav ── --}}
    <div class="rs-panel-row col-8-4">
        <div class="rs-panel">
            <div class="rs-panel-head">
                <div class="rs-panel-head-left">
                    <i class="fas fa-user-clock"></i>
                    <div>
                        <div class="rs-panel-head-title">Pendaftaran pasien terbaru</div>
                        <div class="rs-panel-head-sub">8 transaksi terakhir di sistem</div>
                    </div>
                </div>
                <a href="{{ route('admin.pendaftaran.index') }}" class="rs-btn-sm">Semua data</a>
            </div>
            <div class="rs-panel-body p0">
                <div style="overflow-x: auto;">
                    <table class="rs-tbl">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pasien</th>
                                <th>Poliklinik / Dokter</th>
                                <th>Waktu daftar</th>
                                <th>Status</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRegistrations as $reg)
                            <tr>
                                <td><span class="t-accent">#{{ $reg->id }}</span></td>
                                <td>
                                    <strong>{{ $reg->nama_pasien }}</strong>
                                    <div class="t-muted">RM: {{ $reg->no_rekam_medis }}</div>
                                </td>
                                <td>
                                    <strong>{{ $reg->nama_poli }}</strong>
                                    <div class="t-muted"><i class="fas fa-user-md" style="font-size:10px; margin-right:3px;"></i>{{ $reg->nama_dokter }}</div>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($reg->created_at)->format('d M Y') }}
                                    <div class="t-muted">{{ \Carbon\Carbon::parse($reg->created_at)->format('H:i') }}</div>
                                </td>
                                <td>
                                    @if($reg->status == 1)
                                        <span class="rs-badge green">Aktif</span>
                                    @elseif($reg->status == 2)
                                        <span class="rs-badge red">Batal</span>
                                    @else
                                        <span class="rs-badge gray">Non aktif</span>
                                    @endif
                                </td>
                                <td style="text-align:center">
                                    <a href="{{ route('admin.pendaftaran.edit', encrypt($reg->id)) }}"
                                       style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:6px; background:#E6F1FB; color:#185FA5; font-size:12px;"
                                       title="Edit pendaftaran">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="empty-td">Belum ada data pendaftaran terbaru.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="rs-panel">
            <div class="rs-panel-head">
                <div class="rs-panel-head-left">
                    <i class="fas fa-bolt"></i>
                    <div>
                        <div class="rs-panel-head-title">Aksi cepat</div>
                        <div class="rs-panel-head-sub">Navigasi ke modul utama</div>
                    </div>
                </div>
            </div>
            <div class="rs-panel-body">
                <div class="rs-quicklinks">
                    <a href="{{ route('admin.pendaftaran.cari_pasien') }}" class="rs-ql">
                        <div class="rs-ql-ikon blue"><i class="fas fa-user-plus"></i></div>
                        <div>
                            <div class="rs-ql-title">Pendaftaran baru</div>
                            <div class="rs-ql-sub">Daftarkan pasien ke poliklinik</div>
                        </div>
                        <i class="fas fa-chevron-right rs-ql-arrow"></i>
                    </a>
                    <a href="{{ route('admin.asesmen_perawat.index') }}" class="rs-ql">
                        <div class="rs-ql-ikon amber"><i class="fas fa-user-nurse"></i></div>
                        <div>
                            <div class="rs-ql-title">Asesmen keperawatan</div>
                            <div class="rs-ql-sub">Input rekam medis oleh perawat</div>
                        </div>
                        <i class="fas fa-chevron-right rs-ql-arrow"></i>
                    </a>
                    <a href="{{ route('forms.asesmen_medis') }}" class="rs-ql">
                        <div class="rs-ql-ikon red"><i class="fas fa-stethoscope"></i></div>
                        <div>
                            <div class="rs-ql-title">Asesmen medis (dokter)</div>
                            <div class="rs-ql-sub">Input pemeriksaan & diagnosa</div>
                        </div>
                        <i class="fas fa-chevron-right rs-ql-arrow"></i>
                    </a>
                    <a href="{{ route('admin.tenaga_medis.create') }}" class="rs-ql">
                        <div class="rs-ql-ikon teal"><i class="fas fa-user-md"></i></div>
                        <div>
                            <div class="rs-ql-title">Tambah dokter</div>
                            <div class="rs-ql-sub">Daftarkan dokter baru ke sistem</div>
                        </div>
                        <i class="fas fa-chevron-right rs-ql-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @endrole
</div>

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('registrationTrendChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    const rawLabels = {!! json_encode(array_column($dailyStats, 'day')) !!};
    const chartData = {!! json_encode(array_column($dailyStats, 'total')) !!};

    const months = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
    const labels = rawLabels.map(l => {
        if (!l) return '';
        const d = new Date(l);
        return d.getDate() + ' ' + months[d.getMonth()];
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Pendaftaran',
                data: chartData,
                borderColor: '#185FA5',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#185FA5',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                backgroundColor: 'rgba(24, 95, 165, 0.07)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#1f2937',
                    titleColor: '#f9fafb',
                    bodyColor: '#d1d5db',
                    padding: 10,
                    cornerRadius: 6,
                    displayColors: false,
                    callbacks: {
                        title: items => items[0].label,
                        label: item => item.raw + ' pendaftaran'
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { color: '#e5e5e5' },
                    ticks: { color: '#9ca3af', font: { size: 11 } }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                    border: { dash: [4,4], color: 'transparent' },
                    ticks: { color: '#9ca3af', font: { size: 11 }, precision: 0, beginAtZero: true }
                }
            }
        }
    });
});
</script>
@endsection

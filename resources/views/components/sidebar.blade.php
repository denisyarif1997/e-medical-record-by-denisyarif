<style>
/* ── Sidebar shell ── */
.rs-sidebar {
    padding: 8px 12px 24px;
    font-family: system-ui, -apple-system, sans-serif;
}

/* ── Group header ── */
.rs-nav-header {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    color: #9ca3af;
    padding: 18px 8px 6px;
    margin: 0;
}
.rs-nav-header:first-child { padding-top: 4px; }

/* ── Nav item ── */
.rs-nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.rs-nav-list li { margin: 1px 0; }

/* ── Nav link (single) ── */
.rs-nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 10px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    color: #4b5563;
    transition: background 0.15s, color 0.15s;
    position: relative;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}
.rs-nav-link i.nav-icon-rs {
    font-size: 15px;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
    color: #9ca3af;
    transition: color 0.15s;
}
.rs-nav-link:hover {
    background: #f3f4f6;
    color: #1f2937;
    text-decoration: none;
}
.rs-nav-link:hover i.nav-icon-rs { color: #374151; }

/* Active state */
.rs-nav-link.active {
    background: #E6F1FB;
    color: #185FA5;
    font-weight: 600;
}
.rs-nav-link.active i.nav-icon-rs { color: #185FA5; }

/* ── Badge ── */
.rs-nav-badge {
    margin-left: auto;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 100px;
    line-height: 1.4;
}
.rs-nav-badge.blue   { background: #E6F1FB; color: #185FA5; }
.rs-nav-badge.green  { background: #EAF3DE; color: #3B6D11; }
.rs-nav-badge.red    { background: #FCEBEB; color: #A32D2D; }

/* ── Treeview (dropdown) ── */
.rs-nav-parent { position: relative; }

/* Chevron */
.rs-chevron {
    margin-left: auto;
    font-size: 11px;
    color: #c0c0b8;
    transition: transform 0.2s ease;
    flex-shrink: 0;
}
.rs-nav-parent.open > .rs-nav-link .rs-chevron { transform: rotate(90deg); }
.rs-nav-parent.open > .rs-nav-link { color: #1f2937; }
.rs-nav-parent.open > .rs-nav-link i.nav-icon-rs { color: #374151; }

/* Submenu */
.rs-submenu {
    list-style: none;
    margin: 2px 0 4px 30px;
    padding: 0;
    border-left: 1.5px solid #e5e5e5;
    display: none;
}
.rs-nav-parent.open > .rs-submenu { display: block; }

.rs-submenu li { margin: 1px 0; }
.rs-submenu .rs-nav-link {
    font-size: 12.5px;
    padding: 7px 10px 7px 12px;
    font-weight: 400;
    color: #6b7280;
}
.rs-submenu .rs-nav-link i.nav-icon-rs { font-size: 13px; }
.rs-submenu .rs-nav-link:hover { color: #1f2937; }
.rs-submenu .rs-nav-link.active {
    background: #E6F1FB;
    color: #185FA5;
    font-weight: 600;
}
</style>

<nav class="rs-sidebar" aria-label="Navigasi utama">

    {{-- ── UMUM ── --}}
    <p class="rs-nav-header">Umum</p>
    <ul class="rs-nav-list">
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="rs-nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt nav-icon-rs"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.pendaftaran.index') }}"
               class="rs-nav-link {{ Route::is('admin.pendaftaran.index') ? 'active' : '' }}">
                <i class="fas fa-user-plus nav-icon-rs"></i>
                Registrasi
            </a>
        </li>
        <li>
            <a href="{{ route('admin.pasien.index') }}"
               class="rs-nav-link {{ Route::is('admin.pasien.index') ? 'active' : '' }}">
                <i class="fas fa-id-card-alt nav-icon-rs"></i>
                Profile Rekam Medis
            </a>
        </li>
    </ul>

    {{-- ── ASESMEN ── --}}
    <p class="rs-nav-header">Asesmen</p>
    <ul class="rs-nav-list">
        @php $asesmenOpen = Route::is('admin.asesmen_perawat.*') || Route::is('forms.asesmen_medis'); @endphp
        <li class="rs-nav-parent {{ $asesmenOpen ? 'open' : '' }}">
            <button class="rs-nav-link rs-nav-toggle {{ $asesmenOpen ? 'active' : '' }}">
                <i class="fas fa-notes-medical nav-icon-rs"></i>
                Asesmen
                <i class="fas fa-chevron-right rs-chevron"></i>
            </button>
            <ul class="rs-submenu">
                <li>
                    <a href="{{ route('admin.asesmen_perawat.index') }}"
                       class="rs-nav-link {{ Route::is('admin.asesmen_perawat.*') ? 'active' : '' }}">
                        <i class="fas fa-user-nurse nav-icon-rs"></i>
                        Asesmen Perawat
                    </a>
                </li>
                <li>
                    <a href="{{ route('forms.asesmen_medis') }}"
                       class="rs-nav-link {{ Route::is('forms.asesmen_medis') ? 'active' : '' }}">
                        <i class="fas fa-user-md nav-icon-rs"></i>
                        Asesmen Medis
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    {{-- ── DOKUMEN ── --}}
    <p class="rs-nav-header">Dokumen</p>
    <ul class="rs-nav-list">
        @php $dokumenOpen = Route::is('admin.collection.index') || Route::is('admin.category.index'); @endphp
        <li class="rs-nav-parent {{ $dokumenOpen ? 'open' : '' }}">
            <button class="rs-nav-link rs-nav-toggle {{ $dokumenOpen ? 'active' : '' }}">
                <i class="fas fa-file-medical nav-icon-rs"></i>
                Dokumen
                <i class="fas fa-chevron-right rs-chevron"></i>
            </button>
            <ul class="rs-submenu">
                <li>
                    <a href="{{ route('admin.collection.index') }}"
                       class="rs-nav-link {{ Route::is('admin.collection.index') ? 'active' : '' }}">
                        <i class="fas fa-file nav-icon-rs"></i>
                        Dokumen
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.category.index') }}"
                       class="rs-nav-link {{ Route::is('admin.category.index') ? 'active' : '' }}">
                        <i class="fas fa-tags nav-icon-rs"></i>
                        Kategori
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    {{-- ── FARMASI ── --}}
    <p class="rs-nav-header">Farmasi</p>
    <ul class="rs-nav-list">
        @php $farmasiOpen = Route::is('admin.obat.*') || Route::is('admin.satuan_obat.*') || Route::is('admin.formula.*') || Route::is('forms.golongan_obat') || Route::is('forms.telaah_farmasi'); @endphp
        <li class="rs-nav-parent {{ $farmasiOpen ? 'open' : '' }}">
            <button class="rs-nav-link rs-nav-toggle {{ $farmasiOpen ? 'active' : '' }}">
                <i class="fas fa-pills nav-icon-rs"></i>
                Data Obat
                <i class="fas fa-chevron-right rs-chevron"></i>
            </button>
            <ul class="rs-submenu">
                <li>
                    <a href="{{ route('admin.obat.index') }}"
                       class="rs-nav-link {{ Route::is('admin.obat.index') ? 'active' : '' }}">
                        <i class="fas fa-capsules nav-icon-rs"></i>
                        Barang Farmasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.satuan_obat.index') }}"
                       class="rs-nav-link {{ Route::is('admin.satuan_obat.index') ? 'active' : '' }}">
                        <i class="fas fa-balance-scale nav-icon-rs"></i>
                        Data Satuan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.formula.index') }}"
                       class="rs-nav-link {{ Route::is('admin.formula.index') ? 'active' : '' }}">
                        <i class="fas fa-flask nav-icon-rs"></i>
                        Formula
                    </a>
                </li>
                <li>
                    <a href="{{ route('forms.golongan_obat') }}"
                       class="rs-nav-link {{ Route::is('forms.golongan_obat') ? 'active' : '' }}">
                        <i class="fas fa-layer-group nav-icon-rs"></i>
                        Golongan
                    </a>
                </li>
                <li>
                    <a href="{{ route('forms.telaah_farmasi') }}"
                       class="rs-nav-link {{ Route::is('forms.telaah_farmasi') ? 'active' : '' }}">
                        <i class="fas fa-check-double nav-icon-rs"></i>
                        Telaah Farmasi
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    @role('admin')

    {{-- ── ADMINISTRATOR ── --}}
    <p class="rs-nav-header">Administrator</p>
    <ul class="rs-nav-list">
        <li>
            <a href="{{ route('admin.user.index') }}"
               class="rs-nav-link {{ Route::is('admin.user.index') ? 'active' : '' }}">
                <i class="fas fa-users-cog nav-icon-rs"></i>
                Pengguna
                <span class="rs-nav-badge blue">{{ $userCount }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.role.index') }}"
               class="rs-nav-link {{ Route::is('admin.role.index') ? 'active' : '' }}">
                <i class="fas fa-user-shield nav-icon-rs"></i>
                Role
                <span class="rs-nav-badge green">{{ $RoleCount }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.permission.index') }}"
               class="rs-nav-link {{ Route::is('admin.permission.index') ? 'active' : '' }}">
                <i class="fas fa-unlock-alt nav-icon-rs"></i>
                Role Akses
                <span class="rs-nav-badge red">{{ $PermissionCount }}</span>
            </a>
        </li>
    </ul>

    {{-- ── MASTER DATA ── --}}
    <p class="rs-nav-header">Master Data</p>
    <ul class="rs-nav-list">
        @php $masterOpen = Route::is('admin.tenaga_medis.index') || Route::is('admin.spesialis.index') || Route::is('admin.asuransi.index') || Route::is('admin.poliklinik.index') || Route::is('forms.diagnosa') || Route::is('forms.master_bridging'); @endphp
        <li class="rs-nav-parent {{ $masterOpen ? 'open' : '' }}">
            <button class="rs-nav-link rs-nav-toggle {{ $masterOpen ? 'active' : '' }}">
                <i class="fas fa-database nav-icon-rs"></i>
                Master Data
                <i class="fas fa-chevron-right rs-chevron"></i>
            </button>
            <ul class="rs-submenu">
                <li>
                    <a href="{{ route('admin.tenaga_medis.index') }}"
                       class="rs-nav-link {{ Route::is('admin.tenaga_medis.index') ? 'active' : '' }}">
                        <i class="fas fa-user-md nav-icon-rs"></i>
                        Tenaga Medis
                        <span class="rs-nav-badge green">{{ $TenagaMedisCount }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.poliklinik.index') }}"
                       class="rs-nav-link {{ Route::is('admin.poliklinik.index') ? 'active' : '' }}">
                        <i class="fas fa-clinic-medical nav-icon-rs"></i>
                        Poliklinik
                        <span class="rs-nav-badge green">{{ $PoliCount }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.spesialis.index') }}"
                       class="rs-nav-link {{ Route::is('admin.spesialis.index') ? 'active' : '' }}">
                        <i class="fas fa-user-nurse nav-icon-rs"></i>
                        Spesialis
                        <span class="rs-nav-badge green">{{ $SpesialisCount }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.asuransi.index') }}"
                       class="rs-nav-link {{ Route::is('admin.asuransi.index') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt nav-icon-rs"></i>
                        Asuransi
                        <span class="rs-nav-badge green">{{ $AsuransiCount }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('forms.diagnosa') }}"
                       class="rs-nav-link {{ Route::is('forms.diagnosa') ? 'active' : '' }}">
                        <i class="fas fa-stethoscope nav-icon-rs"></i>
                        Diagnosa
                    </a>
                </li>
                <li>
                    <a href="{{ route('forms.master_bridging') }}"
                       class="rs-nav-link {{ Route::is('forms.master_bridging') ? 'active' : '' }}">
                        <i class="fas fa-link nav-icon-rs"></i>
                        Master Bridging
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    {{-- ── TARIF & HARGA ── --}}
    <p class="rs-nav-header">Tarif & Harga</p>
    <ul class="rs-nav-list">
        @php $tarifOpen = Route::is('admin.procedures.*') || Route::is('admin.js_procedures.*') || Route::is('forms.jenis_harga'); @endphp
        <li class="rs-nav-parent {{ $tarifOpen ? 'open' : '' }}">
            <button class="rs-nav-link rs-nav-toggle {{ $tarifOpen ? 'active' : '' }}">
                <i class="fas fa-dollar-sign nav-icon-rs"></i>
                Data Harga
                <i class="fas fa-chevron-right rs-chevron"></i>
            </button>
            <ul class="rs-submenu">
                <li>
                    <a href="{{ route('admin.procedures.index') }}"
                       class="rs-nav-link {{ Route::is('admin.procedures.index') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar nav-icon-rs"></i>
                        Procedure Harga
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.js_procedures.index') }}"
                       class="rs-nav-link {{ Route::is('admin.js_procedures.index') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list nav-icon-rs"></i>
                        Jenis Procedure
                    </a>
                </li>
                <li>
                    <a href="{{ route('forms.jenis_harga') }}"
                       class="rs-nav-link {{ Route::is('forms.jenis_harga') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave nav-icon-rs"></i>
                        Jenis Harga
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    @endrole

    {{-- ── PENGATURAN ── --}}
    <p class="rs-nav-header">Pengaturan</p>
    <ul class="rs-nav-list">
        <li>
            <a href="{{ route('admin.profile.edit') }}"
               class="rs-nav-link {{ Route::is('admin.profile.edit') ? 'active' : '' }}">
                <i class="fas fa-user-circle nav-icon-rs"></i>
                Profil
            </a>
        </li>
    </ul>

</nav>

<script>
document.querySelectorAll('.rs-nav-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
        const parent = this.closest('.rs-nav-parent');
        const isOpen = parent.classList.contains('open');
        // Tutup semua yang lain di level yang sama
        parent.closest('.rs-nav-list').querySelectorAll('.rs-nav-parent.open').forEach(el => {
            if (el !== parent) el.classList.remove('open');
        });
        parent.classList.toggle('open', !isOpen);
    });
});
</script>
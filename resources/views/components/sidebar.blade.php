<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- Group: Umum --}}
        <li class="nav-header">UMUM</li>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ Route::is('admin.pendaftaran.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-plus"></i>
                <p>Registrasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.pasien.index') }}" class="nav-link {{ Route::is('admin.pasien.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-id-card-alt"></i>
                <p>Profile Rekam Medis</p>
            </a>
        </li>

        {{-- Group: Asesmen --}}
        <li class="nav-header">ASESMEN</li>
        <li class="nav-item has-treeview {{ Route::is('admin.asesmen_perawat.*') || Route::is('forms.asesmen_medis') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('admin.asesmen_perawat.*') || Route::is('forms.asesmen_medis') ? 'active' : '' }}">
                <i class="nav-icon fas fa-notes-medical"></i>
                <p>Asesmen <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview pl-3">
                <li class="nav-item">
                    <a href="{{ route('admin.asesmen_perawat.index') }}" class="nav-link {{ Route::is('admin.asesmen_perawat.*') ? 'active' : '' }}">
                        <i class="fas fa-user-nurse nav-icon"></i> Asesmen Perawat
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('forms.asesmen_medis') }}" class="nav-link {{ Route::is('forms.asesmen_medis') ? 'active' : '' }}">
                        <i class="fas fa-user-md nav-icon"></i> Asesmen Medis
                    </a>
                </li>
            </ul>
        </li>

        {{-- Group: Dokumen --}}
        <li class="nav-header">DOKUMEN</li>
        <li class="nav-item has-treeview {{ Route::is('admin.collection.index') || Route::is('admin.category.index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('admin.collection.index') || Route::is('admin.category.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-medical"></i>
                <p>Dokumen <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview pl-3">
                <li class="nav-item">
                    <a href="{{ route('admin.collection.index') }}" class="nav-link {{ Route::is('admin.collection.index') ? 'active' : '' }}">
                        <i class="fas fa-file nav-icon"></i> Dokumen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.category.index') }}" class="nav-link {{ Route::is('admin.category.index') ? 'active' : '' }}">
                        <i class="fas fa-tags nav-icon"></i> Kategori
                    </a>
                </li>
            </ul>
        </li>

        {{-- Group: Obat --}}
        <li class="nav-header">FARMASI</li>
        <li class="nav-item has-treeview {{ Route::is('admin.obat.*') || Route::is('admin.satuan_obat.*') || Route::is('admin.formula.*') || Route::is('forms.golongan_obat') || Route::is('forms.telaah_farmasi') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('admin.obat.*') || Route::is('admin.satuan_obat.*') || Route::is('admin.formula.*') || Route::is('forms.golongan_obat') || Route::is('forms.telaah_farmasi') ? 'active' : '' }}">
                <i class="nav-icon fas fa-pills"></i>
                <p>Data Obat <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview pl-3">
                <li class="nav-item">
                    <a href="{{ route('admin.obat.index') }}" class="nav-link {{ Route::is('admin.obat.index') ? 'active' : '' }}">
                        <i class="fas fa-capsules nav-icon"></i> Barang Farmasi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.satuan_obat.index') }}" class="nav-link {{ Route::is('admin.satuan_obat.index') ? 'active' : '' }}">
                        <i class="fas fa-balance-scale nav-icon"></i> Data Satuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.formula.index') }}" class="nav-link {{ Route::is('admin.formula.index') ? 'active' : '' }}">
                        <i class="fas fa-flask nav-icon"></i> Formula
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('forms.golongan_obat') }}" class="nav-link {{ Route::is('forms.golongan_obat') ? 'active' : '' }}">
                        <i class="fas fa-flask nav-icon"></i> Golongan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('forms.telaah_farmasi') }}" class="nav-link {{ Route::is('forms.telaah_farmasi') ? 'active' : '' }}">
                        <i class="fas fa-check-double nav-icon"></i> Telaah Farmasi
                    </a>
                </li>
            </ul>
        </li>

        {{-- Group: Admin Master --}}
        @role('admin')
        <li class="nav-header">ADMINISTRATOR</li>
        <li class="nav-item">
            <a href="{{ route('admin.user.index') }}" class="nav-link {{ Route::is('admin.user.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users-cog"></i> <p>Pengguna <span class="badge badge-info right">{{ $userCount }}</span></p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.role.index') }}" class="nav-link {{ Route::is('admin.role.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-shield"></i> <p>Role <span class="badge badge-success right">{{ $RoleCount }}</span></p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.permission.index') }}" class="nav-link {{ Route::is('admin.permission.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-unlock-alt"></i> <p>Role Akses <span class="badge badge-danger right">{{ $PermissionCount }}</span></p>
            </a>
        </li>

        {{-- Group: Master Data --}}
        <li class="nav-header">MASTER DATA</li>
        <li class="nav-item has-treeview {{ Route::is('admin.dokter.index') || Route::is('admin.spesialis.index') || Route::is('admin.asuransi.index') || Route::is('admin.poliklinik.index') || Route::is('forms.diagnosa') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('admin.dokter.index') || Route::is('admin.spesialis.index') || Route::is('admin.asuransi.index') || Route::is('admin.poliklinik.index') || Route::is('forms.diagnosa') ? 'active' : '' }}">
                <i class="nav-icon fas fa-database"></i>
                <p>Master Data <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview pl-3">
                <li class="nav-item"><a href="{{ route('admin.dokter.index') }}" class="nav-link {{ Route::is('admin.dokter.index') ? 'active' : '' }}"><i class="fas fa-user-md nav-icon"></i> Dokter <span class="badge badge-success right">{{ $DokterCount }}</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.poliklinik.index') }}" class="nav-link {{ Route::is('admin.poliklinik.index') ? 'active' : '' }}"><i class="fas fa-clinic-medical nav-icon"></i> Poli <span class="badge badge-success right">{{ $PoliCount }}</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.spesialis.index') }}" class="nav-link {{ Route::is('admin.spesialis.index') ? 'active' : '' }}"><i class="fas fa-user-nurse nav-icon"></i> Spesialis <span class="badge badge-success right">{{ $SpesialisCount }}</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.asuransi.index') }}" class="nav-link {{ Route::is('admin.asuransi.index') ? 'active' : '' }}"><i class="fas fa-shield-alt nav-icon"></i> Asuransi <span class="badge badge-success right">{{ $AsuransiCount }}</span></a></li>
                <li class="nav-item"><a href="{{ route('forms.diagnosa') }}" class="nav-link {{ Route::is('forms.diagnosa') ? 'active' : '' }}"><i class="fas fa-stethoscope nav-icon"></i> Diagnosa</a></li>
            </ul>
        </li>

        {{-- Group: Harga --}}
        <li class="nav-header">TARIF & HARGA</li>
        <li class="nav-item has-treeview {{ Route::is('admin.procedures.*') || Route::is('admin.js_procedures.*') || Route::is('forms.jenis_harga') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('admin.procedures.*') || Route::is('admin.js_procedures.*') || Route::is('forms.jenis_harga') ? 'active' : '' }}">
                <i class="nav-icon fas fa-dollar-sign"></i>
                <p>Data Harga <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview pl-3">
                <li class="nav-item"><a href="{{ route('admin.procedures.index') }}" class="nav-link {{ Route::is('admin.procedures.index') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar nav-icon"></i> Procedure Harga</a></li>
                <li class="nav-item"><a href="{{ route('admin.js_procedures.index') }}" class="nav-link {{ Route::is('admin.js_procedures.index') ? 'active' : '' }}"><i class="fas fa-clipboard-list nav-icon"></i> Jenis Procedure</a></li>
                <li class="nav-item"><a href="{{ route('forms.jenis_harga') }}" class="nav-link {{ Route::is('forms.jenis_harga') ? 'active' : '' }}"><i class="fas fa-money-bill-wave nav-icon"></i> Jenis Harga</a></li>
            </ul>
        </li>
        @endrole

        {{-- Group: Profil --}}
        <li class="nav-header">PENGATURAN</li>
        <li class="nav-item">
            <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ Route::is('admin.profile.edit') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>Profil</p>
            </a>
        </li>

    </ul>
</nav>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <!-- Menu Registrasi -->
        <li class="nav-item">
            <a href="{{ route('admin.pendaftaran.index') }}"
                class="nav-link {{ Route::is('admin.pendaftaran.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-plus"></i>
                <p>Registrasi</p>
            </a>
        </li>

        <!-- Menu Asesmen -->
        <li class="nav-item has-treeview {{ Route::is('admin.asesmen_perawat.*') || Route::is('forms.asesmen_medis.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Route::is('admin.asesmen_perawat.*') || Route::is('forms.asesmen_medis.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-notes-medical"></i>
                <p>
                    Asesmen
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Sub-menu Asesmen Perawat -->
                <li class="nav-item">
                    <a href="{{ route('admin.asesmen_perawat.index') }}"
                        class="nav-link {{ Route::is('admin.asesmen_perawat.*') ? 'active' : '' }}">
                        <i class="fas fa-user-nurse nav-icon"></i>
                        <p>Asesmen Perawat</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <!-- Sub-menu Asesmen Medis -->
                <li class="nav-item">
                    <a href="{{ route('forms.asesmen_medis') }}"
                        class="nav-link {{ Route::is('forms.asesmen_medis.*') ? 'active' : '' }}">
                        <i class="fas fa-user-md nav-icon"></i>
                        <p>Asesmen Medis</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="{{ route('admin.pasien.index') }}"
                class="nav-link {{ Route::is('admin.pasien.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-id-card-alt"></i>
                <p>Profile Rekam Medis</p>
            </a>
        </li>
        <li
            class="nav-item has-treeview {{ Route::is('admin.collection.index') || Route::is('admin.category.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Route::is('admin.collection.index') || Route::is('admin.category.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-medical"></i>
                <p>
                    Dokumen
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Submenu Dokumen -->
                <li class="nav-item">
                    <a href="{{ route('admin.collection.index') }}"
                        class="nav-link {{ Route::is('admin.collection.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Dokumen</p>
                    </a>
                </li>
                <!-- Submenu Dokumen Kategori -->
                <li class="nav-item">
                    <a href="{{ route('admin.category.index') }}"
                        class="nav-link {{ Route::is('admin.category.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Dokumen Kategori</p>
                    </a>
                </li>
            </ul>
        </li>

        @role('admin')
        <li class="nav-item">
            <a href="{{ route('admin.user.index') }}"
                class="nav-link {{ Route::is('admin.user.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>Pengguna
                    <span class="badge badge-info right">{{ $userCount }}</span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.role.index') }}"
                class="nav-link {{ Route::is('admin.role.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>Role
                    <span class="badge badge-success right">{{ $RoleCount }}</span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.permission.index') }}"
                class="nav-link {{ Route::is('admin.permission.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-unlock-alt"></i>
                <p>Role Akses
                    <span class="badge badge-danger right">{{ $PermissionCount }}</span>
                </p>
            </a>
        </li>

        <li
            class="nav-item has-treeview {{ Route::is('admin.dokter.index') || Route::is('admin.spesialis.index') || Route::is('admin.asuransi.index') || Route::is('admin.poliklinik.index') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Route::is('admin.dokter.index') || Route::is('admin.spesialis.index') || Route::is('admin.asuransi.index') || Route::is('admin.poliklinik.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-database"></i>
                <p>
                    Master Data
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.dokter.index') }}"
                        class="nav-link {{ Route::is('admin.dokter.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>Dokter</p>
                        <span class="badge badge-success right">{{ $DokterCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.poliklinik.index') }}"
                        class="nav-link {{ Route::is('admin.poliklinik.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clinic-medical"></i>
                        <p>Poli</p>
                        <span class="badge badge-success right">{{ $PoliCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.spesialis.index') }}"
                        class="nav-link {{ Route::is('admin.spesialis.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-nurse"></i>
                        <p>Spesialis</p>
                        <span class="badge badge-success right">{{ $SpesialisCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.asuransi.index') }}"
                        class="nav-link {{ Route::is('admin.asuransi.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>Asuransi</p>
                        <span class="badge badge-success right">{{ $AsuransiCount }}</span>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="nav-item has-treeview {{ Route::is('admin.procedures.*') || Route::is('admin.js_procedures.*') || Route::is('forms.jenis_harga') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Route::is('admin.procedures.*') || Route::is('admin.js_procedures.*') || Route::is('forms.jenis_harga') ? 'active' : '' }}">
                <i class="nav-icon fas fa-dollar-sign"></i>
                <p>
                    Data Harga
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.procedures.index') }}"
                        class="nav-link {{ Route::is('admin.procedures.index') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar nav-icon"></i>
                        <p>Master Procedure Harga</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.js_procedures.index') }}"
                        class="nav-link {{ Route::is('admin.js_procedures.index') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <p>Jenis Procedure</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('forms.jenis_harga') }}"
                        class="nav-link {{ Route::is('forms.jenis_harga') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave nav-icon"></i>
                        <p>Jenis Harga Tarif</p>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="nav-item has-treeview {{ Route::is('admin.obat.*') || Route::is('admin.satuan_obat.*') || Route::is('admin.formula.*') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ Route::is('admin.obat.*') || Route::is('admin.satuan_obat.*') || Route::is('admin.formula.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-pills"></i>
                <p>
                    Data Obat
                    <i class="right fas fa-angle-left"></i>
                    <span class="badge badge-success right">{{ $DataObatCount }}</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.obat.index') }}"
                        class="nav-link {{ Route::is('admin.obat.index') ? 'active' : '' }}">
                        <i class="fas fa-capsules nav-icon"></i>
                        <p>Barang Farmasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.satuan_obat.index') }}"
                        class="nav-link {{ Route::is('admin.satuan_obat.*') ? 'active' : '' }}">
                        <i class="fas fa-balance-scale nav-icon"></i>
                        <p>Data Satuan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.formula.index') }}"
                        class="nav-link {{ Route::is('admin.formula.*') ? 'active' : '' }}">
                        <i class="fas fa-flask nav-icon"></i>
                        <p>Formula</p>
                    </a>
                </li>
            </ul>
        </li>
        @endrole

        <li class="nav-item">
            <a href="{{ route('admin.profile.edit') }}"
                class="nav-link {{ Route::is('admin.profile.edit') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>Profil</p>
            </a>
        </li>
    </ul>
</nav>
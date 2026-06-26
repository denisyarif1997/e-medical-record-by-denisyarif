<x-admin>
    @section('title', 'Cari Pasien')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Cari Pasien</h3>
            <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary btn-sm">Buat Rekam Medis</a>
        </div>
        <div class="card-body">
            <!-- Form Pencarian Pasien (lebih ringkas dan responsif) -->
            <form action="{{ route('admin.pendaftaran.cari_pasien') }}" method="GET" class="mb-3">
                <div class="form-row d-flex">
                    <div class="col-md-3 mb-2">
                        <label for="filter_by">Cari Berdasarkan</label>
                        <select name="filter_by" id="filter_by" class="form-control">
                            <option value="id" {{ request('filter_by') == 'id' ? 'selected' : '' }}>No. Rekam Medis</option>
                            <option value="nama" {{ request('filter_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                            <option value="nik" {{ request('filter_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                            <option value="tanggal_lahir" {{ request('filter_by') == 'tanggal_lahir' ? 'selected' : '' }}>Tanggal Lahir</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="search">Kata Kunci</label>
                        <input type="text" name="search" id="search_input" class="form-control" placeholder="Masukkan kata kunci atau pilih tanggal" value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end mb-2 gap-2">
                        <button type="submit" class="btn btn-secondary">Cari</button>
                        <a href="{{ route('admin.pendaftaran.cari_pasien') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <!-- @php
                $pasiens = $pasiens ?? \App\Models\Pasien::orderBy('created_at', 'desc')->take(50)->get();
            @endphp -->

            @if(request()->has('search'))
                <h5 class="mb-3">Hasil Pencarian ({{ $pasiens->count() }} hasil)</h5>
            @else
                <h5 class="mb-3">50 Data Pasien Terakhir</h5>
            @endif

            <div class="table-responsive mb-3">
                <table class="table table-hover table-striped table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Nama Pasien</th>
                            <th>No Rekam Medis</th>
                            <th>NIK</th>
                            <th>Tanggal Lahir</th>
                            <th>Di Buat</th>
                            <th style="width:10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasiens as $index => $pasien)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pasien->nama }}</td>
                                <td>{{ $pasien->no_rekam_medis }}</td>
                                <td>{{ $pasien->nik }}</td>
                                <td>{{ optional($pasien->tanggal_lahir)->format('Y-m-d') ?? $pasien->tanggal_lahir }}</td>
                                <td>{{ optional($pasien->created_at)->format('Y-m-d') ?? $pasien->created_at }}</td>
                                <td>
                                    <form action="{{ route('admin.pendaftaran.create') }}" method="GET" style="display:inline;">
                                        <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                                        <button type="submit" class="btn btn-success btn-sm">Pilih</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada pasien.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-muted small">
                Tip: gunakan filter & kata kunci untuk mempersempit hasil, atau biarkan kosong untuk melihat 50 pasien terbaru.
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterBySelect = document.getElementById('filter_by');
            const searchInput = document.getElementById('search_input');
            const originalPlaceholder = 'Masukkan kata kunci';

            function toggleSearchInputType() {
                const currentFilter = filterBySelect.value;
                let currentValue = searchInput.value;

                if (currentFilter === 'tanggal_lahir') {
                    searchInput.type = 'date';
                    searchInput.placeholder = '';
                    if (currentValue && !/^\d{4}-\d{2}-\d{2}$/.test(currentValue)) {
                        searchInput.value = '';
                    }
                } else {
                    searchInput.type = 'text';
                    searchInput.placeholder = originalPlaceholder;
                }
            }

            toggleSearchInputType();
            filterBySelect.addEventListener('change', toggleSearchInputType);
        });
    </script>
</x-admin>

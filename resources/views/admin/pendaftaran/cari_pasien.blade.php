<x-admin>
    @section('title', 'Cari Pasien')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cari Pasien</h3>
        </div>
        <div class="card-body">
            <!-- Form Pencarian Pasien -->
            <form action="{{ route('admin.pendaftaran.cari_pasien') }}" method="GET">
                <div class="form-group">
                    <label for="filter_by">Cari Berdasarkan</label>
                    <select name="filter_by" id="filter_by" class="form-control mb-2">
                        <option value="id" {{ request('filter_by') == 'id' ? 'selected' : '' }}>No. Rekam Medis</option>
                        <option value="nama" {{ request('filter_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                        <option value="nik" {{ request('filter_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                        <option value="tanggal_lahir" {{ request('filter_by') == 'tanggal_lahir' ? 'selected' : '' }}>Tanggal Lahir</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="search">Kata Kunci</label>
                    <input type="text" name="search" id="search_input" class="form-control" placeholder="Masukkan kata kunci" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-secondary mb-3">Cari</button>
                <a href="{{ route('admin.pasien.create') }}" class="btn btn-secondary mb-3">Buat Rekam Medis</a>
            </form>

            <!-- Hasil Pencarian Pasien hanya muncul jika ada input pencarian -->
            @if(request()->has('search') && $pasiens->isNotEmpty())
                <h5>Hasil Pencarian:</h5>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>No Rekam Medis</th>
                                <th>NIK</th>
                                <th>Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pasiens as $index => $pasien)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pasien->nama }}</td>
                                    <td>{{ $pasien->no_rekam_medis }}</td>
                                    <td>{{ $pasien->nik }}</td>
                                    <td>{{ $pasien->tanggal_lahir }}</td>
                                    <td>
                                        <form action="{{ route('admin.pendaftaran.create') }}" method="GET" style="display:inline;">
                                            <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                                            <button type="submit" class="btn btn-success btn-sm">Pilih Pasien</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(request()->has('search'))
                <p>Tidak ada pasien yang ditemukan.</p>
            @endif
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
                // If current value is not a valid YYYY-MM-DD date, clear it
                if (currentValue && !/^\d{4}-\d{2}-\d{2}$/.test(currentValue)) {
                    searchInput.value = ''; 
                }
            } else {
                searchInput.type = 'text';
                searchInput.placeholder = originalPlaceholder;
                // If current value is a date string (from previous selection), clear it or restore general search
                if (currentValue && /^\d{4}-\d{2}-\d{2}$/.test(currentValue)) {
                    // searchInput.value = ''; // Optionally clear or restore a non-date search term
                }
            }
        }

        // Initial check on page load to set the correct input type and value handling
        toggleSearchInputType();

        // Event listener for changes on the select dropdown
        filterBySelect.addEventListener('change', toggleSearchInputType);
    });
</script>
</x-admin>

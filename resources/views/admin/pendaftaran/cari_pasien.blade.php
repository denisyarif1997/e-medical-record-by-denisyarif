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
            </form>

            <!-- Hasil Pencarian Pasien hanya muncul jika ada input pencarian -->
            @if(request()->has('search') && $pasiens->isNotEmpty())
                <h5>Hasil Pencarian:</h5>
                <ul class="list-group mb-3">
                    @foreach($pasiens as $pasien)
                        <li class="list-group-item">
                            <div class="form-group">
                                <label for="nama_pasien">Nama Pasien:</label>
                                <input type="text" name="nama_pasien" class="form-control" value="{{ $pasien->nama }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="id">No Rekam Medis:</label>
                                <input type="text" name="id" class="form-control" value="{{ $pasien->no_rekam_medis }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK:</label>
                                <input type="text" name="nik" class="form-control" value="{{ $pasien->nik }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir:</label>
                                <input type="text" name="tanggal_lahir" class="form-control" value="{{ $pasien->tanggal_lahir }}" readonly>
                            </div>
                            <form action="{{ route('admin.pendaftaran.create') }}" method="GET">
                                <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                                <button type="submit" class="btn btn-success btn-sm">Pilih Pasien</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
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

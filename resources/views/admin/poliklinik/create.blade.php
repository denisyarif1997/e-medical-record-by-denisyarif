<x-admin>
    @section('title', 'Tambah Poliklinik')

    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.poliklinik.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.poliklinik.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Poliklinik</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="form-group">
                    <label for="dokter_id">Dokter</label>
                    <select name="dokter_id" id="dokter_id" class="form-control" required>
                        <option value="">Pilih Dokter</option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="waktu_mulai">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control" value="{{ old('waktu_mulai') }}" required>
                </div>

                <div class="form-group">
                    <label for="waktu_selesai">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control" value="{{ old('waktu_selesai') }}" required>
                </div>

                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select name="hari" id="hari" class="form-control" required>
                        <option value="" disabled selected>Pilih Hari</option>
                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                </div>
                

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

</x-admin>

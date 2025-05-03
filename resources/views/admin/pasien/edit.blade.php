<x-admin>
    @section('title', 'Edit Pasien')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Pasien</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pasien.update', encrypt($pasien->id)) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="no_rekam_medis">No Rekam Medis</label>
                    <input type="text" name="no_rekam_medis" id="no_rekam_medis" class="form-control" value="{{ old('no_rekam_medis', $pasien->no_rekam_medis) }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $pasien->nik) }}">
                </div>

                <div class="mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pasien->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
                </div>

                <div class="mb-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $pasien->alamat) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $pasien->no_hp) }}">
                </div>

                <div class="mb-3">
                    <label for="penanggung">Penanggung</label>
                    <input type="text" name="penanggung" id="penanggung" class="form-control" value="{{ old('penanggung', $pasien->penanggung) }}">
                </div>

                <div class="mb-3">
                    <label for="no_asuransi">No Asuransi</label>
                    <input type="text" name="no_asuransi" id="no_asuransi" class="form-control" value="{{ old('no_asuransi', $pasien->no_asuransi) }}">
                </div>

                <div class="mb-3">
                    <label for="asuransi_id">Asuransi</label>
                    <select name="asuransi_id" id="asuransi_id" class="form-control" required>
                        <option value="">Pilih Asuransi</option>
                        @foreach ($asuransis as $asuransi)
                            <option value="{{ $asuransi->id }}" {{ old('asuransi_id', $pasien->asuransi_id) == $asuransi->id ? 'selected' : '' }}>
                                {{ $asuransi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                

                <button type="submit" class="btn btn-warning">Perbarui</button>
                <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-admin>

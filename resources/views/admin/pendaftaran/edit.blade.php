<x-admin>
    @section('title', 'Edit Pendaftaran Pasien')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Pendaftaran Pasien</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pendaftaran.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tanggal Daftar -->
                <div class="form-group">
                    <label for="tanggal_daftar">Tanggal Daftar</label>
                    <input type="date" name="tanggal_daftar" class="form-control" id="tanggal_daftar"
                        value="{{ old('tanggal_daftar', $data->tanggal_daftar) }}" required>
                </div>

                <!-- Nama Pasien -->
                <div class="form-group">
                    <label for="pasien_id">Nama Pasien</label>
                    <input type="text" name="nama_pasien" class="form-control" value="{{ $pasien->nama ?? '' }}"
                        readonly>
                    <input type="hidden" name="pasien_id" value="{{ $pasien->id ?? '' }}">
                </div>

                <!-- Pilih Asuransi -->
                <div class="form-group">
                    <label for="asuransi_id">Asuransi (Mengambil dari data rekam Medis)</label>
                    <select name="asuransi_id" class="form-control" required>
                        @foreach($asuransis as $asuransi)
                            <option value="{{ $asuransi->id }}" @if($data->id_asuransi == $asuransi->id) selected @endif>
                                {{ $asuransi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- No Asuransi -->
                <div class="form-group">
                    <label for="no_asuransi">No Asuransi</label>
                    <input type="text" name="no_asuransi" class="form-control" value="{{ old('no_asuransi', $data->no_asuransi) }}" required>
                </div>

                <!-- Pilih Dokter -->
                <div class="form-group">
                    <label for="dokter_id">Dokter</label>
                    <select name="dokter_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Dokter</option>
                        @foreach($dokters as $dokter)
                            <option value="{{ $dokter->id }}" 
                                {{ old('dokter_id', $data->dokter_id) == $dokter->id ? 'selected' : '' }}>
                                {{ $dokter->dokter_nama }} - {{ $dokter->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Poli ID otomatis diisi berdasarkan dokter yang dipilih -->
                <input type="hidden" name="poli_id"
                    value="{{ old('dokter_id', $data->dokter_id) ? $dokters->firstWhere('id', old('dokter_id', $data->dokter_id))->poli_id ?? '' : '' }}">

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" required>
                        <option value="1" selected>Aktif</option>
                        <option value="2" selected>Status Batal</option>

                    </select>
                    <input type="hidden" name="status" value="1">
                </div>

                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</x-admin>

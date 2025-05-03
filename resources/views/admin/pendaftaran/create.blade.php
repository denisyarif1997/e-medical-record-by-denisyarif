<x-admin>
    @section('title', 'Pendaftaran Pasien')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pendaftaran Pasien Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pendaftaran.store') }}" method="POST">
                @csrf
                <!-- Tanggal Daftar -->
                <div class="form-group">
                    <label for="tanggal_daftar">Tanggal Daftar</label>
                    <input type="date" name="tanggal_daftar" class="form-control" id="tanggal_daftar"
                        value="{{ old('tanggal_daftar', date('Y-m-d')) }}">
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
                    <label for="asuransi_id">Asuransi</label>
                    <select name="asuransi_id" class="form-control" required>
                        @foreach($asuransis as $asuransi)
                            <option value="{{ $asuransi->id }}" @if(isset($pasien) && $pasien->asuransi_id == $asuransi->id)
                            selected @endif>
                                {{ $asuransi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- No Asuransi -->
                <div class="form-group">
                    <label for="no_asuransi">No Asuransi</label>
                    <input type="text" name="no_asuransi" class="form-control" value="{{ $pasien->no_asuransi ?? '' }}"
                        required>
                </div>


                <!-- Pilih Dokter -->
                <div class="form-group">
                    <label for="dokter_id">Dokter</label>
                    <select name="dokter_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Dokter</option>
                        @foreach($dokters as $dokter)
                            <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                {{ $dokter->dokter_nama }} - {{ $dokter->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" disabled>
                        <option value="1" selected>Aktif</option>
                    </select>
                    <input type="hidden" name="status" value="1">
                </div>

                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
        </div>
    </div>

</x-admin>
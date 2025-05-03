<x-admin>
    @section('title', 'Tambah Asesmen Perawat')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Asesmen Perawat</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.asesmen_perawat.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="id_regis">Pendaftaran</label>
                    <select name="id_regis" id="id_regis" class="form-control" required>
                        <option value="">Pilih Pendaftaran</option>
                        @foreach($pendaftarans as $pendaftaran)
                            <option value="{{ $pendaftaran->id }}">{{ $pendaftaran->nama_pasien }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tujuan_kunjungan">Tujuan Kunjungan</label>
                    <input type="text" name="tujuan_kunjungan" id="tujuan_kunjungan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="keluhan_utama">Keluhan Utama</label>
                    <input type="text" name="keluhan_utama" id="keluhan_utama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ttv">TTV</label>
                    <textarea name="ttv" id="ttv" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</x-admin>

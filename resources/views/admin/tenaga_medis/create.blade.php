<x-admin>
    @section('title','Tambah Tenaga Medis')
    <form action="{{ route('admin.tenaga_medis.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Tenaga Medis</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tipe</label>
                    <select name="type" class="form-control" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Dokter">Dokter</option>
                        <option value="Perawat">Perawat</option>
                        <option value="Bidan">Bidan</option>
                        <option value="Farmasi">Farmasi</option>
                        <option value="Laboratorium">Laboratorium</option>
                        <option value="Radiografer">Radiografer</option>
                        <option value="Administrasi">Administrasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>
                <div class="form-group">
                    <label>Spesialis</label>
                    <select name="spec_code" class="form-control" required>
                        <option value="">-- Pilih Spesialis --</option>
                        @foreach($spesialis as $spec)
                            <option value="{{ $spec->code }}">{{ $spec->nama_spesialis }}</option>
                        @endforeach
                    </select>
                </div>
                 <div class="form-group">
                    <label>Str</label>
                    <input type="text" name="str" class="form-control">
                </div>
                 <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.tenaga_medis.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</x-admin>
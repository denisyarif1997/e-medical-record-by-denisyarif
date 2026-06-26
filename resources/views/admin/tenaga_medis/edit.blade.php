<x-admin>
    @section('title','Edit Tenaga Medis')
    <form action="{{ route('admin.tenaga_medis.update', encrypt($tenagaMedis->id)) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Tenaga Medis</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $tenagaMedis->nama }}" required>
                </div>
                <div class="form-group">
                    <label>Tipe</label>
                    <select name="type" class="form-control" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Dokter" {{ $tenagaMedis->type == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="Perawat" {{ $tenagaMedis->type == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                        <option value="Bidan" {{ $tenagaMedis->type == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                        <option value="Farmasi" {{ $tenagaMedis->type == 'Farmasi' ? 'selected' : '' }}>Farmasi</option>
                        <option value="Laboratorium" {{ $tenagaMedis->type == 'Laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                        <option value="Radiografer" {{ $tenagaMedis->type == 'Radiografer' ? 'selected' : '' }}>Radiografer</option>
                        <option value="Administrasi" {{ $tenagaMedis->type == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                        <option value="Lainnya" {{ $tenagaMedis->type == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $tenagaMedis->no_hp }}">
                </div>
                <div class="form-group">
                    <label>Spesialis</label>
                    <select name="spec_code" class="form-control" required>
                        <option value="">-- Pilih Spesialis --</option>
                        @foreach($spesialis as $spec)
                            <option value="{{ $spec->code }}" {{ $spec->code == $tenagaMedis->spec_code ? 'selected' : '' }}>
                                {{ $spec->nama_spesialis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                 <div class="form-group">
                    <label>STR</label>
                    <input type="text" name="str" class="form-control" value="{{ $tenagaMedis->str }}">
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ $tenagaMedis->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $tenagaMedis->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.tenaga_medis.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</x-admin>
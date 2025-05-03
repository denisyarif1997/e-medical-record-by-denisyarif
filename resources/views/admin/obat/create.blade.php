<x-admin>
    @section('title', 'Tambah Obat')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Obat</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.obat.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="kode_obat">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control" value="{{ old('kode_obat') }}" required>
                </div>

                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" required>
                </div>

                <div class="form-group">
                    <label for="bentuk_sediaan">Bentuk Sediaan</label>
                    <input type="text" name="bentuk_sediaan" class="form-control" value="{{ old('bentuk_sediaan') }}">
                </div>

                <div class="form-group">
                    <label for="golongan">Golongan</label>
                    <input type="text" name="golongan" class="form-control" value="{{ old('golongan') }}">
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}">
                </div>

                <div class="form-group">
                    <label for="formula_id">Formula</label>
                    <select name="formula_id" class="form-control" required>
                        <option value="">Pilih Formula</option>
                        @foreach($formulas as $formula)
                            <option value="{{ $formula->id }}" {{ old('formula_id') == $formula->id ? 'selected' : '' }}>
                                {{ $formula->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" value="{{ old('harga_beli') }}" required>
                </div>

                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" required>
                </div>

                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}">
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</x-admin>

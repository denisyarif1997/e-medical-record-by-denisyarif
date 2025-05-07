<x-admin>
    @section('title', 'Edit Obat')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Obat</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="kode_obat">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control" value="{{ $obat->kode_obat }}" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
                </div>

                <div class="form-group">
                    <label for="bentuk_sediaan">Bentuk Sediaan</label>
                    <input type="text" name="bentuk_sediaan" class="form-control" value="{{ $obat->bentuk_sediaan }}">
                </div>

                <div class="form-group">
                    <label for="golongan">Golongan</label>
                    <input type="text" name="golongan" class="form-control" value="{{ $obat->golongan }}">
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ $obat->kategori }}">
                </div>

                <div class="form-group">
                    <label for="formula_id">Formula</label>
                    <select name="formula_id" class="form-control" required>
                        <option value="">Pilih Formula</option>
                        @foreach($formulas as $formula)
                            <option value="{{ $formula->id }}" {{ $obat->formula_id == $formula->id ? 'selected' : '' }}>
                                {{ $formula->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" value="{{ $obat->harga_beli }}" required>
                </div>

                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ $obat->stok }}" required>
                </div>

                 <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <select name="satuan" class="form-control" required>
                        <option value="">Pilih Satuan</option>
                        @foreach($satuan as $satuans)
                            <option value="{{ $satuans->id }}" {{ $obat->satuan == $satuans->id ? 'selected' : '' }}>
                                {{ $satuans->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</x-admin>

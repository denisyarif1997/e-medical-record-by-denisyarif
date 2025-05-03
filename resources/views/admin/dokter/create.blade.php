<x-admin>
    @section('title','Tambah Dokter')
    <form action="{{ route('admin.dokter.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Dokter</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" name="nama" class="form-control" required>
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
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</x-admin>

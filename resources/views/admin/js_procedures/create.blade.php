<x-admin>
    @section('title', 'Tambah Jenis Procedure')

    <div class="container mt-4">
        <h3>Tambah Jenis Procedure</h3>
        <form action="{{ route('admin.js_procedures.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Jenis Procedure</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="status" class="form-check-input" id="status" checked>
                <label class="form-check-label" for="status">Aktif</label>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.js_procedures.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-admin>

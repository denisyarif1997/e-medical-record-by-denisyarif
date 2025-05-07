<x-admin>
    @section('title','Tambah Formula')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Formula</h3>
                    <a href="{{ route('admin.formula.index') }}" class="btn btn-info btn-sm float-right">Back</a>
                </div>
                <form action="{{ route('admin.formula.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama Formula</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                            {{-- <x-error>nama</x-error> --}}
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan') }}" required>
                            {{-- <x-error>nama</x-error> --}}
                        </div>
                        <div class="form-group">
                            <label for="faktor">Faktor</label>
                            <input type="number" name="faktor" id="faktor" class="form-control" value="{{ old('faktor') }}" required step="any" min="0">
                            {{-- <x-error>nama</x-error> --}}
                        </div>
                        {{-- <div class="form-group">
                            <label for="code">Kode</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                            <x-error>code</x-error>
                        </div> --}}
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>

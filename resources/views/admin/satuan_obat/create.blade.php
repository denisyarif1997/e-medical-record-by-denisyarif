<x-admin>
    @section('title','Tambah Satuan Obat')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Satuan Obat</h3>
                    <a href="{{ route('admin.satuan_obat.index') }}" class="btn btn-info btn-sm float-right">Back</a>
                </div>
                <form action="{{ route('admin.satuan_obat.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama Satuan Obat</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                            <x-error>nama_spesialis</x-error>
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

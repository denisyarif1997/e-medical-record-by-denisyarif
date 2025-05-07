<x-admin>
    @section('title','Edit Satuan Obat')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Satuan</h3>
                    <a href="{{ route('admin.satuan_obat.index') }}" class="btn btn-info btn-sm float-right">Back</a>
                </div>
                <form action="{{ route('admin.satuan_obat.update', $editsatuan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nam">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $editsatuan->nama }}" required>
                            <x-error>nama</x-error>
                        </div>
{{-- 
                        <div class="form-group">
                            <label for="code">Kode</label>
                            <input type="text" name="code" class="form-control" value="{{ $spesialis->code }}" required>
                            <x-error>code</x-error>
                        </div> --}}
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>

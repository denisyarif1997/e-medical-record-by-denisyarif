<x-admin>
    @section('title','Edit Spesialis')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Spesialis</h3>
                    <a href="{{ route('admin.spesialis.index') }}" class="btn btn-info btn-sm float-right">Back</a>
                </div>
                <form action="{{ route('admin.spesialis.update', $spesialis->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_spesialis">Nama Spesialis</label>
                            <input type="text" name="nama_spesialis" class="form-control" value="{{ $spesialis->nama_spesialis }}" required>
                            <x-error>nama_spesialis</x-error>
                        </div>

                        <div class="form-group">
                            <label for="code">Kode</label>
                            <input type="text" name="code" class="form-control" value="{{ $spesialis->code }}" required>
                            <x-error>code</x-error>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>

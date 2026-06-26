<x-admin>
    @section('title','Edit Satuan Obat')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Formula</h3>
                    <a href="{{ route('admin.formula.index') }}" class="btn btn-info btn-sm float-right">Back</a>
                </div>
                <form action="{{ route('admin.formula.update', $formula->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nam">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $formula->nama }}" required>
                            <x-error>nama</x-error>
                        </div>

                        <div class="form-group">
                            <label for="code">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ $formula->keterangan }}" required>
                            <x-error>keterangan</x-error>
                        </div>

                         <div class="form-group">
                            <label for="code">Faktor</label>
                            <input type="text" name="faktor" class="form-control" value="{{ $formula->faktor }}" required>
                            <x-error>faktor</x-error>
                        </div>

                         {{-- <div class="form-group">
                            <label for="code">Keterangan</label>
                            <input type="text" name="code" class="form-control" value="{{ $formula->keterangan }}" required>
                            <x-error>keterangan</x-error>
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

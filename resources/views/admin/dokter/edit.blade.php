<x-admin>
    @section('title','Edit Dokter')
    <form action="{{ route('admin.dokter.update', encrypt($dokter->id)) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Dokter</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" name="nama" class="form-control" value="{{ $dokter->nama }}" required>
                </div>
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $dokter->no_hp }}">
                </div>
                <div class="form-group">
                    <label>Spesialis</label>
                    <select name="spec_code" class="form-control" required>
                        <option value="">-- Pilih Spesialis --</option>
                        @foreach($spesialis as $spec)
                            <option value="{{ $spec->code }}" {{ $spec->code == $dokter->spec_code ? 'selected' : '' }}>
                                {{ $spec->nama_spesialis }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</x-admin>

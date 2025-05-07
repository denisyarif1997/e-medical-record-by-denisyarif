<x-admin>
    @section('title', 'Tambah Procedure')

    <div class="container-fluid mt-3">
        <h3 class="mb-4"><i class="fas fa-plus-circle"></i> Tambah Master Procedure</h3>

        <form action="{{ route('admin.procedures.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="id_jenis_jasa"><strong>Jenis Jasa</strong></label>
                <select name="id_jenis_jasa" id="id_jenis_jasa" class="form-control" required>
                    <option value="">-- Pilih Jenis Jasa --</option>
                    @foreach ($js_procedures as $js)
                        <option value="{{ $js->id }}">{{ $js->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="nama"><strong>Nama Procedure</strong></label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama procedure" required>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="status" name="status" value="true" checked>
                <label class="form-check-label" for="status"><strong>Aktif</strong></label>
            </div>

            <hr>
            <h5 class="mb-4"><i class="fas fa-money-bill-wave"></i> Harga dan Presentase per Tarif</h5>
            <div class="row">
                @php
                    $tarifLabels = [
                        1 => 'Kelas 1', 2 => 'Kelas 2', 3 => 'Kelas 3', 4 => 'VIP', 5 => 'VVIP',
                        6 => 'Non Kelas', 7 => 'HCU', 8 => 'ICU', 9 => 'Perinatologi',
                        10 => 'Isolasi', 11 => 'NICU', 12 => 'Presiden Suite'
                    ];
                @endphp

                @foreach ($tarifLabels as $id => $label)
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white"><strong>{{ $label }}</strong></div>
                            <div class="card-body">
                                <input type="hidden" name="tarif[{{ $id }}][id_tarif]" value="{{ $id }}">
                                <div class="form-group mb-3">
                                    <label><strong>Presentase (%)</strong></label>
                                    <input type="number" step="0.01" name="tarif[{{ $id }}][presentase]" class="form-control" value="0">
                                </div>
                                <div class="form-group">
                                    <label><strong>Harga (Rp)</strong></label>
                                    <input type="number" step="0.01" name="tarif[{{ $id }}][price]" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('admin.procedures.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</x-admin>
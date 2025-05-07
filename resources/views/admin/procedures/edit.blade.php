<x-admin>
    @section('title', 'Edit Procedure')

    <div class="container-fluid mt-3">
        <h3>Edit Master Procedure</h3>

        <form action="{{ route('admin.procedures.update', $procedure->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_jenis_jasa">Jenis Jasa</label>
                <select name="id_jenis_jasa" id="id_jenis_jasa" class="form-control" required>
                    <option value="">-- Pilih Jenis Jasa --</option>
                    @foreach ($js_procedures as $js)
                        <option value="{{ $js->id }}" {{ $procedure->id_jenis_jasa == $js->id ? 'selected' : '' }}>
                            {{ $js->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            

            <div class="form-group">
                <label for="nama">Nama Procedure</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $procedure->nama }}" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="status" name="status" value="true" {{ $procedure->status ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Aktif</label>
            </div>

            <hr>
            <h5>Harga dan Presentase per Tarif</h5>
            <div class="row">
                @php
                    $tarifLabels = [
                        1 => 'Kelas 1', 2 => 'Kelas 2', 3 => 'Kelas 3', 4 => 'VIP', 5 => 'VVIP',
                        6 => 'Non Kelas', 7 => 'HCU', 8 => 'ICU', 9 => 'Perinatologi',
                        10 => 'Isolasi', 11 => 'NICU', 12 => 'Presiden Suite'
                    ];
                @endphp

                @foreach ($tarifLabels as $id => $label)
                    @php
                        $presentase = $tarifs[$id]['presentase'] ?? 0;
                        $price = $tarifs[$id]['price'] ?? 0;
                    @endphp
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-light"><strong>{{ $label }}</strong></div>
                            <div class="card-body">
                                <input type="hidden" name="tarif[{{ $id }}][id_tarif]" value="{{ $id }}">
                                <div class="form-group">
                                    <label>Presentase (%)</label>
                                    <input type="number" step="0.01" name="tarif[{{ $id }}][presentase]" class="form-control" value="{{ $presentase }}">
                                </div>
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" step="0.01" name="tarif[{{ $id }}][price]" class="form-control" value="{{ $price }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.procedures.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-admin>

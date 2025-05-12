<div>
    <h3>Form Asesmen Medis</h3>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
        @if ($id_regis)
            <div class="mb-3">
                <label>ID Regis</label>
                <input type="text" class="form-control" wire:model="id_regis" readonly>
            </div>

            @foreach ($asesmen as $key => $value)
                <div class="mb-3">
                    <label>{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                    <input type="text" class="form-control" wire:model="asesmen.{{ $key }}">
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Simpan</button>
        @endif
    </form>

    <h4 class="mt-4">Pilih Pasien</h4>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pasien</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $pasien)
                <tr>
                    <td>{{ $pasien->id_regis }}</td>
                    <td>{{ $pasien->nama_pasien }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" wire:click="selectPasien({{ $pasien->id_regis }})">Pilih</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

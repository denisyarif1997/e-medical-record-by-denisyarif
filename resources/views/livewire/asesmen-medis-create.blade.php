@section('title', 'Form Asesmen Medis')

<div>
    <a href="{{ route('asesmen-medis.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar Pasien</a>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
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
    </form>
</div>

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Asesmen Perawat</h2>

    <form action="{{ route('admin.asesmen_perawat.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="id_regis">Pendaftaran</label>
            <select name="id_regis" id="id_regis" class="form-control" required>
                <option value="">Pilih Pendaftaran</option>
                @foreach($pendaftarans as $pendaftaran)
                    <option value="{{ $pendaftaran->id }}" @if($pendaftaran->id == $data->id_regis) selected @endif>
                        {{ $pendaftaran->nama_pasien }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tujuan_kunjungan">Tujuan Kunjungan</label>
            <input type="text" name="tujuan_kunjungan" id="tujuan_kunjungan" class="form-control" value="{{ $data->asesmen['tujuan_kunjungan'] }}" required>
        </div>

        <div class="form-group">
            <label for="keluhan_utama">Keluhan Utama</label>
            <input type="text" name="keluhan_utama" id="keluhan_utama" class="form-control" value="{{ $data->asesmen['keluhan_utama'] }}" required>
        </div>

        <div class="form-group">
            <label for="ttv">TTV</label>
            <textarea name="ttv" id="ttv" class="form-control" rows="4">{{ $data->asesmen['ttv'] }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

<x-admin>
    @section('title', 'Edit Asesmen Perawat')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Asesmen Perawat</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.asesmen_perawat.update', $asesmen->id) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $a = json_decode($asesmen->asesmen, true);
                @endphp

                {{-- Info Pasien --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Kunjungan</label>
                            <input type="text" class="form-control" 
                            value="{{ \Carbon\Carbon::parse($regis->created_at)->translatedFormat('d F Y, H:i') }} WIB" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Pasien</label>
                            <input type="text" class="form-control" value="{{ $regis->nama_pasien }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ID Registrasi</label>
                            <input type="text" class="form-control" value="{{ $asesmen->id_regis }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>No Rekam Medis</label>
                            <input type="text" class="form-control" value="{{ $regis->no_rekam_medis }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Dokter</label>
                            <input type="text" class="form-control" value="{{ $regis->nama_dokter }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Poliklinik</label>
                            <input type="text" class="form-control" value="{{ $regis->nama_poli }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Asuransi</label>
                            <input type="text" class="form-control" value="{{ $regis->nama_asuransi }}" readonly>
                        </div>
                    </div>
                </div>

                <hr>

                <input type="hidden" name="id_regis" value="{{ $asesmen->id_regis }}">

                {{-- Asesmen Input --}}
                <div class="form-group">
                    <label for="tujuan_kunjungan">Tujuan Kunjungan</label>
                    <select name="tujuan_kunjungan" id="tujuan_kunjungan" class="form-control" required>
                        <option value="">-- Pilih Tujuan Kunjungan --</option>
                        @foreach(['Berobat', 'Kontrol', 'Konsultasi', 'Vaksinasi', 'Cek Lab', 'Lainnya'] as $tk)
                            <option value="{{ $tk }}" {{ ($a['tujuan_kunjungan'] ?? '') == $tk ? 'selected' : '' }}>{{ $tk }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="keluhan_utama">Keluhan Utama <span class="text-danger">*</span></label>
                    <input type="text" name="keluhan_utama" id="keluhan_utama" class="form-control" value="{{ $a['keluhan_utama'] ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Pemeriksaan Fisik <span class="text-danger">*</span></label>
                    <textarea name="pemeriksaan_fisik" class="form-control" rows="3">{{ $a['pemeriksaan_fisik'] ?? '' }}</textarea>
                </div>

                {{-- TTV --}}
                <h5 class="mt-4 mb-3"><strong>Objective</strong></h5>
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Tanda - tanda Vital</strong></h6>

                        <div class="form-group">
                            <label>Keadaan Umum <span class="text-danger">*</span></label>
                            <input type="text" name="keadaan_umum" class="form-control" value="{{ $a['keadaan_umum'] ?? '' }}">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Sistolik</label>
                                <input type="number" name="sistolik" class="form-control" value="{{ $a['sistolik'] ?? '' }}">
                            </div>
                            <div class="form-group col-6">
                                <label>Diastolik</label>
                                <input type="number" name="diastolik" class="form-control" value="{{ $a['diastolik'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Nadi</label>
                                <input type="number" name="nadi" class="form-control" value="{{ $a['nadi'] ?? '' }}">
                            </div>
                            <div class="form-group col-6">
                                <label>Pernapasan</label>
                                <input type="number" name="pernapasan" class="form-control" value="{{ $a['pernapasan'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Suhu</label>
                            <input type="number" step="0.1" name="suhu" class="form-control" value="{{ $a['suhu'] ?? '' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6><strong>Pemeriksaan Lain</strong></h6>

                        <div class="form-group">
                            <label>Tinggi Badan</label>
                            <input type="number" step="0.1" name="tinggi_badan" class="form-control" value="{{ $a['tinggi_badan'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Berat Badan</label>
                            <input type="number" step="0.001" name="berat_badan" class="form-control" value="{{ $a['berat_badan'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Indeks Massa Tubuh</label>
                            <input type="text" name="imt" class="form-control" value="{{ $a['imt'] ?? '' }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-admin>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const beratInput = document.querySelector('input[name="berat_badan"]');
        const tinggiInput = document.querySelector('input[name="tinggi_badan"]');
        const imtInput = document.querySelector('input[name="imt"]');
    
        function hitungIMT() {
            const berat = parseFloat(beratInput.value);
            const tinggiCm = parseFloat(tinggiInput.value);
    
            if (!isNaN(berat) && !isNaN(tinggiCm) && tinggiCm > 0) {
                const tinggiM = tinggiCm / 100;
                const imt = berat / (tinggiM * tinggiM);
                let kategori = '';
    
                if (imt < 18.5) kategori = 'Underweight';
                else if (imt < 25) kategori = 'Normal';
                else if (imt < 30) kategori = 'Overweight';
                else kategori = 'Obese';
    
                imtInput.value = `${imt.toFixed(1)} (${kategori})`;
            } else {
                imtInput.value = '';
            }
        }
    
        beratInput.addEventListener('input', hitungIMT);
        tinggiInput.addEventListener('input', hitungIMT);
    });
</script>

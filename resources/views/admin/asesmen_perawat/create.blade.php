<x-admin>
    @section('title', 'Tambah Asesmen Perawat')

    <div class="container-fluid mt-3">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-user-nurse"></i> Data Diri Pasien</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.asesmen_perawat.store') }}" method="POST">
                    @csrf

                    {{-- Info Pasien --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Tanggal Kunjungan</strong></label>
                                <input type="text" class="form-control" 
                                    value="{{ \Carbon\Carbon::parse($createAsesmen->created_at)->translatedFormat('d F Y, H:i') }} WIB" 
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Nama Pasien</strong></label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_pasien }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>ID Kunjungan</strong></label>
                                <input type="text" class="form-control" id="id_regis" value="{{ $createAsesmen->id_regis }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>No Rekam Medis</strong></label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->no_rekam_medis }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Dokter</strong></label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_dokter }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Poliklinik</strong></label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_poli }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Asuransi</strong></label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_asuransi }}" readonly>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Hidden --}}
                    <input type="hidden" name="id_regis" value="{{ $createAsesmen->id }}">

                    {{-- Asesmen Input --}}
                    <div class="form-group">
                        <label for="tujuan_kunjungan"><strong>Tujuan Kunjungan</strong></label>
                        <select name="tujuan_kunjungan" id="tujuan_kunjungan" class="form-control" required>
                            <option value="">-- Pilih Tujuan Kunjungan --</option>
                            <option value="Berobat">Berobat</option>
                            <option value="Kontrol">Kontrol</option>
                            <option value="Konsultasi">Konsultasi</option>
                            <option value="Vaksinasi">Vaksinasi</option>
                            <option value="Cek Lab">Cek Lab</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="keluhan_utama"><strong>Keluhan Utama</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="keluhan_utama" id="keluhan_utama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><strong>Pemeriksaan Fisik</strong> <span class="text-danger">*</span></label>
                        <textarea name="pemeriksaan_fisik" class="form-control" rows="3" placeholder="Contoh: Tidak ditemukan kelainan"></textarea>
                    </div>

                    {{-- Tanda-tanda Vital --}}
                    <h5 class="mt-4 mb-3"><strong>Objective</strong></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Tanda - tanda Vital</strong></h6>
                            <div class="form-group">
                                <label><strong>Keadaan Umum</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="keadaan_umum" class="form-control" required placeholder="Contoh: Tampak sakit ringan">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label><strong>Sistolik</strong> <span class="text-danger">*</span></label>
                                    <input type="number" name="sistolik" class="form-control" placeholder="mmHg">
                                </div>
                                <div class="form-group col-6">
                                    <label><strong>Diastolik</strong> <span class="text-danger">*</span></label>
                                    <input type="number" name="diastolik" class="form-control" placeholder="mmHg">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label><strong>Nadi</strong> <span class="text-danger">*</span></label>
                                    <input type="number" name="nadi" class="form-control" placeholder="x/menit">
                                </div>
                                <div class="form-group col-6">
                                    <label><strong>Pernapasan</strong></label>
                                    <input type="number" name="pernapasan" class="form-control" placeholder="x/menit">
                                </div>
                            </div>
                            <div class="form-group">
                                <label><strong>Suhu</strong> <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" name="suhu" class="form-control" placeholder="°C">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6><strong>Pemeriksaan Lain</strong></h6>
                            <div class="form-group">
                                <label><strong>Tinggi Badan</strong> <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" name="tinggi_badan" class="form-control" placeholder="cm">
                            </div>
                            <div class="form-group">
                                <label><strong>Berat Badan</strong> <span class="text-danger">*</span></label>
                                <input type="number" step="0.001" name="berat_badan" class="form-control" placeholder="kg">
                            </div>
                            <div class="form-group">
                                <label><strong>Indeks Massa Tubuh</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="imt" class="form-control" placeholder="Contoh: 16 (Underweight)" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        <a href="{{ route('admin.asesmen_perawat.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
</x-admin>
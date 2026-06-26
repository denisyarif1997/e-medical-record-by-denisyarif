<x-admin>
    @section('title', 'Tambah Asesmen Perawat')

    <div class="container-fluid mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h3 class="card-title font-weight-bold"><i class="fas fa-user-nurse mr-2"></i> Data Diri Pasien</h3>
            </div>

            <div class="card-body bg-light">
                <form action="{{ route('admin.asesmen_perawat.store') }}" method="POST">
                    @csrf

                    {{-- Info Pasien --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-secondary font-weight-bold">Tanggal Kunjungan</label>
                                <input type="text" class="form-control" 
                                    value="{{ \Carbon\Carbon::parse($createAsesmen->created_at)->translatedFormat('d F Y, H:i') }} WIB" 
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-secondary font-weight-bold">Nama Pasien</label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_pasien }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-secondary font-weight-bold">ID Kunjungan</label>
                                <input type="text" class="form-control" id="id_regis" value="{{ $createAsesmen->id_regis }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-secondary font-weight-bold">No Rekam Medis</label>
                                <input type="text" class="form-control text-primary font-weight-bold" value="{{ $createAsesmen->no_rekam_medis }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-secondary font-weight-bold">Dokter</label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_dokter }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-secondary font-weight-bold">Poliklinik</label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_poli }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-secondary font-weight-bold">Asuransi</label>
                                <input type="text" class="form-control" value="{{ $createAsesmen->nama_asuransi }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main assessment card --}}
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-gradient-info text-white py-3">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-notes-medical mr-2"></i> Formulir Asesmen Keperawatan</h3>
                </div>
                <div class="card-body">
                    {{-- Hidden --}}
                    <input type="hidden" name="id_regis" value="{{ $createAsesmen->id }}">

                    {{-- Section 1: Riwayat & Alert --}}
                    <div class="card card-outline card-danger mt-3 border-left-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-danger"><i class="fas fa-exclamation-triangle"></i> Riwayat & Alergi</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Riwayat Alergi</strong></label>
                                        <textarea name="riwayat_alergi" class="form-control" rows="2" placeholder="Sebutkan alergi obat, makanan, dll (Jika ada)"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Riwayat Penyakit Dahulu/Keluarga</strong></label>
                                        <textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Hipertensi, DM, Jantung, dll"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Subjective & Objective --}}
                    <div class="card card-outline card-primary mt-3 border-left-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-primary"><i class="fas fa-stethoscope"></i> Pemeriksaan Fisik & Vital Sign</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tujuan_kunjungan"><strong>Tujuan Kunjungan</strong> <span class="text-danger">*</span></label>
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
                                        <label><strong>Pemeriksaan Fisik (Head to Toe)</strong></label>
                                        <textarea name="pemeriksaan_fisik" class="form-control" rows="3" placeholder="Deskripsikan kondisi fisik pasien secara umum"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Keadaan Umum</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="keadaan_umum" class="form-control" required placeholder="Baik / Lemah / Cukup">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Sistolik</strong></label>
                                                <div class="input-group">
                                                    <input type="number" name="sistolik" class="form-control" placeholder="mmHg">
                                                    <div class="input-group-append"><span class="input-group-text">mmHg</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Diastolik</strong></label>
                                                <div class="input-group">
                                                    <input type="number" name="diastolik" class="form-control" placeholder="mmHg">
                                                    <div class="input-group-append"><span class="input-group-text">mmHg</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Nadi</strong></label>
                                                <div class="input-group">
                                                    <input type="number" name="nadi" class="form-control" placeholder="x/mnt">
                                                    <div class="input-group-append"><span class="input-group-text">x/mnt</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Pernapasan</strong></label>
                                                <div class="input-group">
                                                    <input type="number" name="pernapasan" class="form-control" placeholder="x/mnt">
                                                    <div class="input-group-append"><span class="input-group-text">x/mnt</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label><strong>Suhu</strong></label>
                                                <div class="input-group">
                                                    <input type="number" step="0.1" name="suhu" class="form-control" placeholder="°C">
                                                    <div class="input-group-append"><span class="input-group-text">°C</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label><strong>Tinggi</strong></label>
                                                <div class="input-group">
                                                    <input type="number" step="0.1" name="tinggi_badan" class="form-control" placeholder="cm">
                                                    <div class="input-group-append"><span class="input-group-text">cm</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label><strong>Berat</strong></label>
                                                <div class="input-group">
                                                    <input type="number" step="0.1" name="berat_badan" class="form-control" placeholder="kg">
                                                    <div class="input-group-append"><span class="input-group-text">kg</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label><strong>IMT (Indeks Massa Tubuh)</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="imt" id="imt" class="form-control font-weight-bold" readonly style="background-color: #f8f9fa;">
                                            <div class="input-group-append">
                                                <span class="input-group-text font-weight-bold text-white bg-secondary" id="imt_status">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Assessment & Screening --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-outline card-info h-100 border-left-3">
                                <div class="card-header py-2">
                                    <h3 class="card-title font-weight-bold text-info"><i class="fas fa-brain"></i> Psikososial & Ekonomi</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><strong>Status Mental / Psikososial</strong></label>
                                        <select name="status_psikososial" class="form-control">
                                            <option value="Tenang">Tenang</option>
                                            <option value="Cemas">Cemas</option>
                                            <option value="Sedih">Sedih</option>
                                            <option value="Marah">Marah</option>
                                            <option value="Takut">Takut</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Status Fungsional (ADL)</strong></label>
                                        <select name="adl_status" class="form-control">
                                            <option value="Mandiri">Mandiri</option>
                                            <option value="Bantuan Minimal">Bantuan Minimal</option>
                                            <option value="Bantuan Parsial">Bantuan Parsial</option>
                                            <option value="Bantuan Total">Bantuan Total</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-outline card-warning h-100 border-left-3">
                                <div class="card-header py-2">
                                    <h3 class="card-title font-weight-bold text-warning"><i class="fas fa-walking"></i> Risiko Jatuh & Nyeri</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Risiko Jatuh</strong></label>
                                                <select name="jatuh_risiko" class="form-control">
                                                    <option value="Tidak Berisiko">Tidak Berisiko</option>
                                                    <option value="Risiko Rendah">Risiko Rendah</option>
                                                    <option value="Risiko Tinggi">Risiko Tinggi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label><strong>Skala Nyeri (0-10)</strong></label>
                                                <div class="d-flex align-items-center">
                                                    <input type="range" name="nyeri_skala" id="nyeri_skala" class="custom-range flex-grow-1" min="0" max="10" value="0">
                                                    <span id="nyeri_val" class="badge badge-success text-white ml-3 px-3 py-2 font-weight-bold" style="font-size: 1.1rem; width: 45px; text-align: center;">0</span>
                                                </div>
                                                <small id="nyeri_desc" class="form-text text-success font-weight-bold mt-1">Tidak Nyeri</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Kualitas Nyeri</strong></label>
                                        <input type="text" name="nyeri_kualitas" class="form-control" placeholder="Contoh: Seperti ditusuk, tumpul, panas">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 4: Skrining Gizi (MST) --}}
                    <div class="card card-outline card-success mt-3 border-left-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-success"><i class="fas fa-utensils"></i> Skrining Gizi (MST)</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>1. Apakah pasien kehilangan BB yang tidak diinginkan dalam 6 bln terakhir?</strong></label>
                                        <select name="gizi_mst_1" id="gizi_mst_1" class="form-control">
                                            <option value="0">Tidak (Skor 0)</option>
                                            <option value="1">Tidak yakin / Baju terasa longgar (Skor 1)</option>
                                            <option value="2">Ya, 1-5 kg (Skor 2)</option>
                                            <option value="3">Ya, 6-10 kg (Skor 3)</option>
                                            <option value="4">Ya, 11-15 kg (Skor 4)</option>
                                            <option value="5">Ya, > 15 kg (Skor 5)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>2. Apakah asupan makan berkurang karena tidak nafsu makan?</strong></label>
                                        <select name="gizi_mst_2" id="gizi_mst_2" class="form-control">
                                            <option value="0">Tidak (Skor 0)</option>
                                            <option value="1">Ya (Skor 1)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="alert alert-light border d-flex justify-content-between align-items-center mb-0 py-2">
                                        <span><strong>Total Skor MST:</strong> <span id="mst_total_score" class="badge badge-success py-2 px-3" style="font-size: 1rem;">0</span></span>
                                        <span id="mst_alert" class="badge badge-success py-2 px-3" style="font-size: 1rem;"><i class="fas fa-check-circle mr-1"></i> Gizi Baik (Risiko Rendah)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 5: Diagnosa & Rencana --}}
                    <div class="card card-outline card-secondary mt-3 border-left-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-secondary"><i class="fas fa-notes-medical"></i> Masalah & Rencana Keperawatan</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><strong>Masalah Keperawatan (Pilih yang sesuai)</strong></label>
                                <div class="row">
                                    @foreach([
                                        'Bersihan Jalan Napas tidak efektif',
                                        'Pola Napas tidak efektif',
                                        'Nyeri Akut',
                                        'Hipertermia',
                                        'Hipovolemia',
                                        'Defisit Nutrisi',
                                        'Intoleransi Aktivitas',
                                        'Ansietas',
                                        'Gangguan Integritas Kulit',
                                        'Risiko Infeksi',
                                        'Risiko Jatuh'
                                    ] as $masalah)
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox my-1">
                                            <input class="custom-control-input" type="checkbox" name="masalah_keperawatan[]" id="masalah_{{ $loop->index }}" value="{{ $masalah }}">
                                            <label for="masalah_{{ $loop->index }}" class="custom-control-label font-weight-normal">{{ $masalah }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label><strong>Rencana Keperawatan / Intervensi</strong></label>
                                <textarea name="rencana_keperawatan" class="form-control" rows="3" placeholder="Sebutkan intervensi singkat yang akan dilakukan"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4 pb-4">
                        <a href="{{ route('admin.asesmen_perawat.index') }}" class="btn btn-secondary shadow-sm px-4 mr-2"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary shadow-sm px-4"><i class="fas fa-save mr-1"></i> Simpan Asesmen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- IMT (BMI) Calculation ---
            const beratInput = document.querySelector('input[name="berat_badan"]');
            const tinggiInput = document.querySelector('input[name="tinggi_badan"]');
            const imtInput = document.getElementById('imt');
            const imtStatus = document.getElementById('imt_status');

            function hitungIMT() {
                const berat = parseFloat(beratInput.value);
                const tinggiCm = parseFloat(tinggiInput.value);

                if (!isNaN(berat) && !isNaN(tinggiCm) && tinggiCm > 0) {
                    const tinggiM = tinggiCm / 100;
                    const imt = berat / (tinggiM * tinggiM);
                    let kategori = '';
                    let badgeClass = '';

                    if (imt < 18.5) {
                        kategori = 'Underweight';
                        badgeClass = 'bg-warning text-dark';
                    } else if (imt < 25) {
                        kategori = 'Normal';
                        badgeClass = 'bg-success text-white';
                    } else if (imt < 30) {
                        kategori = 'Overweight';
                        badgeClass = 'bg-warning text-dark';
                    } else {
                        kategori = 'Obese';
                        badgeClass = 'bg-danger text-white';
                    }

                    imtInput.value = imt.toFixed(1);
                    imtStatus.textContent = kategori;
                    imtStatus.className = `input-group-text font-weight-bold ${badgeClass}`;
                } else {
                    imtInput.value = '';
                    imtStatus.textContent = '-';
                    imtStatus.className = 'input-group-text font-weight-bold text-white bg-secondary';
                }
            }

            if (beratInput && tinggiInput) {
                beratInput.addEventListener('input', hitungIMT);
                tinggiInput.addEventListener('input', hitungIMT);
                hitungIMT(); // Run on page load
            }

            // --- Pain Scale Slider Interactivity ---
            const nyeriSkala = document.getElementById('nyeri_skala');
            const nyeriVal = document.getElementById('nyeri_val');
            const nyeriDesc = document.getElementById('nyeri_desc');

            if (nyeriSkala) {
                function updateNyeri() {
                    const val = parseInt(nyeriSkala.value);
                    nyeriVal.textContent = val;
                    if (val === 0) {
                        nyeriDesc.textContent = 'Tidak Nyeri';
                        nyeriDesc.className = 'form-text text-success font-weight-bold mt-1';
                        nyeriVal.className = 'badge badge-success text-white ml-3 px-3 py-2 font-weight-bold';
                    } else if (val <= 3) {
                        nyeriDesc.textContent = 'Nyeri Ringan';
                        nyeriDesc.className = 'form-text text-info font-weight-bold mt-1';
                        nyeriVal.className = 'badge badge-info text-white ml-3 px-3 py-2 font-weight-bold';
                    } else if (val <= 6) {
                        nyeriDesc.textContent = 'Nyeri Sedang';
                        nyeriDesc.className = 'form-text text-warning font-weight-bold mt-1';
                        nyeriVal.className = 'badge badge-warning text-dark ml-3 px-3 py-2 font-weight-bold';
                    } else {
                        nyeriDesc.textContent = 'Nyeri Berat';
                        nyeriDesc.className = 'form-text text-danger font-weight-bold mt-1';
                        nyeriVal.className = 'badge badge-danger text-white ml-3 px-3 py-2 font-weight-bold';
                    }
                }
                nyeriSkala.addEventListener('input', updateNyeri);
                updateNyeri(); // Init
            }

            // --- MST (Nutritional Screening) Calculator ---
            const mst1 = document.getElementById('gizi_mst_1');
            const mst2 = document.getElementById('gizi_mst_2');
            const mstTotal = document.getElementById('mst_total_score');
            const mstAlert = document.getElementById('mst_alert');

            if (mst1 && mst2) {
                function hitungMST() {
                    const val1 = parseInt(mst1.value) || 0;
                    const val2 = parseInt(mst2.value) || 0;
                    const total = val1 + val2;

                    mstTotal.textContent = total;

                    if (total >= 2) {
                        mstTotal.className = 'badge badge-danger py-2 px-3';
                        mstAlert.textContent = 'Risiko Malnutrisi! Rujuk ke Ahli Gizi';
                        mstAlert.className = 'badge badge-danger py-2 px-3';
                    } else {
                        mstTotal.className = 'badge badge-success py-2 px-3';
                        mstAlert.textContent = 'Gizi Baik (Risiko Rendah)';
                        mstAlert.className = 'badge badge-success py-2 px-3';
                    }
                }

                mst1.addEventListener('change', hitungMST);
                mst2.addEventListener('change', hitungMST);
                hitungMST(); // Init
            }
        });
    </script>
</x-admin>
<x-admin>
    @section('title', 'Tambah Asesmen Medis')

    <div class="container-fluid mt-3">
        <div class="row">
            {{-- Column Left: Info Pasien & Data Perawat --}}
            <div class="col-md-5">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi & Hasil Asesmen Perawat</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr><th width="150">No. RM</th><td>: {{ $createAsesmen->no_rekam_medis }}</td></tr>
                            <tr><th>Nama Pasien</th><td>: {{ $createAsesmen->nama_pasien }}</td></tr>
                            <tr><th>Poliklinik</th><td>: {{ $createAsesmen->nama_poli }}</td></tr>
                            <tr><th>Dokter</th><td>: {{ $createAsesmen->nama_dokter }}</td></tr>
                        </table>
                        <hr>
                        <h6 class="text-primary font-weight-bold">Hasil Pemeriksaan Perawat (Objective)</h6>
                        <div class="row bg-light p-2 rounded">
                            <div class="col-6">
                                <small>T-Darah: <b>{{ $createAsesmen->sistolik }}/{{ $createAsesmen->diastolik }}</b> mmHg</small><br>
                                <small>Nadi: <b>{{ $createAsesmen->nadi }}</b> x/mnt</small><br>
                                <small>Suhu: <b>{{ $createAsesmen->suhu }}</b> °C</small>
                            </div>
                            <div class="col-6">
                                <small>RR: <b>{{ $createAsesmen->pernapasan }}</b> x/mnt</small><br>
                                <small>BB/TB: <b>{{ $createAsesmen->berat_badan }} kg / {{ $createAsesmen->tinggi_badan }} cm</b></small><br>
                                <small>IMT: <b>{{ $createAsesmen->imt }}</b></small>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted font-weight-bold">Keluhan (Perawat):</small>
                            <p class="small text-dark">{{ $createAsesmen->keluhan_utama }}</p>
                        </div>
                        <div class="mt-2 text-danger">
                            <small class="font-weight-bold">Pemeriksaan Fisik (Perawat):</small>
                            <p class="small">{{ $createAsesmen->pemeriksaan_fisik ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Column Right: Doctor's SOAP Assessment --}}
            <div class="col-md-7">
                <form action="{{ route('admin.asesmen_medis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_regis" value="{{ $createAsesmen->id_regis }}">

                    {{-- Subjective --}}
                    <div class="card card-outline card-success shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">S - SUBJEKTIF (Anamnesa)</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Keluhan Utama <span class="text-danger">*</span></label>
                                <input type="text" name="keluhan_utama" class="form-control" value="{{ $createAsesmen->keluhan_utama }}" required>
                            </div>
                            <div class="form-group">
                                <label>Riwayat Penyakit Sekarang (RPS)</label>
                                <textarea name="rps" class="form-control" rows="3" placeholder="Uraikan keluhan secara detail..."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Riwayat Penyakit Dahulu</label>
                                        <textarea name="rpd" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Riwayat Alergi</label>
                                        <textarea name="riwayat_alergi" class="form-control" rows="2" placeholder="Obat / Makanan / Debu"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Objective --}}
                    <div class="card card-outline card-primary shadow-sm mt-3">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">O - OBJEKTIF</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Pemeriksaan Fisik / Status Lokalis</label>
                                <textarea name="status_lokalis" class="form-control" rows="3" placeholder="Head to toe / Status lokalis..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Assessment --}}
                    <div class="card card-outline card-warning shadow-sm mt-3">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">A - ASSESMEN (Diagnosa)</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Jenis Diagnosa</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="icd" name="jenis_diagnosa" value="icd" checked>
                                    <label for="icd" class="custom-control-label">ICD-10 (Standard)</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="non_icd" name="jenis_diagnosa" value="non_icd">
                                    <label for="non_icd" class="custom-control-label">Non-ICD (Manual)</label>
                                </div>
                            </div>

                            <div id="wrapper_icd">
                                <div class="form-group">
                                    <label>Cari ICD-10 <span class="text-danger">*</span></label>
                                    <select name="diagnosa_icd_id" id="diagnosa_icd_id" class="form-control select2">
                                        <option value="">-- Ketik kode atau nama penyakit --</option>
                                    </select>
                                </div>
                            </div>

                            <div id="wrapper_non_icd" style="display:none;">
                                <div class="form-group">
                                    <label>Diagnosa Manual <span class="text-danger">*</span></label>
                                    <input type="text" name="diagnosa_non_icd" class="form-control" placeholder="Tuliskan diagnosa...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Diagnosa Sekunder / Tambahan</label>
                                <textarea name="diagnosa_sekunder" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Plan --}}
                    <div class="card card-outline card-info shadow-sm mt-3">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">P - PLAN (Terapi & Rencana)</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Terapi / Instruksi Medis</label>
                                <textarea name="terapi" class="form-control" rows="4" placeholder="Obat, dosis, dan petunjuk lainnya..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Rencana Lanjutan</label>
                                <input type="text" name="rencana_lanjutan" class="form-control" placeholder="Contoh: Kontrol 1 minggu lagi / rujuk internal">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 mb-5 text-right">
                        <a href="{{ route('admin.asesmen_medis.index') }}" class="btn btn-secondary shadow-sm"><i class="fas fa-times"></i> Batal</a>
                        <button type="submit" class="btn btn-primary shadow-sm px-4"><i class="fas fa-save"></i> Simpan Asesmen Medis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle Diagnosa Type
            $('input[name="jenis_diagnosa"]').change(function() {
                if (this.value === 'icd') {
                    $('#wrapper_icd').show();
                    $('#wrapper_non_icd').hide();
                } else {
                    $('#wrapper_icd').hide();
                    $('#wrapper_non_icd').show();
                }
            });

            // Select2 ICD-10 Search
            $('#diagnosa_icd_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Cari ICD-10...',
                ajax: {
                    url: "{{ route('admin.asesmen_medis.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return { id: item.id, text: item.code + ' - ' + item.name };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
    @endpush
</x-admin>

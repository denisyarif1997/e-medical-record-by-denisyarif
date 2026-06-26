<x-admin>
    @section('title', 'Edit Asesmen Medis')

    <div class="container-fluid mt-3">
        <div class="row">
            {{-- Column Left: Info Pasien & Data Perawat --}}
            <div class="col-md-5">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title text-sm"><i class="fas fa-info-circle"></i> Referensi Asesmen Perawat</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr><th width="120">No. RM</th><td>: {{ $regis->no_rekam_medis }}</td></tr>
                            <tr><th>Pasien</th><td>: {{ $regis->nama_pasien }}</td></tr>
                        </table>
                        <hr class="my-2">
                        @if($nurse)
                            <h6 class="text-xs font-weight-bold text-primary mb-2">VITAL SIGN (PERAWAT)</h6>
                            <div class="row bg-light p-2 rounded mb-3">
                                <div class="col-6">
                                    <small>TD: <b>{{ $nurse->asesmen['sistolik'] ?? '-' }}/{{ $nurse->asesmen['diastolik'] ?? '-' }}</b></small><br>
                                    <small>N: <b>{{ $nurse->asesmen['nadi'] ?? '-' }}</b> x/m</small>
                                </div>
                                <div class="col-6">
                                    <small>Suhu: <b>{{ $nurse->asesmen['suhu'] ?? '-' }}</b> °C</small><br>
                                    <small>IMT: <b>{{ $nurse->asesmen['imt'] ?? '-' }}</b></small>
                                </div>
                            </div>
                            <small class="text-muted font-weight-bold">KELUHAN PERAWAT:</small>
                            <p class="small mb-2">{{ $nurse->asesmen['keluhan_utama'] ?? '-' }}</p>
                            <small class="text-muted font-weight-bold">PEMERIKSAAN FISIK PERAWAT:</small>
                            <p class="small mb-0">{{ $nurse->asesmen['pemeriksaan_fisik'] ?? '-' }}</p>
                        @else
                            <div class="alert alert-warning py-1"><small>Data perawat tidak ditemukan</small></div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Column Right: Doctor's SOAP Assessment Update --}}
            <div class="col-md-7">
                <form action="{{ route('admin.asesmen_medis.update', $asesmen->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_regis" value="{{ $asesmen->id_regis }}">

                    @php
                        $s = $asesmen->asesmen['subjective'] ?? [];
                        $o = $asesmen->asesmen['objective'] ?? [];
                        $a = $asesmen->asesmen['assessment'] ?? [];
                        $p = $asesmen->asesmen['plan'] ?? [];
                        $diag = $a['diagnosa'] ?? null;
                        $is_icd = $a['is_icd'] ?? true;
                    @endphp

                    {{-- Subjective --}}
                    <div class="card card-outline card-success shadow-sm">
                        <div class="card-header"><h3 class="card-title font-weight-bold">S - SUBJEKTIF</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Keluhan Utama</label>
                                <input type="text" name="keluhan_utama" class="form-control" value="{{ $s['keluhan_utama'] ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>RPS (Riwayat Penyakit Sekarang)</label>
                                <textarea name="rps" class="form-control" rows="3">{{ $s['rps'] ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Riwayat Alergi</label>
                                <input type="text" name="riwayat_alergi" class="form-control" value="{{ $s['riwayat_alergi'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    {{-- Objective --}}
                    <div class="card card-outline card-primary shadow-sm mt-3">
                        <div class="card-header"><h3 class="card-title font-weight-bold">O - OBJEKTIF</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Status Lokalis / Pemeriksaan Fisik</label>
                                <textarea name="status_lokalis" class="form-control" rows="3">{{ $o['status_lokalis'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Assessment --}}
                    <div class="card card-outline card-warning shadow-sm mt-3">
                        <div class="card-header"><h3 class="card-title font-weight-bold">A - ASSESMEN</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Jenis Diagnosa</label>
                                <div class="d-flex">
                                    <div class="custom-control custom-radio mr-3">
                                        <input class="custom-control-input" type="radio" id="icd" name="jenis_diagnosa" value="icd" {{ $is_icd ? 'checked' : '' }}>
                                        <label for="icd" class="custom-control-label">ICD-10</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="non_icd" name="jenis_diagnosa" value="non_icd" {{ !$is_icd ? 'checked' : '' }}>
                                        <label for="non_icd" class="custom-control-label">Non-ICD</label>
                                    </div>
                                </div>
                            </div>

                            <div id="wrapper_icd" style="{{ $is_icd ? '' : 'display:none;' }}">
                                <div class="form-group">
                                    <label>Cari ICD-10</label>
                                    <select name="diagnosa_icd_id" id="diagnosa_icd_id" class="form-control select2">
                                        @if($is_icd && $diag)
                                            <option value="{{ $diag['id'] ?? '' }}" selected>{{ $diag['code'] ?? '' }} - {{ $diag['name'] ?? '' }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div id="wrapper_non_icd" style="{{ !$is_icd ? '' : 'display:none;' }}">
                                <div class="form-group">
                                    <label>Diagnosa Manual</label>
                                    <input type="text" name="diagnosa_non_icd" class="form-control" value="{{ !$is_icd ? ($diag['name'] ?? '') : '' }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Diagnosa Sekunder</label>
                                <textarea name="diagnosa_sekunder" class="form-control" rows="2">{{ $a['diagnosa_sekunder'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Plan --}}
                    <div class="card card-outline card-info shadow-sm mt-3">
                        <div class="card-header"><h3 class="card-title font-weight-bold">P - PLAN</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Terapi / Instruksi</label>
                                <textarea name="terapi" class="form-control" rows="4">{{ $p['terapi'] ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Rencana Lanjutan</label>
                                <input type="text" name="rencana_lanjutan" class="form-control" value="{{ $p['rencana_lanjutan'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 mb-5 text-right">
                        <a href="{{ route('admin.asesmen_medis.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('input[name="jenis_diagnosa"]').change(function() {
                if (this.value === 'icd') {
                    $('#wrapper_icd').show();
                    $('#wrapper_non_icd').hide();
                } else {
                    $('#wrapper_icd').hide();
                    $('#wrapper_non_icd').show();
                }
            });

            $('#diagnosa_icd_id').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: "{{ route('admin.asesmen_medis.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) { return { q: params.term }; },
                    processResults: function(data) {
                        return { results: data.map(i => ({ id: i.id, text: i.code+' - '+i.name })) };
                    },
                    cache: true
                }
            });
        });
    </script>
    @endpush
</x-admin>
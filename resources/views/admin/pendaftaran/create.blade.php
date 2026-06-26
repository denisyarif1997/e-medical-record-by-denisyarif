Ini kode Blade-nya dengan layout wide dua kolom:

```blade
<x-admin>
@section('title', 'Pendaftaran Pasien')

<div class="py-4">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-semibold">Pendaftaran Pasien Baru</h4>
            <small class="text-muted">Lengkapi seluruh data sebelum mendaftarkan pasien</small>
        </div>
        <span class="badge bg-success-subtle text-success px-3 py-2">Status: Aktif</span>
    </div>

    <form action="{{ route('admin.pendaftaran.store') }}" method="POST" id="formDaftar">
        @csrf
        <input type="hidden" name="status" value="1">
        <input type="hidden" name="pasien_id" value="{{ $pasien->id ?? '' }}">

        <div class="row g-4 align-items-start">

            {{-- Kolom Kiri: Form --}}
            <div class="col-lg-8 col-md-7">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-4">

                        {{-- Informasi Kunjungan --}}
                        <p class="text-uppercase text-muted fw-semibold mb-3" style="font-size: 11px; letter-spacing: .07em;">Informasi Kunjungan</p>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label small text-secondary mb-1">
                                    <i class="fas fa-calendar-alt me-1"></i> Tanggal Daftar <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_daftar" class="form-control form-control-sm"
                                    value="{{ old('tanggal_daftar', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary mb-1">
                                    <i class="fas fa-user-md me-1"></i> Dokter <span class="text-danger">*</span>
                                </label>
                                <select name="dokter_id" class="form-select form-select-sm" required id="selectDokter">
                                    <option value="" disabled selected>Pilih dokter</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id }}"
                                            data-poli="{{ $dokter->nama_poli }}"
                                            {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                            {{ $dokter->dokter_nama }} – {{ $dokter->nama_poli }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary mb-1">
                                    <i class="fas fa-hospital me-1"></i> Poliklinik
                                </label>
                                <input type="text" class="form-control form-control-sm bg-light text-muted"
                                    id="infoPoli" value="-" readonly>
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- Data Pasien --}}
                        <p class="text-uppercase text-muted fw-semibold mb-3" style="font-size: 11px; letter-spacing: .07em;">Data Pasien</p>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary mb-1">
                                    <i class="fas fa-user me-1"></i> Nama Pasien
                                </label>
                                <input type="text" name="nama_pasien" class="form-control form-control-sm bg-light text-muted"
                                    value="{{ $pasien->nama ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary mb-1">
                                    <i class="fas fa-id-card me-1"></i> No. Rekam Medis
                                </label>
                                <input type="text" class="form-control form-control-sm bg-light text-muted"
                                    value="{{ $pasien->no_rekam_medis ?? '-' }}" readonly>
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- Asuransi --}}
                        <p class="text-uppercase text-muted fw-semibold mb-3" style="font-size: 11px; letter-spacing: .07em;">Asuransi</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary mb-1">
                                    <i class="fas fa-id-badge me-1"></i> Jenis Asuransi <span class="text-danger">*</span>
                                </label>
                                <select name="asuransi_id" class="form-select form-select-sm" required>
                                    @foreach($asuransis as $asuransi)
                                        <option value="{{ $asuransi->id }}"
                                            @if(isset($pasien) && $pasien->asuransi_id == $asuransi->id) selected @endif>
                                            {{ $asuransi->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary mb-1">
                                    <i class="fas fa-file-alt me-1"></i> No. Asuransi <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="no_asuransi" class="form-control form-control-sm"
                                    value="{{ $pasien->no_asuransi ?? '' }}" placeholder="0001234567890" required>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Ringkasan + Tombol --}}
            <div class="col-lg-4 col-md-5">

                <div class="card border-0 bg-light" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <p class="text-uppercase text-muted fw-semibold mb-3" style="font-size: 11px; letter-spacing: .07em;">Ringkasan Pendaftaran</p>

                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Pasien</small>
                            <small class="fw-semibold text-end">{{ $pasien->nama ?? '-' }}</small>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Tanggal</small>
                            <small class="fw-semibold" id="infoTanggal">{{ date('d M Y') }}</small>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Dokter</small>
                            <small class="fw-semibold text-end" id="infoDokterRingkasan">-</small>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <small class="text-muted">Asuransi</small>
                            <small class="fw-semibold" id="infoAsuransiRingkasan">-</small>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <small class="text-muted">Status</small>
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info py-2 px-3 mt-3 d-flex gap-2 align-items-start" style="font-size: 12px; border-radius: 10px;">
                    <i class="fas fa-info-circle mt-1"></i>
                    <span>Pastikan nomor asuransi sudah sesuai sebelum mendaftar.</span>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3 d-flex align-items-center justify-content-center gap-2" id="btnSubmit">
                    <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                    <i class="fas fa-save" id="btnIcon"></i>
                    <span id="btnText">Daftar Sekarang</span>
                </button>
                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline-secondary w-100 mt-2 btn-sm">Batal</a>

            </div>

        </div>
    </form>

</div>

@section('js')
<script>
    const selectDokter = document.getElementById('selectDokter');
    const infoPoli = document.getElementById('infoPoli');
    const infoDokterRingkasan = document.getElementById('infoDokterRingkasan');

    selectDokter.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        infoPoli.value = opt.dataset.poli ?? '-';
        infoDokterRingkasan.textContent = opt.text;
    });

    document.querySelector('select[name="asuransi_id"]').addEventListener('change', function () {
        document.getElementById('infoAsuransiRingkasan').textContent = this.options[this.selectedIndex].text;
    });

    document.getElementById('formDaftar').addEventListener('submit', function () {
        document.getElementById('spinner').classList.remove('d-none');
        document.getElementById('btnIcon').classList.add('d-none');
        document.getElementById('btnText').textContent = 'Mendaftarkan...';
        document.getElementById('btnSubmit').setAttribute('disabled', 'disabled');
    });
</script>
@endsection

</x-admin>



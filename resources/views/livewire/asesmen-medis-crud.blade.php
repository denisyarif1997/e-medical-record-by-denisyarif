@section('title', 'Asesmen Medis')

<div class="container-fluid py-3">

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Form Asesmen --}}
    @if ($id_regis)
        <div class="row">
            {{-- Column Left: Info Pasien & Data Perawat (Readonly Reference Panel) --}}
            <div class="col-md-4">
                <div class="card card-outline card-primary shadow-sm border-0 position-sticky" style="top: 20px;">
                    <div class="card-header bg-light py-2">
                        <h3 class="card-title text-sm font-weight-bold text-primary"><i class="fas fa-user-injured mr-2"></i> Profil & TTV Pasien</h3>
                    </div>
                    <div class="card-body p-3">
                        {{-- Patient Profile Section --}}
                        <div class="text-center pb-3 border-bottom mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-2" style="width: 55px; height: 55px; font-size: 1.5rem;">
                                <i class="fas fa-user-injured"></i>
                            </div>
                            <h5 class="text-sm font-weight-bold text-dark mb-1">{{ $data->nama_pasien }}</h5>
                            <span class="badge badge-primary px-3 py-1 font-weight-bold shadow-xs">No. RM: {{ $data->no_rekam_medis }}</span>
                            <div class="text-xs text-muted mt-2"><i class="fas fa-hospital mr-1"></i> Poliklinik: <b>{{ $data->nama_poli }}</b></div>
                        </div>
                        
                        @if(!empty($nurseData))
                            {{-- Vital Signs Grid --}}
                            <div class="mb-3">
                                <h6 class="text-xs font-weight-bold text-secondary border-bottom pb-1 mb-2"><i class="fas fa-heartbeat text-danger mr-1"></i> VITAL SIGNS (PERAWAT)</h6>
                                <div class="row no-gutters text-center">
                                    <!-- Blood Pressure -->
                                    <div class="col-6 p-1">
                                        <div class="border rounded p-2 bg-light shadow-xs h-100">
                                            <div class="text-muted text-xxs font-weight-bold text-uppercase"><i class="fas fa-compress-arrows-alt text-primary mr-1"></i> Tensi</div>
                                            <div class="font-weight-bold text-sm text-dark mt-1">{{ $nurseData['sistolik'] ?? '-' }}/{{ $nurseData['diastolik'] ?? '-' }}</div>
                                            <small class="text-muted text-xxs">mmHg</small>
                                        </div>
                                    </div>
                                    <!-- Heart Rate / Pulse -->
                                    <div class="col-6 p-1">
                                        <div class="border rounded p-2 bg-light shadow-xs h-100">
                                            <div class="text-muted text-xxs font-weight-bold text-uppercase"><i class="fas fa-heart text-danger mr-1"></i> Nadi</div>
                                            <div class="font-weight-bold text-sm text-dark mt-1">{{ $nurseData['nadi'] ?? '-' }}</div>
                                            <small class="text-muted text-xxs">x/menit</small>
                                        </div>
                                    </div>
                                    <!-- Temperature -->
                                    <div class="col-6 p-1">
                                        <div class="border rounded p-2 bg-light shadow-xs h-100">
                                            <div class="text-muted text-xxs font-weight-bold text-uppercase"><i class="fas fa-thermometer-half text-warning mr-1"></i> Suhu</div>
                                            <div class="font-weight-bold text-sm text-dark mt-1">{{ $nurseData['suhu'] ?? '-' }}</div>
                                            <small class="text-muted text-xxs">°C</small>
                                        </div>
                                    </div>
                                    <!-- Resp Rate -->
                                    <div class="col-6 p-1">
                                        <div class="border rounded p-2 bg-light shadow-xs h-100">
                                            <div class="text-muted text-xxs font-weight-bold text-uppercase"><i class="fas fa-wind text-info mr-1"></i> Napas</div>
                                            <div class="font-weight-bold text-sm text-dark mt-1">{{ $nurseData['pernapasan'] ?? '-' }}</div>
                                            <small class="text-muted text-xxs">x/menit</small>
                                        </div>
                                    </div>
                                    <!-- Weight -->
                                    <div class="col-6 p-1">
                                        <div class="border rounded p-2 bg-light shadow-xs h-100">
                                            <div class="text-muted text-xxs font-weight-bold text-uppercase"><i class="fas fa-weight text-success mr-1"></i> Berat</div>
                                            <div class="font-weight-bold text-sm text-dark mt-1">{{ $nurseData['berat_badan'] ?? '-' }}</div>
                                            <small class="text-muted text-xxs">kg</small>
                                        </div>
                                    </div>
                                    <!-- BMI / IMT -->
                                    <div class="col-6 p-1">
                                        <div class="border rounded p-2 bg-light shadow-xs h-100">
                                            <div class="text-muted text-xxs font-weight-bold text-uppercase"><i class="fas fa-calculator text-dark mr-1"></i> IMT</div>
                                            <div class="font-weight-bold text-xs text-dark mt-1">{{ $nurseData['imt'] ?? '-' }}</div>
                                            <small class="text-muted text-xxs">Indeks</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status & Risk --}}
                            <div class="mb-3">
                                <h6 class="text-xs font-weight-bold text-secondary border-bottom pb-1 mb-2"><i class="fas fa-user-shield mr-1"></i> STATUS & RISIKO</h6>
                                <div class="bg-light p-2 rounded shadow-xs">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-xs text-secondary font-weight-bold"><i class="fas fa-brain mr-1 text-info"></i> Psikososial</span>
                                        <span class="badge badge-info text-xs">{{ $nurseData['status_psikososial'] ?? '-' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-xs text-secondary font-weight-bold"><i class="fas fa-running mr-1 text-danger"></i> Risiko Jatuh</span>
                                        @php
                                            $riskColor = 'success';
                                            $riskIcon = 'check-circle';
                                            if (str_contains($nurseData['jatuh_risiko'] ?? '', 'Tinggi')) { $riskColor = 'danger'; $riskIcon = 'exclamation-triangle'; }
                                            elseif (str_contains($nurseData['jatuh_risiko'] ?? '', 'Rendah')) { $riskColor = 'warning text-dark'; $riskIcon = 'exclamation-circle'; }
                                        @endphp
                                        <span class="badge badge-{{ $riskColor }} text-xs"><i class="fas fa-{{ $riskIcon }} mr-1"></i> {{ $nurseData['jatuh_risiko'] ?? '-' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-xs text-secondary font-weight-bold"><i class="fas fa-hand-holding-heart mr-1 text-warning"></i> Skala Nyeri</span>
                                        @php
                                            $painScale = intval($nurseData['nyeri_skala'] ?? 0);
                                            $painColor = 'success';
                                            if ($painScale >= 7) $painColor = 'danger';
                                            elseif ($painScale >= 4) $painColor = 'warning text-dark';
                                            elseif ($painScale >= 1) $painColor = 'info';
                                        @endphp
                                        <span class="badge badge-{{ $painColor }} text-xs font-weight-bold">{{ $painScale }} / 10</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Nurse Anamnesa --}}
                            <div class="mb-3">
                                <h6 class="text-xs font-weight-bold text-secondary border-bottom pb-1 mb-2"><i class="fas fa-file-medical-alt mr-1 text-primary"></i> ANAMNESA PERAWAT</h6>
                                <div class="bg-light p-3 rounded shadow-xs border">
                                    <div class="mb-2">
                                        <small class="d-block font-weight-bold text-primary text-xxs text-uppercase"><i class="fas fa-notes-medical mr-1"></i> Keluhan Utama</small>
                                        <div class="text-xs text-dark font-italic bg-white p-2 rounded mt-1 border">{{ $nurseData['keluhan_utama'] ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <small class="d-block font-weight-bold text-primary text-xxs text-uppercase"><i class="fas fa-history mr-1"></i> Riwayat Penyakit (Dahulu/Keluarga)</small>
                                        <div class="text-xs text-dark font-italic bg-white p-2 rounded mt-1 border mb-0">{{ $nurseData['riwayat_penyakit'] ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning py-2 mb-0 shadow-xs">
                                <small><i class="fas fa-exclamation-triangle mr-1"></i> Belum ada data asesmen dari perawat.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Column Right: Doctor's SOAP Assessment Form --}}
            <div class="col-md-8">
                <form wire:submit.prevent="save">
                    {{-- S - SUBJECTIVE --}}
                    <div class="card card-outline card-success shadow-sm border-0 border-left-3 border-left-success mb-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-sm text-success"><i class="fas fa-comment-medical mr-1"></i> S - SUBJEKTIF (Anamnesa)</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Keluhan Utama <span class="text-danger">*</span></label>
                                <input type="text" wire:model.defer="asesmen.subjective.keluhan_utama" class="form-control form-control-sm @error('asesmen.subjective.keluhan_utama') is-invalid @enderror" placeholder="Apa keluhan utamanya?">
                                @error('asesmen.subjective.keluhan_utama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Riwayat Penyakit Sekarang (RPS)</label>
                                <textarea wire:model.defer="asesmen.subjective.rps" class="form-control form-control-sm" rows="3" placeholder="Gali keluhan pasien secara mendalam..."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Riwayat Alergi</label>
                                        <input type="text" wire:model.defer="asesmen.subjective.riwayat_alergi" class="form-control form-control-sm" placeholder="Obat / Makanan / Debu">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Riwayat Penyakit Dahulu</label>
                                        <input type="text" wire:model.defer="asesmen.subjective.rpd" class="form-control form-control-sm" placeholder="Riwayat medis pasien sebelumnya...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- O - OBJECTIVE --}}
                    <div class="card card-outline card-primary shadow-sm border-0 border-left-3 border-left-primary mb-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-sm text-primary"><i class="fas fa-eye mr-1"></i> O - OBJEKTIF</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="form-group">
                                <label class="small font-weight-bold">Pemeriksaan Fisik / Status Lokalis</label>
                                <textarea wire:model.defer="asesmen.objective.status_lokalis" class="form-control form-control-sm" rows="3" placeholder="Hasil pemeriksaan fisik head to toe..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- A - ASSESSMENT --}}
                    <div class="card card-outline card-warning shadow-sm border-0 border-left-3 border-left-warning mb-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-sm text-warning"><i class="fas fa-diagnoses mr-1"></i> A - ASSESMEN (Diagnosa)</h3>
                        </div>
                        <div class="card-body p-3">
                            @foreach ($diagnosa as $index => $diag)
                                <div class="bg-light p-3 rounded mb-3 border position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge badge-{{ $index == 0 ? 'primary' : 'secondary' }} text-xs px-2 py-1 font-weight-bold">{{ $index == 0 ? 'Utama' : 'Sekunder '.$index }}</span>
                                        @if ($index > 0)
                                            <button type="button" class="btn btn-xs btn-danger shadow-xs" wire:click="hapusDiagnosa({{ $index }})"><i class="fas fa-trash"></i></button>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-2">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="icd_{{ $index }}" value="icd" wire:model="diagnosa.{{ $index }}.type" class="custom-control-input">
                                            <label class="custom-control-label text-xs font-weight-bold text-secondary" for="icd_{{ $index }}">ICD-10</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="non_icd_{{ $index }}" value="non_icd" wire:model="diagnosa.{{ $index }}.type" class="custom-control-input">
                                            <label class="custom-control-label text-xs font-weight-bold text-secondary" for="non_icd_{{ $index }}">Manual</label>
                                        </div>
                                    </div>

                                    @if ($diag['type'] == 'icd')
                                        @if(!empty($diagnosa[$index]['code']))
                                            <div class="alert alert-info py-2 px-3 text-xs mb-2 d-flex justify-content-between align-items-center shadow-xs">
                                                <div><i class="fas fa-check-circle text-success mr-1"></i> Terpilih: <strong class="text-primary">{{ $diagnosa[$index]['code'] }}</strong> - {{ $diagnosa[$index]['name'] }}</div>
                                            </div>
                                        @endif
                                        <div class="position-relative">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" placeholder="Cari kode/nama ICD-10..." wire:model.defer="diagnosaSearch.{{ $index }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" wire:click="searchDiagnosa({{ $index }})"><i class="fas fa-search"></i> Cari</button>
                                                </div>
                                            </div>
                                            @if(!empty($diagnosaResults[$index]))
                                                <div class="list-group position-absolute w-100 shadow-lg border mt-1" style="z-index: 2000; max-height: 180px; overflow-y: auto; border-radius: 4px;">
                                                    @foreach($diagnosaResults[$index] as $res)
                                                        <button type="button" class="list-group-item list-group-item-action text-xs py-1" wire:click="selectIcdDiagnosa({{ $index }}, {{ $res->id }}, '{{ $res->code }}', '{{ $res->name }}')">
                                                            <i class="fas fa-file-medical mr-1 text-primary"></i> <b>{{ $res->code }}</b> - {{ $res->name }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <input type="text" class="form-control form-control-sm" placeholder="Ketik diagnosa manual..." wire:model.defer="diagnosa.{{ $index }}.non_icd">
                                    @endif
                                </div>
                            @endforeach
                            <button type="button" class="btn btn-xs btn-outline-success font-weight-bold" wire:click="tambahDiagnosa"><i class="fas fa-plus mr-1"></i> Tambah Diagnosa</button>
                        </div>
                    </div>

                    {{-- P - PLAN & RESEP --}}
                    <div class="card card-outline card-info shadow-sm border-0 border-left-3 border-left-info mb-3">
                        <div class="card-header py-2">
                            <h3 class="card-title font-weight-bold text-sm text-info"><i class="fas fa-clipboard-check mr-1"></i> P - PLAN (Instruksi & Resep)</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Instruksi Medis / Rencana Lanjutan</label>
                                <textarea wire:model.defer="asesmen.plan.terapi" class="form-control form-control-sm" rows="2" placeholder="Instruksi perawat, edukasi, kontrol ulang..."></textarea>
                            </div>

                            {{-- RESEP OBAT JADI --}}
                            <div class="mb-4 border rounded p-3 bg-light shadow-xs border-left-3 border-left-info">
                                <h6 class="text-xs font-weight-bold text-info border-bottom pb-1 mb-3"><i class="fas fa-pills mr-1"></i> RESEP OBAT JADI (NON-RACIK)</h6>
                                
                                @if(count($resep_jadi) > 0)
                                    <div class="row no-gutters mb-2 d-none d-md-flex text-secondary font-weight-bold text-xxs uppercase tracking-wider pb-1 border-bottom">
                                        <div class="col-md-5 pl-1">Nama Obat</div>
                                        <div class="col-md-4 pl-1">Aturan Pakai (Signa)</div>
                                        <div class="col-md-2 pl-1">Jumlah (Qty)</div>
                                        <div class="col-md-1 text-center">Aksi</div>
                                    </div>
                                @endif

                                @foreach($resep_jadi as $i => $rj)
                                    <div class="row no-gutters mb-2 border-bottom pb-2 align-items-center">
                                        <div class="col-md-5 pr-2">
                                            <div class="position-relative">
                                                <input type="text" class="form-control form-control-sm text-xs" placeholder="Ketik & cari nama obat..." 
                                                    wire:model="resep_jadi.{{ $i }}.nama_obat" 
                                                    wire:keyup="searchingObatJadi({{ $i }}, $event.target.value)">
                                                @if(!empty($searchObatJadi[$i]))
                                                    <div class="list-group position-absolute w-100 shadow-lg border mt-1" style="z-index: 1000; max-height: 180px; overflow-y: auto; border-radius: 4px;">
                                                        @foreach($searchObatJadi[$i] as $s)
                                                            <button type="button" class="list-group-item list-group-item-action text-xs py-1" wire:click="selectObatJadi({{ $i }}, {{ $s->id }}, '{{ $s->nama_obat }}')">
                                                                <i class="fas fa-pills mr-1 text-info"></i> {{ $s->nama_obat }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-2">
                                            <input type="text" class="form-control form-control-sm text-xs" placeholder="Aturan Pakai (Signa)" wire:model.defer="resep_jadi.{{ $i }}.signa">
                                        </div>
                                        <div class="col-md-2 pr-2">
                                            <input type="number" class="form-control form-control-sm text-xs" placeholder="Qty" wire:model.defer="resep_jadi.{{ $i }}.qty">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-xs btn-danger shadow-xs" wire:click="hapusResepJadi({{ $i }})"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-xs btn-outline-info rounded-pill font-weight-bold mt-2" wire:click="tambahResepJadi"><i class="fas fa-plus mr-1"></i> Tambah Obat Jadi</button>
                            </div>

                            {{-- RESEP OBAT RACIK --}}
                            <div class="border rounded p-3 bg-light shadow-xs border-left-3 border-left-secondary">
                                <h6 class="text-xs font-weight-bold text-orange border-bottom pb-1 mb-3"><i class="fas fa-mortar-pestle mr-1"></i> RESEP OBAT RACIK</h6>
                                @foreach($resep_racik as $ir => $rr)
                                    <div class="border rounded bg-white p-3 mb-3 shadow-xs position-relative" style="border-left: 3px solid #fd7e14 !important;">
                                        <button type="button" class="btn btn-xs btn-danger position-absolute shadow-xs" style="top:8px; right:8px;" wire:click="hapusResepRacik({{ $ir }})"><i class="fas fa-times"></i></button>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="text-xs font-weight-bold text-secondary">Nama Racikan</label>
                                                <input type="text" class="form-control form-control-sm text-xs" wire:model.defer="resep_racik.{{ $ir }}.nama_racikan" placeholder="Contoh: Racikan Flu">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-xs font-weight-bold text-secondary">Sediaan</label>
                                                <select class="form-control form-control-sm text-xs" wire:model.defer="resep_racik.{{ $ir }}.sediaan">
                                                    <option>Pulveres</option>
                                                    <option>Kapsul</option>
                                                    <option>Sirup</option>
                                                    <option>Salep</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-xs font-weight-bold text-secondary">Aturan (Signa)</label>
                                                <input type="text" class="form-control form-control-sm text-xs" wire:model.defer="resep_racik.{{ $ir }}.signa" placeholder="3 x 1">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-xs font-weight-bold text-secondary">Jumlah</label>
                                                <input type="number" class="form-control form-control-sm text-xs" wire:model.defer="resep_racik.{{ $ir }}.qty">
                                            </div>
                                        </div>
                                        
                                        <div class="bg-light p-2 rounded">
                                            <small class="font-weight-bold text-xs d-block mb-1 text-orange"><i class="fas fa-cubes mr-1"></i> KOMPONEN RACIKAN:</small>
                                            
                                            @if(count($rr['komponen']) > 0)
                                                <div class="row no-gutters mb-1 d-none d-md-flex text-secondary font-weight-bold text-xxs pb-1">
                                                    <div class="col-8 pl-1">Bahan Obat</div>
                                                    <div class="col-3 pl-1">Dosis</div>
                                                    <div class="col-1 text-center"></div>
                                                </div>
                                            @endif

                                            @foreach($rr['komponen'] as $ik => $ko)
                                                <div class="row no-gutters mb-1 align-items-center">
                                                    <div class="col-8 pr-1">
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control form-control-sm text-xs" placeholder="Ketik bahan..." 
                                                                wire:model="resep_racik.{{ $ir }}.komponen.{{ $ik }}.nama_obat"
                                                                wire:keyup="searchingObatRacik({{ $ir }}, {{ $ik }}, $event.target.value)">
                                                            @if(!empty($searchObatRacik[$ir][$ik]))
                                                                <div class="list-group position-absolute w-100 shadow-lg border mt-1" style="z-index: 1000; max-height: 150px; overflow-y: auto; border-radius: 4px;">
                                                                    @foreach($searchObatRacik[$ir][$ik] as $sr)
                                                                        <button type="button" class="list-group-item list-group-item-action text-xs py-1" wire:click="selectObatRacik({{ $ir }}, {{ $ik }}, {{ $sr->id }}, '{{ $sr->nama_obat }}')">
                                                                            <i class="fas fa-pills mr-1 text-orange"></i> {{ $sr->nama_obat }}
                                                                        </button>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-3 pr-1">
                                                        <input type="text" class="form-control form-control-sm text-xs" placeholder="Dosis" wire:model.defer="resep_racik.{{ $ir }}.komponen.{{ $ik }}.dosis">
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <button type="button" class="btn btn-xs btn-link text-danger" wire:click="hapusKomponenRacik({{ $ir }}, {{ $ik }})"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-xs btn-link text-primary font-weight-bold p-0 mt-1" wire:click="tambahKomponenRacik({{ $ir }})">+ Tambah Komponen</button>
                                        </div>
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill font-weight-bold" wire:click="tambahResepRacik"><i class="fas fa-mortar-pestle mr-1"></i> Buat Racikan Baru</button>
                            </div>
                        </div>
                    </div>

                    <div class="text-right pb-5">
                        <button type="button" class="btn btn-secondary px-4 shadow-sm btn-sm font-weight-bold" wire:click="resetFields">Batal</button>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm ml-2 btn-sm font-weight-bold"><i class="fas fa-save mr-1"></i> SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    @endif


    {{-- Tabel Pasien Queue --}}
    @if (!$id_regis)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-info text-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="card-title text-md font-weight-bold"><i class="fas fa-hospital-user mr-2"></i> Antrian Asesmen Medis</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="d-inline-flex align-items-center">
                            <span class="text-xs mr-2 font-weight-bold text-light"><i class="fas fa-calendar-alt mr-1"></i> Periode:</span>
                            <input type="date" wire:model="startDate" class="form-control form-control-sm mr-2 shadow-xs border-0 text-xs font-weight-bold text-dark px-2 py-1" style="width: auto; border-radius: 4px;">
                            <span class="text-xs mr-2 font-weight-bold text-light">s/d</span>
                            <input type="date" wire:model="endDate" class="form-control form-control-sm shadow-xs border-0 text-xs font-weight-bold text-dark px-2 py-1" style="width: auto; border-radius: 4px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="medisTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-xs py-3 px-4" style="width: 250px;">No RM / Pasien</th>
                                <th class="text-xs py-3">Poliklinik</th>
                                <th class="text-xs py-3">Dokter</th>
                                <th class="text-xs py-3 text-center" style="width: 180px;">Status</th>
                                <th class="text-xs py-3" style="width: 110px;">Waktu Daftar</th>
                                <th class="text-xs py-3 text-center" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pasiens as $pasien)
                                <tr>
                                    <td class="px-4 py-2 align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 text-secondary" style="font-size: 1.4rem;"><i class="fas fa-user-injured text-muted"></i></div>
                                            <div>
                                                <div class="font-weight-bold text-primary text-sm">{{ $pasien->no_rekam_medis }}</div>
                                                <div class="text-xs text-uppercase font-weight-bold text-secondary">{{ $pasien->nama_pasien }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle"><span class="badge badge-light border text-xs">{{ $pasien->nama_poli }}</span></td>
                                    <td class="align-middle"><small class="text-muted font-weight-bold">{{ $pasien->nama_dokter }}</small></td>
                                    <td class="align-middle text-center">
                                        @if(str_contains($pasien->status, 'Medis'))
                                            <span class="badge badge-success px-2 py-1 shadow-xs"><i class="fas fa-check-double mr-1"></i> Selesai Asesmen</span>
                                        @elseif(str_contains($pasien->status, 'Perawat'))
                                            <span class="badge badge-warning px-2 py-1 shadow-xs text-dark"><i class="fas fa-user-clock mr-1"></i> Menunggu Dokter</span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1 shadow-xs"><i class="fas fa-exclamation-triangle mr-1"></i> Belum Asesmen Perawat</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-xs">
                                        <b class="text-dark">{{ \Carbon\Carbon::parse($pasien->tanggal_regis)->format('H:i') }}</b> 
                                        <br> 
                                        <span class="text-muted text-xxs font-weight-bold">{{ \Carbon\Carbon::parse($pasien->tanggal_regis)->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if(str_contains($pasien->status, 'Medis'))
                                            <button class="btn btn-xs btn-outline-warning px-3 shadow-xs rounded-pill font-weight-bold" wire:click="selectPasien({{ $pasien->id_regis }})">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                        @else
                                            <button class="btn btn-xs btn-primary px-3 shadow-xs rounded-pill font-weight-bold" wire:click="selectPasien({{ $pasien->id_regis }})">
                                                <i class="fas fa-stethoscope mr-1"></i> Periksa
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted bg-light border-0">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-25"></i>
                                        <span class="text-xs italic">Tidak ada antrian pada periode ini.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        initDataTable();
        window.livewire.on('reInitTable', () => initDataTable());
    });

    function initDataTable() {
        if ($.fn.DataTable.isDataTable('#medisTable')) {
            $('#medisTable').DataTable().destroy();
        }
        $('#medisTable').DataTable({
            paging: true,
            searching: true,
            ordering: false,
            responsive: true,
            language: { search: "", searchPlaceholder: "Cari Pasien..." }
        });
    }
</script>
<style>
    .shadow-xs { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important; }
    .text-orange { color: #fd7e14; }
    .bg-gradient-info { background: linear-gradient(45deg, #17a2b8, #20c997) !important; }
    .card-outline.card-success { border-top: 3px solid #28a745; }
    .card-outline.card-primary { border-top: 3px solid #007bff; }
    .card-outline.card-warning { border-top: 3px solid #ffc107; }
    .card-outline.card-info { border-top: 3px solid #17a2b8; }
    .text-xs { font-size: 0.75rem; }
    .text-xxs { font-size: 0.68rem; letter-spacing: 0.03em; }
    .font-weight-bold { font-weight: 700 !important; }
    .border-left-3 { border-left: 3px solid !important; }
    .border-left-primary { border-left-color: #007bff !important; }
    .border-left-success { border-left-color: #28a745 !important; }
    .border-left-danger { border-left-color: #dc3545 !important; }
    .border-left-warning { border-left-color: #ffc107 !important; }
    .border-left-info { border-left-color: #17a2b8 !important; }
    .border-left-secondary { border-left-color: #6c757d !important; }
</style>
@endpush
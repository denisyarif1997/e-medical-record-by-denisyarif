@section('title', 'Telaah Farmasi')

<div class="container-fluid py-3">
    @if (session()->has('message'))
        <div class="alert alert-success shadow-sm">{{ session('message') }}</div>
    @endif

    @if($id_regis)
        <div class="row">
            {{-- Left: Prescription Data --}}
            <div class="col-md-6">
                <div class="card card-outline card-info shadow-sm">
                    <div class="card-header"><h3 class="card-title text-sm"><i class="fas fa-prescription"></i> Data Resep - {{ $data->nama_pasien }}</h3></div>
                    <div class="card-body p-3 overflow-auto" style="max-height: 500px;">
                        @if(!empty($medicalData['resep_jadi']))
                            <h6 class="text-xs font-weight-bold text-primary">Obat Jadi:</h6>
                            <ul class="list-group mb-3 text-xs">
                                @foreach($medicalData['resep_jadi'] as $rj)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><b>{{ $rj['nama_obat'] }}</b> <br> <small>{{ $rj['signa'] }}</small></span>
                                        <span class="badge badge-primary">Qty: {{ $rj['qty'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if(!empty($medicalData['resep_racik']))
                            <h6 class="text-xs font-weight-bold text-orange">Obat Racik:</h6>
                            @foreach($medicalData['resep_racik'] as $rr)
                                <div class="border rounded p-2 mb-2 bg-light shadow-xs">
                                    <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                                        <span class="text-xs font-weight-bold">{{ $rr['nama_racikan'] }} ({{ $rr['sediaan'] }})</span>
                                        <span class="badge badge-warning">Qty: {{ $rr['qty'] }}</span>
                                    </div>
                                    <small class="d-block text-xs italic mb-1">{{ $rr['signa'] }}</small>
                                    @foreach($rr['komponen'] as $k)
                                        <small class="d-block text-xs">- {{ $k['nama_obat'] }} ({{ $k['dosis'] }})</small>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif

                        @if(empty($medicalData['resep_jadi']) && empty($medicalData['resep_racik']))
                            <p class="text-xs italic text-muted">Tidak ada resep obat terinci.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Clinical Review Form --}}
            <div class="col-md-6">
                <div class="card card-outline card-success shadow-sm">
                    <div class="card-header"><h3 class="card-title text-sm"><i class="fas fa-check-double text-success"></i> Form Telaah Farmasi</h3></div>
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            <h6 class="text-xs font-weight-bold text-muted border-bottom mb-2">1. PERSYARATAN ADMINISTRASI</h6>
                            <div class="mb-3 pl-2">
                                @foreach($telaah['adm'] as $key => $val)
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="adm_{{ $key }}" wire:model="telaah.adm.{{ $key }}">
                                        <label class="custom-control-label text-xs" for="adm_{{ $key }}">{{ ucwords(str_replace('_', ' ', $key)) }} Benar/Lengkap</label>
                                    </div>
                                @endforeach
                            </div>

                            <h6 class="text-xs font-weight-bold text-muted border-bottom mb-2">2. PERSYARATAN FARMASETIK</h6>
                            <div class="mb-3 pl-2">
                                @foreach($telaah['pharm'] as $key => $val)
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="pharm_{{ $key }}" wire:model="telaah.pharm.{{ $key }}">
                                        <label class="custom-control-label text-xs" for="pharm_{{ $key }}">{{ ucwords(str_replace('_', ' ', $key)) }} Benar/Lengkap</label>
                                    </div>
                                @endforeach
                            </div>

                            <h6 class="text-xs font-weight-bold text-muted border-bottom mb-2">3. PERSYARATAN KLINIS</h6>
                            <div class="mb-3 pl-2">
                                @foreach($telaah['clinical'] as $key => $val)
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="clin_{{ $key }}" wire:model="telaah.clinical.{{ $key }}">
                                        <label class="custom-control-label text-xs" for="clin_{{ $key }}">{{ ucwords(str_replace('_', ' ', $key)) }} Sesuai/Tepat</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-right">
                                <button type="button" class="btn btn-secondary btn-sm" wire:click="$set('id_regis', null)">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm ml-2">Simpan Telaah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$id_regis)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-success text-white py-2">
                <div class="row align-items-center">
                    <div class="col-8"><h3 class="card-title text-sm"><i class="fas fa-microscope"></i> Telaah Farmasi - Daftar Resep</h3></div>
                    <div class="col-4">
                        <div class="d-flex no-gutters h-25">
                            <input type="date" wire:model="startDate" class="form-control form-control-sm mr-1 h-25">
                            <input type="date" wire:model="endDate" class="form-control form-control-sm h-25">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="telaahTable">
                        <thead>
                            <tr class="text-xs bg-light">
                                <th class="px-4">No RM / Pasien</th>
                                <th>Tanggal</th>
                                <th class="text-center">Status Telaah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pasiens as $p)
                                @php $asmed = json_decode($p->asesmen, true); @endphp
                                <tr>
                                    <td class="px-4 py-3 align-middle">
                                        <div class="text-primary font-weight-bold text-sm">{{ $p->no_rekam_medis }}</div>
                                        <div class="text-xs text-uppercase">{{ $p->nama_pasien }}</div>
                                    </td>
                                    <td class="align-middle text-xs">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/y H:i') }}</td>
                                    <td class="align-middle text-center">
                                        @if(isset($asmed['telaah_farmasi']))
                                            <span class="badge badge-success text-xs px-2"><i class="fas fa-check"></i> Sudah Ditelaah</span>
                                        @else
                                            <span class="badge badge-warning text-xs px-2">Menunggu Telaah</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class="btn btn-xs btn-primary shadow-sm rounded-pill px-3" wire:click="selectPasien({{ $p->id_regis }})">
                                            <i class="fas fa-search"></i> Teliti Resep
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
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
        $('#telaahTable').DataTable({ paging: true, searching: true, ordering: false, language: { search: "" } });
    });
</script>
<style>
    .bg-gradient-success { background: linear-gradient(45deg, #28a745, #20c997); }
    .text-orange { color: #fd7e14; }
    .text-xs { font-size: 0.75rem; }
</style>
@endpush

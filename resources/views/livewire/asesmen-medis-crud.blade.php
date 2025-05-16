@section('title', 'Asesmen Medis')

<div class="container py-3">

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Form Asesmen --}}
    @if ($id_regis)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Form Asesmen Medis
            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="row">
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Tanggal Kunjungan</strong></label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y, H:i') }} WIB"
                                    readonly>
                            </div>
                        </div> --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Nama Pasien</strong></label>
                                <input type="text" class="form-control" value="{{ $data->nama_pasien }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>ID Kunjungan</strong></label>
                                <input type="text" class="form-control" id="id_regis" value="{{ $data->id_regis }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>No Rekam Medis</strong></label>
                                <input type="text" class="form-control" value="{{ $data->no_rekam_medis }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Dokter</strong></label>
                                <input type="text" class="form-control" value="{{ $data->nama_dokter }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Poliklinik</strong></label>
                                <input type="text" class="form-control" value="{{ $data->nama_poli }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Asuransi</strong></label>
                                <input type="text" class="form-control" value="{{ $data->nama_asuransi }}" readonly>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="row">
                            {{-- ANAMNESIS --}}
                            <div class="col-12 mb-3">
                                <h5 class="border-bottom pb-1">Anamnesis</h5>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="tujuan_kunjungan" class="form-label">Tujuan Kunjungan</label>
                                <input type="text" id="tujuan_kunjungan" class="form-control"
                                    wire:model="asesmen.tujuan_kunjungan">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="keluhan_utama" class="form-label">Keluhan Utama</label>
                                <input type="text" id="keluhan_utama" class="form-control"
                                    wire:model="asesmen.keluhan_utama">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="keadaan_umum" class="form-label">Keadaan Umum</label>
                                <input type="text" id="keadaan_umum" class="form-control" wire:model="asesmen.keadaan_umum">
                            </div>

                            {{-- TANDA-TANDA VITAL --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="border-bottom pb-1">Tanda-Tanda Vital (TTV)</h5>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="sistolik" class="form-label">Sistolik (mmHg)</label>
                                <input type="number" id="sistolik" class="form-control" wire:model="asesmen.sistolik">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="diastolik" class="form-label">Diastolik (mmHg)</label>
                                <input type="number" id="diastolik" class="form-control" wire:model="asesmen.diastolik">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="nadi" class="form-label">Nadi (x/menit)</label>
                                <input type="number" id="nadi" class="form-control" wire:model="asesmen.nadi">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="pernapasan" class="form-label">Pernapasan (x/menit)</label>
                                <input type="number" id="pernapasan" class="form-control" wire:model="asesmen.pernapasan">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="suhu" class="form-label">Suhu (°C)</label>
                                <input type="number" step="0.1" id="suhu" class="form-control" wire:model="asesmen.suhu">
                            </div>

                            {{-- TINGGI / BERAT / IMT --}}
                            <div class="mb-3 col-md-4">
                                <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" id="tinggi_badan" class="form-control"
                                    wire:model="asesmen.tinggi_badan">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                <input type="number" id="berat_badan" class="form-control" wire:model="asesmen.berat_badan">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="imt" class="form-label">IMT</label>
                                <input type="text" id="imt" class="form-control" wire:model="asesmen.imt" readonly>
                            </div>

                            {{-- PEMERIKSAAN FISIK --}}
                            <div class="col-12 mt-4 mb-3">
                                <h5 class="border-bottom pb-1">Pemeriksaan Fisik</h5>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="pemeriksaan_fisik" class="form-label">Pemeriksaan Fisik</label>
                                <textarea id="pemeriksaan_fisik" rows="3" class="form-control"
                                    wire:model="asesmen.pemeriksaan_fisik"></textarea>
                            </div>
                        </div>

                        {{-- OBAT --}}
                        <div class="col-12 mt-4 mb-3">
                            <h5 class="border-bottom pb-1">Obat</h5>
                        </div>

                        @if (!empty($obat))
                            @foreach ($obat as $index => $item)
                                <div class="mb-2 col-md-10">
                                    <input type="text" class="form-control" placeholder="Nama Obat" wire:model="obat.{{ $index }}">
                                </div>
                                <div class="mb-2 col-md-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        wire:click="hapusObat({{ $index }})">Hapus</button>
                                </div>
                            @endforeach
                        @endif

                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-primary btn-sm" wire:click="tambahObat">+ Tambah
                                Obat</button>
                        </div>

                        {{-- TINDAKAN --}}
                        <div class="col-12 mt-4 mb-3">
                            <h5 class="border-bottom pb-1">Procedure</h5>
                        </div>

                        @if (!empty($procedure))
                            @foreach ($procedure as $index => $item)
                                <div class="mb-2 col-md-10">
                                    <input type="text" class="form-control" placeholder="Nama Tindakan"
                                        wire:model="procedure.{{ $index }}">
                                </div>
                                <div class="mb-2 col-md-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        wire:click="hapusTindakan({{ $index }})">Hapus</button>
                                </div>
                            @endforeach
                        @endif

                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-primary btn-sm" wire:click="tambahTindakan">+ Tambah
                                Tindakan</button>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary ms-2"
                            wire:click="$set('id_regis', null)">Batal</button>
                </form>
            </div>
        </div>
    @endif

    {{-- Tabel Pasien --}}
    <div class="card">
        <div class="card-header bg-info text-white">
            Pilih Pasien
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered" id="askepTable">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Pasien</th>
                        <th>No RM</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Asuransi</th>
                        <th>Status</th>
                        <th>Tanggal Registrasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasiens as $pasien)
                        <tr>
                            <td>{{ $pasien->id_regis }}</td>
                            <td>{{ $data->nama_pasien }}</td>
                            <td>{{ $pasien->no_rekam_medis }}</td>
                            <td>{{ $pasien->nama_poli }}</td>
                            <td>{{ $pasien->nama_dokter }}</td>
                            <td>{{ $pasien->nama_asuransi }}</td>
                            <td>
                                @php
                                    $statusText = $pasien->status;
                                    $badgeClass = 'secondary';

                                    if (str_contains($statusText, 'Sudah Asesmen Medis')) {
                                        $badgeClass = 'success';
                                    } elseif (str_contains($statusText, 'Sudah Asesmen Perawat')) {
                                        $badgeClass = 'warning';
                                    } elseif (str_contains($statusText, 'Belum Asesmen Perawat')) {
                                        $badgeClass = 'danger';
                                    }
                                @endphp

                                <span class="badge bg-{{ $badgeClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td>{{ $pasien->tanggal_regis }}</td>

                            <td>
                                <button class="btn btn-primary btn-sm" wire:click="selectPasien({{ $pasien->id_regis }})">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Data tidak tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@section('js')
    <script>
        $(function () {
            $('#askepTable').DataTable({
                paging: true,
                searching: true,
                ordering: false,
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
@endsection
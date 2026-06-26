<x-admin>
    @section('title', 'Asesmen Keperawatan')

    <div class="container-fluid mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h3 class="card-title font-weight-bold"><i class="fas fa-user-nurse mr-2"></i> Asesmen Keperawatan</h3>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- Filter Section --}}
                <div class="bg-light p-3 rounded mb-4 shadow-sm border">
                    <form method="GET" action="{{ route('admin.asesmen_perawat.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tanggal_awal" class="text-xs font-weight-bold text-secondary">TANGGAL AWAL</label>
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm"
                                    value="{{ request('tanggal_awal', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_akhir" class="text-xs font-weight-bold text-secondary">TANGGAL AKHIR</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-sm"
                                    value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-sm btn-primary px-3 shadow-sm"><i class="fas fa-filter mr-1"></i> Filter</button>
                                <a href="{{ route('admin.asesmen_perawat.index') }}" class="btn btn-sm btn-secondary px-3 shadow-sm"><i class="fas fa-redo mr-1"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-sm" id="askepTable">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>ID Kunjungan</th>
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Daftar</th>
                                <th>Poliklinik</th>
                                <th>Dokter</th>
                                <th>Asuransi</th>
                                <th class="text-center" style="width: 180px;">Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $askep)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><small class="text-muted font-weight-bold">{{ $askep->id_regis }}</small></td>
                                    <td class="font-weight-bold text-primary">{{ $askep->no_rekam_medis }}</td>
                                    <td>{{ $askep->nama_pasien }}</td>
                                    <td><small>{{ \Carbon\Carbon::parse($askep->created_at)->format('d-m-Y H:i') }}</small></td>
                                    <td><span class="badge badge-light border">{{ $askep->nama_poli }}</span></td>
                                    <td><small class="text-muted">{{ $askep->nama_dokter }}</small></td>
                                    <td><span class="badge badge-light border text-secondary">{{ $askep->nama_asuransi }}</span></td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center">
                                            {{-- Status Asesmen Perawat --}}
                                            @if(!is_null($askep->id_asemen_perawat) && is_null($askep->deleted_at_perawat))
                                                <span class="badge badge-success mb-1 w-100 py-1"><i class="fas fa-user-nurse mr-1"></i> Perawat: Selesai</span>
                                            @else
                                                <span class="badge badge-danger mb-1 w-100 py-1"><i class="fas fa-exclamation-circle mr-1"></i> Perawat: Belum</span>
                                            @endif
                                        
                                            {{-- Status Asesmen Medis --}}
                                            @if(!is_null($askep->id_asesmen_medis))
                                                <span class="badge badge-success w-100 py-1"><i class="fas fa-check-double mr-1"></i> Medis: Selesai</span>
                                            @else
                                                <span class="badge badge-warning w-100 py-1 text-dark"><i class="fas fa-clock mr-1"></i> Medis: Belum</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if (!is_null($askep->id_asemen_perawat) && is_null($askep->deleted_at_perawat))
                                            <a href="{{ route('admin.asesmen_perawat.edit', $askep->id_asemen_perawat) }}"
                                                class="btn btn-xs btn-outline-warning btn-block shadow-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        @else
                                            <a href="{{ route('admin.asesmen_perawat.createWithId', $askep->id_regis) }}"
                                                class="btn btn-xs btn-primary btn-block shadow-sm">
                                                <i class="fas fa-plus"></i> Asesmen
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
</x-admin>
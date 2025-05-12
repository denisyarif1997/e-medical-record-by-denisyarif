<x-admin>
    @section('title', 'Asesmen Keperawatan')

    <div class="container-fluid mt-3">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-notes-medical"></i> Asesmen Keperawatan</h3>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="GET" action="{{ route('admin.asesmen_perawat.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="tanggal_awal"><strong>Tanggal Awal</strong></label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                                value="{{ request('tanggal_awal', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal_akhir"><strong>Tanggal Akhir</strong></label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                                value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                            <a href="{{ route('admin.asesmen_perawat.index') }}" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</a>
                        </div>
                    </div>
                </form>

                <table class="table table-hover table-bordered" id="askepTable">
                    <thead class="table-primary">
                        <tr>
                            <th>ID Kunjungan</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Daftar</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Asuransi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $askep)
                            <tr>
                                <td>{{ $askep->id_regis }}</td>
                                <td>{{ $askep->no_rekam_medis }}</td>
                                <td>{{ $askep->nama_pasien }}</td>
                                <td>{{ \Carbon\Carbon::parse($askep->created_at)->format('d-m-Y H:i') }}</td>
                                <td>{{ $askep->nama_poli }}</td>
                                <td>{{ $askep->nama_dokter }}</td>
                                <td>{{ $askep->nama_asuransi }}</td>
                                <td>
                                    {{-- Status Asesmen Perawat --}}
                                    @if(!is_null($askep->id_asemen_perawat))
                                        <span class="badge bg-success">Sudah Asesmen Perawat</span>
                                    @else
                                        <span class="badge bg-danger">Belum Asesmen Perawat</span>
                                    @endif
                                    <br>
                                
                                    {{-- Status Asesmen Medis --}}
                                    @if(!is_null($askep->id_asesmen_medis))
                                        <span class="badge bg-success">Sudah Asesmen Medis</span>
                                    @else
                                        <span class="badge bg-danger">Belum Asesmen Medis</span>
                                    @endif
                                </td>
                                
                                
                                <td class="text-center">
                                    <a href="{{ route('admin.asesmen_perawat.createWithId', $askep->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-check"></i> Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
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
</x-admin>
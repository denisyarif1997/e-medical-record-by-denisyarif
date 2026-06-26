<x-admin>
    @section('title', 'Asesmen Medis')

    <div class="container-fluid mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-info text-white py-3">
                <h3 class="card-title"><i class="fas fa-stethoscope"></i> Daftar Kunjungan - Asesmen Medis</h3>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Filter Section --}}
                <div class="bg-light p-3 rounded mb-4 shadow-sm">
                    <form method="GET" action="{{ route('admin.asesmen_medis.index') }}">
                        <div class="row items-center">
                            <div class="col-md-3">
                                <label class="text-xs font-weight-bold">TANGGAL AWAL</label>
                                <input type="date" name="tanggal_awal" class="form-control form-control-sm"
                                    value="{{ request('tanggal_awal', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="text-xs font-weight-bold">TANGGAL AKHIR</label>
                                <input type="date" name="tanggal_akhir" class="form-control form-control-sm"
                                    value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-sm btn-info px-3 shadow-sm"><i class="fas fa-search"></i></button>
                                <a href="{{ route('admin.asesmen_medis.index') }}" class="btn btn-sm btn-secondary px-3 shadow-sm"><i class="fas fa-sync"></i></a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-sm" id="asmedTable">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                                <th>Poliklinik</th>
                                <th>Dokter</th>
                                <th class="text-center">Status Asesmen</th>
                                <th class="text-center">Status Medis</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-weight-bold text-primary">{{ $item->no_rekam_medis }}</td>
                                    <td>{{ $item->nama_pasien }}</td>
                                    <td><span class="badge badge-light border">{{ $item->nama_poli }}</span></td>
                                    <td><small>{{ $item->nama_dokter }}</small></td>
                                    <td class="text-center">
                                        @php
                                            $hasNurse = DB::table('asesmen_perawat')->where('id_regis', $item->id_regis)->exists();
                                        @endphp
                                        @if($hasNurse)
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Perawat</span>
                                        @else
                                            <span class="badge badge-danger">Belum Perawat</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->id_asemen)
                                            <span class="badge badge-success"><i class="fas fa-check-double"></i> Medis</span>
                                        @else
                                            <span class="badge badge-warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->id_asemen)
                                            <a href="{{ route('admin.asesmen_medis.edit', $item->id_asemen) }}" class="btn btn-xs btn-outline-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        @else
                                            <a href="{{ route('admin.asesmen_medis.createWithId', $item->id_regis) }}" class="btn btn-xs btn-primary shadow-sm px-3">
                                                <i class="fas fa-stethoscope"></i> PERIKSA
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
            $('#asmedTable').DataTable({
                paging: true,
                searching: true,
                ordering: false,
                responsive: true
            });
        });
    </script>
    @endsection
</x-admin>

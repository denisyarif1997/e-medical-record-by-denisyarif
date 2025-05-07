<x-admin>
    @section('title', 'Asesmen Keperawatan')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Asesmen Keperawatan</h3>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped" id="askepTable">
                <thead>
                    <tr>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Daftar</th>
                        <th>Poliklinik</th>
                        <th>Dokter</th>
                        <th>Asuransi</th>
                        <th>No Asuransi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $askep)
                        <tr>
                            <td>{{ $askep->no_rekam_medis }}</td>
                            <td>{{ $askep->nama_pasien }}</td>
                            <td>{{ \Carbon\Carbon::parse($askep->created_at)->format('d-m-Y H:i') }}</td>
                            <td>{{ $askep->nama_poli }}</td>
                            <td>{{ $askep->nama_dokter }}</td>
                            <td>{{ $askep->nama_asuransi }}</td>
                            <td>{{ $askep->no_asuransi }}</td>
                            <td>
                                @if(!is_null($askep->id_asemen))
                                    <span class="badge badge-success">Sudah Asesmen</span>
                                @else
                                    <span class="badge badge-danger">Belum Asesmen</span>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('admin.asesmen_perawat.createWithId', $askep->id) }}"
                                    class="btn btn-sm btn-primary">Pilih</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('js')
        <script>
            $(function () {
                $('#askepTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: false,
                    responsive: true
                });
            });
        </script>
    @endsection
</x-admin>
<x-admin>
    @section('title', 'Pendaftaran Pasien')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Pendaftaran Pasien</h3>
            <div class="card-tools">
                <a href="{{ route('admin.pendaftaran.cari_pasien') }}" class="btn btn-sm btn-info">Pendaftaran Baru</a>
            </div>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-3">
            <label for="tanggal_awal">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                value="{{ request('tanggal_awal', date('Y-m-d')) }}">
        </div>
        <div class="col-md-3">
            <label for="tanggal_akhir">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>

            <table class="table table-striped" id="pendaftaranTable">
                <thead>
                    <tr>
                        <th>ID Registrasi</th>
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
                    @foreach ($pendaftarans as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->no_rekam_medis  }}</td>
                        <td>{{ $data->nama_pasien }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}</td>
                        <td>{{ $data->nama_poli }}</td>
                        <td>{{ $data->nama_dokter }}</td>
                        <td>{{ $data->nama_asuransi }}</td>
                        <td>{{ $data->no_asuransi }}</td>
                        {{-- <td>{{ $data->status }}</td> --}}

                        <td>
                            @if($data->status == 1)
                                <span class="badge badge-success">Aktif</span>
                            @elseif($data->status == 2)
                                <span class="badge badge-danger">Batal</span>
                            @else
                                <span class="badge badge-secondary">Non Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pendaftaran.edit', encrypt($data->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.pendaftaran.destroy', encrypt($data->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data pendaftaran ini?')">
                                @method('DELETE')
                                @csrf
                                {{-- <button type="submit" class="btn btn-sm btn-danger">Delete</button> --}}
                            </form>
                            <form action="{{ route('admin.pendaftaran.cancelVisit', encrypt($data->id)) }}" method="POST" onsubmit="return confirm('Batalkan kunjungan pasien ini?')" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Batal</button>
                            </form>
                            
                            
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
                $('#pendaftaranTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": false,
                    "responsive": true,
                });
            });
        </script>
    @endsection
</x-admin>

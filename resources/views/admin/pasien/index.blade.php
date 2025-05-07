<x-admin>
    @section('title', 'Pasien')

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-users"></i> Data Pasien</h3>
            <div class="card-tools">
                <a href="{{ route('admin.pasien.create') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-user-plus"></i> Pasien Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table table-hover table-bordered" id="pasienTable">
                <thead class="table-primary">
                    <tr>
                        <th>No RM</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Umur</th>
                        <th>No HP</th>
                        <th>Penanggung</th>
                        <th>Asuransi</th>
                        <th>No Asuransi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasiens as $pasien)
                    <tr>
                        <td>{{ $pasien->no_rekam_medis }}</td>
                        <td>{{ $pasien->nik }}</td>
                        <td>{{ $pasien->nama }}</td>
                        <td class="text-center">
                            @if($pasien->jenis_kelamin == 'P')
                                <i class="fas fa-female text-pink"></i> 
                            @elseif($pasien->jenis_kelamin == 'L')
                                <i class="fas fa-male text-primary"></i> 
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->diff(now())->format('%y tahun %m bulan %d hari') }}
                        </td>
                        <td>{{ $pasien->no_hp }}</td>
                        <td>{{ $pasien->penanggung }}</td>
                        <td>{{ $pasien->nama_asuransi }}</td>
                        <td>{{ $pasien->no_asuransi }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.pasien.edit', encrypt($pasien->id)) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.pasien.destroy', encrypt($pasien->id)) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pasien ini?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
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
                $('#pasienTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": false,
                    "responsive": true,
                    "language": {
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "paginate": {
                            "next": "Berikutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            });
        </script>
    @endsection
</x-admin>
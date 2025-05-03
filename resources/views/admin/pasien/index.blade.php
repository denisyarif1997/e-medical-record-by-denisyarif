<x-admin>
    @section('title', 'Pasien')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Pasien</h3>
            <div class="card-tools">
                <a href="{{ route('admin.pasien.create') }}" class="btn btn-sm btn-info">Pasien Baru</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="pasienTable">
                <thead>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasiens as $pasien)
                    <tr>
                        <td>{{ $pasien->no_rekam_medis }}</td>
                        <td>{{ $pasien->nik }}</td>
                        <td>{{ $pasien->nama }}</td>
                        <td>
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

                        <td>
                            <a href="{{ route('admin.pasien.edit', encrypt($pasien->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.pasien.destroy', encrypt($pasien->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data pasien ini?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
                });
            });
        </script>
    @endsection
</x-admin>

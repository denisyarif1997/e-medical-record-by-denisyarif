<x-admin>
    @section('title','Tenaga Medis')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tenaga Medis Table</h3>
            <div class="card-tools">
                <a href="{{ route('admin.tenaga_medis.create') }}" class="btn btn-sm btn-info">New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="tenagaMedisTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>No HP</th>
                        <th>Spesialis</th>
                        <th>STR</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenagaMedis as $tm)
                    <tr>
                        <td>{{ $tm->nama }}</td>
                        <td>{{ $tm->type }}</td>
                        <td>{{ $tm->no_hp }}</td>
                        <td>{{ $tm->nama_spesialis }}</td>
                        <td>{{ $tm->str }}</td>
                        <td>{{ $tm->jenis_kelamin }}</td>
                        <td>
                            <a href="{{ route('admin.tenaga_medis.edit', encrypt($tm->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.tenaga_medis.destroy', encrypt($tm->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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
        $(function() {
            $('#tenagaMedisTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
            });
        });
    </script>
    @endsection
</x-admin>
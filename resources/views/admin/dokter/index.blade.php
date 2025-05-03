<x-admin>
    @section('title','Dokter')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dokter Table</h3>
            <div class="card-tools">
                <a href="{{ route('admin.dokter.create') }}" class="btn btn-sm btn-info">New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="dokterTable">
                <thead>
                    <tr>
                        <th>Nama Dokter</th>
                        <th>No HP</th>
                        <th>Spesialis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dokters as $dokter)
                    <tr>
                        <td>{{ $dokter->nama }}</td>
                        <td>{{ $dokter->no_hp }}</td>
                        <td>{{ $dokter->nama_spesialis }}</td>
                        <td>
                            <a href="{{ route('admin.dokter.edit', encrypt($dokter->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.dokter.destroy', encrypt($dokter->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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
            $('#dokterTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
            });
        });
    </script>
    @endsection
</x-admin>

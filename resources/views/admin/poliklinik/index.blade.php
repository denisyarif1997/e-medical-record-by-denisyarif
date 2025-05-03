<x-admin>
    @section('title', 'Poliklinik')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Poliklinik Table</h3>
            <div class="card-tools">
                <a href="{{ route('admin.poliklinik.create') }}" class="btn btn-sm btn-info">New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="poliklinikTable">
                <thead>
                    <tr>
                        <th>Nama Poliklinik</th>
                        <th>Dokter</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Hari</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($poliklinik as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->dokter_nama }}</td>
                        <td>{{ $item->waktu_mulai }}</td>
                        <td>{{ $item->waktu_selesai }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>
                            <a href="{{ route('admin.poliklinik.edit', encrypt($item->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.poliklinik.destroy', encrypt($item->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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
            $('#poliklinikTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
            });
        });
    </script>
    @endsection
</x-admin>

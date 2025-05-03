<x-admin>
    @section('title', 'Spesialis')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Spesialis</h3>
            <div class="card-tools">
                <a href="{{ route('admin.spesialis.create') }}" class="btn btn-sm btn-info">New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="spesialisTable">
                <thead>
                    <tr>
                        <th>Nama Spesialis</th>
                        <th>Code</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spesialis as $s)
                        <tr>
                            <td>{{ $s->nama_spesialis }}</td>
                            <td>{{ $s->code }}</td>
                            <td>
                                <a href="{{ route('admin.spesialis.edit', encrypt($s->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.spesialis.destroy', encrypt($s->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
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
                $('#spesialisTable').DataTable({
                    responsive: true
                });
            });
        </script>
    @endsection
</x-admin>

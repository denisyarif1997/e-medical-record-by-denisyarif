<x-admin>
    @section('title', 'Formula')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Formula</h3>
            <div class="card-tools">
                <a href="{{ route('admin.formula.create') }}" class="btn btn-sm btn-info">New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="formulaTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Faktor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulas as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->keterangan }}</td>
                            <td>{{ $data->faktor }}</td>

                            <td>
                                <a href="{{ route('admin.formula.edit', ($data->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.formula.destroy', ($data->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                $('#formulaTable').DataTable({
                    responsive: true
                });
            });
        </script>
    @endsection
</x-admin>

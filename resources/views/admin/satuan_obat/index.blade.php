<x-admin>
    @section('title', 'SatuanObat')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Satuan Obat</h3>
            <div class="card-tools">
                <a href="{{ route('admin.satuan_obat.create') }}" class="btn btn-sm btn-info">New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="satuanObatTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($satuans as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            {{-- <td>{{ $s->code }}</td> --}}
                            <td>
                                <a href="{{ route('admin.satuan_obat.edit', ($data->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.satuan_obat.destroy', ($data->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                $('#satuanObatTable').DataTable({
                    responsive: true
                });
            });
        </script>
    @endsection
</x-admin>

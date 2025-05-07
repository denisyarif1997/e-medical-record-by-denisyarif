<x-admin>
    @section('title', 'Master Jenis Procedure')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="fas fa-list-alt"></i> Jenis Procedure</h3>
            <a href="{{ route('admin.js_procedures.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered" id="poliklinikTable">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->nama }}</td>
                                <td>
                                    <span class="badge {{ $row->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $row->status ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.js_procedures.edit', $row->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.js_procedures.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($data->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
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
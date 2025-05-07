<x-admin>
    @section('title', 'Master Procedure')
    <div class="card-header">
        <div class="container-fluid mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title"><i class="fas fa-file-invoice-dollar"></i> Daftar Procedure</h3>
                <a href="{{ route('admin.procedures.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Procedure
                </a>
            </div>
            @if(session('success'))
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
                                <th>#</th>
                                <th>Nama</th>
                                <th>Jenis Jasa</th>
                                <th>Created Name</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($procedures as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis_jasa_nama }}</td>
                                    <td>{{ $item->createdname }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.procedures.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.procedures.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($procedures->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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
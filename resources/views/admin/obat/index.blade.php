<x-admin>
    @section('title', 'Daftar Obat')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Obat</h3>
            <div class="card-tools">
                <a href="{{ route('admin.obat.create') }}" class="btn btn-sm btn-info">Tambah Obat</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="obatTable">
                <thead>
                    <tr>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Bentuk Sediaan</th>
                        <th>Golongan</th>
                        <th>Kategori</th>
                        <th>Formula</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obats as $obat)
                        <tr>
                            <td>{{ $obat->kode_obat }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->bentuk_sediaan }}</td>
                            <td>{{ $obat->golongan }}</td>
                            <td>{{ $obat->kategori }}</td>
                            <td>{{ $obat->nama_formula }}</td> <!-- Assuming formula relation is set -->
                            <td>{{ number_format($obat->harga_beli, 0, ',', '.') }}</td>
                            <td>{{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                            <td>{{ $obat->stok }}</td>
                            <td>{{ $obat->satuan_obat }}</td>
                            <td>
                                <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
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
                $('#obatTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                });
            });
        </script>
    @endsection
</x-admin>

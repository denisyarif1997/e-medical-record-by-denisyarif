<x-admin>
    @section('title','Asuransi')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Asuransi Table</h3>
            <div class="card-tools">
                <a href="{{ route('admin.asuransi.create') }}" class="btn btn-sm btn-info">New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="asuransiTable">
                <thead>
                    <tr>
                        <th>Nama Asuransi</th>
                        <th>No Telepon</th>
                        <th>Deskripsi</th>
                        <th>Jenis Asuansi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asuransi as $cat)
                      <tr>
                        <td>{{ $cat->nama }}</td>
                        <td>{{ $cat->no_tlp }}</td>
                        <td>{{ $cat->deskripsi }}</td>
                        <td>{{ $cat->jenis_asuransi}}</td>
                        <td>
                          <a href="{{ route('admin.asuransi.edit', encrypt($cat->id)) }}" class="btn btn-sm btn-primary">Edit</a>
                          <form action="{{ route('admin.asuransi.destroy', encrypt($cat->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure want to delete?')">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
                $('#asuransiTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                });
            });
        </script>
    @endsection
</x-admin>

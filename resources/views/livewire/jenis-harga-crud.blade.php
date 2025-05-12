@section('title','Jenis Harga')

<div>
    {{-- <div class="mb-4">
        <button wire:click="resetFields" class="btn btn-primary">Tambah Jenis Harga</button>
    </div> --}}

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">Master Jenis Harga</div>
        <div class="card-body">
            @if($editMode)
                <form wire:submit.prevent="update">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input wire:model="nama" type="text" class="form-control" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea wire:model="keterangan" class="form-control" id="keterangan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            @else
                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input wire:model="nama" type="text" class="form-control" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea wire:model="keterangan" class="form-control" id="keterangan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            @endif
        </div>
    </div>

        <div class="card-body">
            <table class="table table-striped" id="productTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Inserted User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jenisHarga as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->inserted_user_name }}</td>

                        <td>
                            <button wire:click="edit({{ $item->id }})" class="btn btn-warning">Edit</button>
                            <button wire:click="delete({{ $item->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $jenisHarga->links() }}
    </div>
</div>
 @section('js')
        <script>
            $(function() {
                $('#productTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                });
            });
        </script>
    @endsection

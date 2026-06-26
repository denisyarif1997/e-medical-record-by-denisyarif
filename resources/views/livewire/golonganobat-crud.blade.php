@section('title','Golongan Obat')

<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif


<div class="card">
    <div class="card-header">Master Golongan Obat</div>
    <div class="card-body">
        @if($editMode)
            <form wire:submit.prevent="update">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Golongan</label>
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
                    <label for="nama" class="form-label">Nama Golongan</label>
                    <input wire:model="nama" type="text" class="form-control" id="nama" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea wire:model="keterangan" class="form-control" id="keterangan"></textarea>
                </div>
                <button type="submit" class="btn btn-primary ">Simpan</button>
            </form>
        @endif
    </div>
</div>

<div class="card-body">
    <table class="table table-striped" id="productTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Golongan</th>
                <th>Keterangan</th>
                <th>Inserted User</th>
                <th>Created At</th>
                <th>Updated User</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($golonganObat as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->inserted_user_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y H:i') }}</td>                   
                    <td>{{ $item->updated_user_name }}</td>
                    <td>
                        <button wire:click="edit({{ $item->id }})" class="btn btn-warning rounded-pill">Edit</button>
                        <button wire:click="delete({{ $item->id }})" class="btn btn-danger rounded-pill">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $golonganObat->links() }}
</div>
</div>



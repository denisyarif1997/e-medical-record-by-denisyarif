@section('title', 'Diagnosa')

<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Master Diagnosa</div>
        <div class="card-body">
          @if($editMode)
    <form wire:submit.prevent="update">
        <div class="mb-3">
            <label for="code" class="form-label">Kode Diagnosa</label>
            <input type="text" wire:model="code" id="code" class="form-control">
            @error('code') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Diagnosa</label>
            <input type="text" wire:model="name" id="name" class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea wire:model="description" id="description" class="form-control"></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@else
    <form wire:submit.prevent="store">
        <div class="mb-3">
            <label for="code" class="form-label">Kode Diagnosa</label>
            <input type="text" wire:model="code" id="code" class="form-control">
            @error('code') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Diagnosa</label>
            <input type="text" wire:model="name" id="name" class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea wire:model="description" id="description" class="form-control"></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endif

        </div>
    </div>

    <form wire:submit.prevent="searchDiagnosa" class="d-flex mb-3">
        <input type="text" class="form-control me-2" wire:model.defer="search"
            placeholder="Cari kode, nama, atau deskripsi...">
        <button type="submit" class="btn btn-primary me-2">Cari</button>
        <button type="button" class="btn btn-secondary" wire:click="resetSearch">Reset</button>
    </form>


    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diagnosas as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                                <button wire:click="edit({{ $item->id }})" class="btn btn-warning">Edit</button>
                                <button wire:click="delete({{ $item->id }})" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $diagnosas->links() }}
            </div>
        </div>
    </div>
</div>
@section('title', 'Diagnosa')

<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Form Column --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold">{{ $editMode ? 'Edit Diagnosa' : 'Tambah Diagnosa' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Diagnosa</label>
                            <input type="text" wire:model.defer="code" id="code"
                                class="form-control @error('code') is-invalid @enderror" placeholder="Cth: A01.1">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Diagnosa</label>
                            <input type="text" wire:model.defer="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Cth: Kolera">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea wire:model.defer="description" id="description" class="form-control" rows="4"
                                placeholder="Deskripsi singkat mengenai diagnosa"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if ($editMode)
                                <button type="button" wire:click="cancel" class="btn btn-secondary me-md-2">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Update
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table Column --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Data Diagnosa</h5>
                        <form wire:submit.prevent="searchDiagnosa" class="d-flex">
                            <input type="text" class="form-control me-2" wire:model.defer="search"
                                placeholder="Cari data diagnosa...">
                            <button type="submit" class="btn btn-primary me-1" title="Cari"><i class="bi bi-search"></i> Cari</button>
                            <button type="button" class="btn btn-secondary" wire:click="resetSearch" title="Reset"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($diagnosas as $item)
                                    <tr>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ Str::limit($item->description, 70) }}</td>
                                        <td class="text-center">
                                            <button wire:click="edit({{ $item->id }})"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button
                                                wire:click="delete({{ $item->id }})"
                                                onclick="return confirm('Anda yakin ingin menghapus data ini?') || event.stopImmediatePropagation()"
                                                class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($diagnosas->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $diagnosas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
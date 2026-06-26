@section('title', 'Master Bridging')
@section('css')
<style>
    .bridging-card {
        border-radius: 8px;
        overflow: hidden;
    }
    .bridging-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
        padding: 1rem 1.25rem;
    }
    .bridging-card .card-header h5 {
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .bridging-card .card-header h5 i {
        font-size: 1.2rem;
    }
    .bridging-table-card .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        border-bottom: none;
        padding: 1rem 1.25rem;
    }
    .bridging-table-card .card-header h5 {
        font-weight: 600;
        font-size: 1rem;
    }
    .bridging-table-card .card-header .btn {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
    }
    .bridging-table-card .card-header .btn:hover {
        background: rgba(255,255,255,0.25);
        color: white;
    }
    .bridging-table-card .card-header .form-control {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
    }
    .bridging-table-card .card-header .form-control::placeholder {
        color: rgba(255,255,255,0.7);
    }
    .bridging-table-card .card-header .form-control:focus {
        background: rgba(255,255,255,0.2);
        color: white;
        box-shadow: none;
    }
    .btn-aksi {
        padding: 0.25rem 0.6rem;
        font-size: 0.75rem;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-aksi:hover {
        transform: translateY(-1px);
    }
    .badge-status {
        font-size: 0.7rem;
        padding: 0.35rem 0.65rem;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .table-bridging th {
        background: #f8f9fc;
        color: #4a5568;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        border-bottom: 2px solid #e2e8f0;
        padding: 0.75rem 0.75rem;
    }
    .table-bridging td {
        padding: 0.7rem 0.75rem;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #2d3748;
    }
    .table-bridging tbody tr:hover {
        background: #f7faff;
    }
    .form-section-title {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #667eea;
        font-weight: 700;
        margin-bottom: 0.75rem;
        padding-bottom: 0.35rem;
        border-bottom: 2px solid #eef2ff;
    }
    .alert-floating {
        border-radius: 10px;
        border-left: 4px solid #28a745;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .pagination-bridging .page-link {
        border-radius: 6px !important;
        margin: 0 2px;
        border: 1px solid #e2e8f0;
        color: #4a5568;
        font-size: 0.8rem;
        padding: 0.4rem 0.7rem;
    }
    .pagination-bridging .page-item.active .page-link {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }
    .pagination-bridging .page-item.disabled .page-link {
        opacity: 0.5;
    }
</style>
@endsection

<div>
    {{-- Alert --}}
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show alert-floating d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2" style="font-size: 1.1rem;"></i>
            <span>{{ session('message') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- FORM COLUMN --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 bridging-card">
                <div class="card-header">
                    <h5>
                        <i class="bi {{ $editMode ? 'bi-pencil-square' : 'bi-plus-circle' }}"></i>
                        {{ $editMode ? 'Edit Bridging' : 'Tambah Bridging Baru' }}
                    </h5>
                </div>
                <div class="card-body bg-white p-4">
                    <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                        {{-- Informasi Bridging --}}
                        <div class="form-section-title"><i class="bi bi-info-circle me-1"></i> Informasi Bridging</div>

                        <div class="mb-3">
                            <label for="jenis_bridging" class="form-label fw-semibold" style="font-size: 0.8rem;">
                                Jenis Bridging <span class="text-danger">*</span>
                            </label>
                            <input type="text" wire:model.defer="jenis_bridging" id="jenis_bridging"
                                class="form-control form-control-sm @error('jenis_bridging') is-invalid @enderror"
                                placeholder="Cth: BPJS, INACBGS, dll">
                            @error('jenis_bridging')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipe_url" class="form-label fw-semibold" style="font-size: 0.8rem;">
                                Tipe URL <span class="text-danger">*</span>
                            </label>
                            <select wire:model.defer="tipe_url" id="tipe_url"
                                class="form-select form-select-sm @error('tipe_url') is-invalid @enderror">
                                <option value="">-- Pilih Tipe URL --</option>
                                <option value="prod">PROD</option>
                                <option value="dev">DEV</option>
                            </select>
                            @error('tipe_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="url" class="form-label fw-semibold" style="font-size: 0.8rem;">
                                URL <span class="text-danger">*</span>
                            </label>
                            <input type="text" wire:model.defer="url" id="url"
                                class="form-control form-control-sm @error('url') is-invalid @enderror"
                                placeholder="https://api.bpjs-kesehatan.go.id/...">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kredensial --}}
                        <div class="form-section-title mt-4"><i class="bi bi-key me-1"></i> Kredensial</div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label for="constid" class="form-label fw-semibold" style="font-size: 0.78rem;">Const ID</label>
                                <input type="text" wire:model.defer="constid" id="constid"
                                    class="form-control form-control-sm @error('constid') is-invalid @enderror"
                                    placeholder="Cons ID">
                                @error('constid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="secret_key" class="form-label fw-semibold" style="font-size: 0.78rem;">Secret Key</label>
                                <input type="text" wire:model.defer="secret_key" id="secret_key"
                                    class="form-control form-control-sm @error('secret_key') is-invalid @enderror"
                                    placeholder="Secret Key">
                                @error('secret_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label for="user_key" class="form-label fw-semibold" style="font-size: 0.78rem;">User Key</label>
                                <input type="text" wire:model.defer="user_key" id="user_key"
                                    class="form-control form-control-sm @error('user_key') is-invalid @enderror"
                                    placeholder="User Key">
                                @error('user_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="token" class="form-label fw-semibold" style="font-size: 0.78rem;">Token</label>
                                <input type="text" wire:model.defer="token" id="token"
                                    class="form-control form-control-sm @error('token') is-invalid @enderror"
                                    placeholder="Token">
                                @error('token')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-section-title mt-4"><i class="bi bi-toggle-on me-1"></i> Status</div>

                        <div class="mb-4 d-flex align-items-center">
                            <div class="form-check form-switch me-2">
                                <input type="checkbox" wire:model.defer="status" id="status"
                                    class="form-check-input @error('status') is-invalid @enderror"
                                    value="1" {{ $status ? 'checked' : '' }}>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="form-check-label fw-semibold" for="status" style="font-size: 0.85rem;">
                                Status <span class="text-muted fw-normal">— Centang untuk aktif</span>
                            </label>
                        </div>

                        {{-- Tombol Aksi --}}
                        <hr class="my-3">
                        <div class="d-flex justify-content-end gap-2">
                            @if ($editMode)
                                <button type="button" wire:click="cancel" class="btn btn-outline-secondary btn-sm px-4">
                                    <i class="bi bi-x-lg me-1"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-success btn-sm px-4">
                                    <i class="bi bi-check-lg me-1"></i> Update
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary btn-sm px-4">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- TABLE COLUMN --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 bridging-table-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="mb-0"><i class="bi bi-table me-2"></i> Data Bridging</h5>
                        <form wire:submit.prevent="searchData" class="d-flex gap-1">
                            <input type="text" class="form-control form-control-sm" wire:model.defer="search"
                                placeholder="Cari bridging..." style="min-width: 160px;">
                            <button type="submit" class="btn btn-sm px-3" title="Cari">
                                <i class="bi bi-search"></i>
                            </button>
                            <button type="button" class="btn btn-sm px-3" wire:click="resetSearch" title="Reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bridging mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Jenis Bridging</th>
                                    <th>Tipe</th>
                                    <th>URL</th>
                                    <th style="width: 80px;">Status</th>
                                    <th style="width: 140px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bridgings as $item)
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $loop->iteration + (($bridgings->currentPage() - 1) * $bridgings->perPage()) }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $item->jenis_bridging }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $tipeClass = $item->tipe_url === 'prod' ? 'bg-info' : 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $tipeClass }} badge-status text-uppercase">{{ $item->tipe_url }}</span>
                                        </td>
                                        <td>
                                            <span class="d-inline-block text-truncate" style="max-width: 220px;" title="{{ $item->url }}">
                                                <i class="bi bi-link-45deg text-muted me-1"></i>
                                                {{ Str::limit($item->url, 35) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($item->status)
                                                <span class="badge bg-success badge-status"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                            @else
                                                <span class="badge bg-danger badge-status"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <button wire:click="edit({{ $item->id }})"
                                                    class="btn btn-warning btn-aksi" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button
                                                    wire:click="delete({{ $item->id }})"
                                                    onclick="return confirm('Yakin ingin menghapus data {{ $item->jenis_bridging }}?') || event.stopImmediatePropagation()"
                                                    class="btn btn-danger btn-aksi" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                                Belum ada data bridging
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($bridgings->hasPages())
                        <div class="d-flex justify-content-center py-3 pagination-bridging">
                            {{ $bridgings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
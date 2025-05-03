<x-admin>
    @section('title','Create Asuransi')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Asuransi</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.asuransi.index') }}" class="btn btn-info btn-sm">Back</a>
                        </div>
                    </div>
                    <form class="needs-validation" novalidate action="{{ route('admin.asuransi.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Asuransi</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Enter Asuransi name" required value="{{ old('nama') }}">
                                <x-error>nama</x-error>
                            </div>

                            <div class="form-group">
                                <label for="no_tlp">No Telepon</label>
                                <input type="text" class="form-control" id="no_tlp" name="no_tlp"
                                    placeholder="Enter phone number" value="{{ old('no_tlp') }}">
                                <x-error>no_tlp</x-error>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                    placeholder="Enter description">{{ old('deskripsi') }}</textarea>
                                <x-error>deskripsi</x-error>
                            </div>

                            <div class="form-group">
                                <label for="jenis">Jenis Asuransi</label>
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="">-- Pilih Jenis Asuransi --</option>
                                    @foreach ($jenis_asuransi as $jenis)
                                        <option value="{{ $jenis->id }}" {{ old('jenis') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-error>jenis</x-error>
                            </div>
                            
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin>

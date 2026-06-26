<x-admin>
    @section('title', 'Edit Pasien')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Pasien</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pasien.update', encrypt($pasien->id)) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- SECTION 1: IDENTITAS UTAMA -->
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-id-card mr-1"></i> Identitas Utama</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 text-primary font-weight-bold">
                                    No. Rekam Medis: {{ $pasien->no_rekam_medis }}
                                    <input type="hidden" name="no_rekam_medis" value="{{ $pasien->no_rekam_medis }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nik">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $pasien->nik) }}" placeholder="16 Digit NIK">
                                </div>
                                <div class="mb-3">
                                    <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pasien->nama) }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                                <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="golongan_darah">Gol. Darah</label>
                                            <select name="golongan_darah" id="golongan_darah" class="form-control">
                                                <option value="">-</option>
                                                @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                                    <option value="{{ $goldar }}" {{ old('golongan_darah', $pasien->golongan_darah) == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: DATA SOSIAL -->
                        <div class="card card-outline card-info mt-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users mr-1"></i> Data Sosial & Demografi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="agama">Agama</label>
                                            <select name="agama" id="agama" class="form-control">
                                                <option value="">Pilih Agama</option>
                                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'] as $agama)
                                                    <option value="{{ $agama }}" {{ old('agama', $pasien->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status_pernikahan">Status Nikah</label>
                                            <select name="status_pernikahan" id="status_pernikahan" class="form-control">
                                                <option value="">Pilih Status</option>
                                                @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                                    <option value="{{ $status }}" {{ old('status_pernikahan', $pasien->status_pernikahan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pendidikan">Pendidikan</label>
                                            <input type="text" name="pendidikan" id="pendidikan" class="form-control" value="{{ old('pendidikan', $pasien->pendidikan) }}" placeholder="SD/SMP/SMA/S1/dst">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan', $pasien->pekerjaan) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="suku">Suku/Bangsa</label>
                                            <input type="text" name="suku" id="suku" class="form-control" value="{{ old('suku', $pasien->suku) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bahasa">Bahasa Sehari-hari</label>
                                            <input type="text" name="bahasa" id="bahasa" class="form-control" value="{{ old('bahasa', $pasien->bahasa) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="kewarganegaraan">Kewarganegaraan</label>
                                    <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $pasien->kewarganegaraan) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- SECTION 3: ALAMAT & KONTAK -->
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-map-marker-alt mr-1"></i> Alamat & Kontak</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="alamat">Alamat Jalan/Dusun</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="2">{{ old('alamat', $pasien->alamat) }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="rt">RT</label>
                                            <input type="text" name="rt" id="rt" class="form-control" value="{{ old('rt', $pasien->rt) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="rw">RW</label>
                                            <input type="text" name="rw" id="rw" class="form-control" value="{{ old('rw', $pasien->rw) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kelurahan">Kelurahan/Desa</label>
                                            <input type="text" name="kelurahan" id="kelurahan" class="form-control" value="{{ old('kelurahan', $pasien->kelurahan) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kecamatan">Kecamatan</label>
                                            <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ old('kecamatan', $pasien->kecamatan) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kota">Kota/Kabupaten</label>
                                            <input type="text" name="kota" id="kota" class="form-control" value="{{ old('kota', $pasien->kota) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', $pasien->provinsi) }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="no_hp">No. Handphone</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $pasien->no_hp) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="email">Alamat Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $pasien->email) }}">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: KELUARGA & PENANGGUNG -->
                        <div class="card card-outline card-warning mt-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-hand-holding-heart mr-1"></i> Keluarga & Penanggung</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_ayah">Nama Ayah</label>
                                            <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" value="{{ old('nama_ayah', $pasien->nama_ayah) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_ibu">Nama Ibu</label>
                                            <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu', $pasien->nama_ibu) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_pasangan">Nama Suami/Istri (Jika Ada)</label>
                                    <input type="text" name="nama_pasangan" id="nama_pasangan" class="form-control" value="{{ old('nama_pasangan', $pasien->nama_pasangan) }}">
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="penanggung">Nama Penanggung Jawab</label>
                                    <input type="text" name="penanggung" id="penanggung" class="form-control" value="{{ old('penanggung', $pasien->penanggung) }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="asuransi_id">Jenis Asuransi <span class="text-danger">*</span></label>
                                            <select name="asuransi_id" id="asuransi_id" class="form-control" required>
                                                <option value="">Pilih Asuransi</option>
                                                @foreach ($asuransis as $asuransi)
                                                    <option value="{{ $asuransi->id }}" {{ old('asuransi_id', $pasien->asuransi_id) == $asuransi->id ? 'selected' : '' }}>
                                                        {{ $asuransi->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="no_asuransi">No. Kartu Asuransi</label>
                                            <input type="text" name="no_asuransi" id="no_asuransi" class="form-control" value="{{ old('no_asuransi', $pasien->no_asuransi) }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h5>Kontak Darurat</h5>
                                <div class="mb-3">
                                    <label for="kontak_darurat_nama">Nama Kontak Darurat</label>
                                    <input type="text" name="kontak_darurat_nama" id="kontak_darurat_nama" class="form-control" value="{{ old('kontak_darurat_nama', $pasien->kontak_darurat_nama) }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kontak_darurat_hubungan">Hubungan</label>
                                            <input type="text" name="kontak_darurat_hubungan" id="kontak_darurat_hubungan" class="form-control" value="{{ old('kontak_darurat_hubungan', $pasien->kontak_darurat_hubungan) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kontak_darurat_hp">No. HP Darurat</label>
                                            <input type="text" name="kontak_darurat_hp" id="kontak_darurat_hp" class="form-control" value="{{ old('kontak_darurat_hp', $pasien->kontak_darurat_hp) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-lg btn-warning shadow"><i class="fas fa-save mr-1"></i> Perbarui Data Pasien</button>
                    <a href="{{ route('admin.pasien.index') }}" class="btn btn-lg btn-secondary shadow"><i class="fas fa-times mr-1"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-admin>

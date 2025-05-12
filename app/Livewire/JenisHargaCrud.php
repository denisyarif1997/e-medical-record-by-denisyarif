<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\JenisHarga;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class JenisHargaCrud extends Component
{
    use WithPagination;

    public $nama, $keterangan, $jenisHargaId;
    public $editMode = false;

    // Menampilkan data

public function render()
{
    $jenisHarga = DB::table('jenis_harga')
        ->leftJoin('users as u', 'u.id', '=', 'jenis_harga.inserted_user')
        ->select(
            'jenis_harga.id',
            'jenis_harga.nama',
            'jenis_harga.keterangan',
            'jenis_harga.inserted_user',
            'u.name as inserted_user_name',
            'jenis_harga.updated_user',
            'jenis_harga.deleted_user',
            'jenis_harga.created_at',
            'jenis_harga.updated_at'
        )
        ->whereNull('jenis_harga.deleted_at')
        ->orderBy('jenis_harga.nama')
        ->paginate(10);

    return view('livewire.jenis-harga-crud', compact('jenisHarga'));
}


    // Menyimpan data baru
    public function store()
    {
        // Validasi
        $this->validate([
            // 'asuransi_id' => 'required|exists:asuransi,id',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Menyimpan data
        JenisHarga::create([
            'nama' => $this->nama,
            'keterangan' => $this->keterangan,
            'inserted_user' => Auth::id(),  // Menyimpan ID user yang menambah data
        ]);

        session()->flash('message', 'Jenis harga berhasil disimpan!');
        $this->resetFields();
    }

    // Mengubah data
    public function edit($id)
    {
        $this->editMode = true;
        $jenisHarga = JenisHarga::find($id);
        $this->jenisHargaId = $jenisHarga->id;
        $this->nama = $jenisHarga->nama;
        $this->keterangan = $jenisHarga->keterangan;
    }

    // Memperbarui data
    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $jenisHarga = JenisHarga::find($this->jenisHargaId);
        $jenisHarga->update([
            'nama' => $this->nama,
            'keterangan' => $this->keterangan,
            'updated_user' => Auth::id(),  // Menyimpan ID user yang memperbarui data
        ]);

        session()->flash('message', 'Jenis harga berhasil diperbarui!');
        $this->resetFields();
    }

    // Menghapus data secara lembut (soft delete)
    public function delete($id)
    {
        $jenisHarga = JenisHarga::find($id);
        $jenisHarga->update([
            'deleted_user' => Auth::id(),  // Menyimpan ID user yang menghapus data
        ]);
        $jenisHarga->delete();

        session()->flash('message', 'Jenis harga berhasil dihapus!');
    }

    // Reset form input
    private function resetFields()
    {
        $this->nama = '';
        $this->keterangan = '';
        $this->editMode = false;
    }
}

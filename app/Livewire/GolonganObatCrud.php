<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\GolonganObat;

class GolonganObatCrud extends Component
{
    use WithPagination;

    public $nama, $keterangan, $golonganObatId;
    public $editMode = false;
    protected $paginationTheme = 'bootstrap';


    // Menampilkan data
    public function render()
    {
        $golonganObat = DB::table('golongan_obat as g')
            ->leftJoin('users as u', 'u.id', '=', 'g.inserted_user')
            ->select(
                'g.id',
                'g.nama',
                'g.keterangan',
                'g.inserted_user',
                'u.name as inserted_user_name',
                'u.name as updated_user_name',
                'g.deleted_user',
                'g.created_at',
                'g.updated_at'
            )
            ->whereNull('g.deleted_at')
            ->orderBy('g.nama')
            ->paginate(10);

        return view('livewire.golonganobat-crud', compact('golonganObat'));
    }

    // Menyimpan data baru
    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        GolonganObat::create([
            'nama' => $this->nama,
            'keterangan' => $this->keterangan,
            'inserted_user' => Auth::id(),
        ]);

        session()->flash('message', 'Golongan obat berhasil disimpan!');
        $this->resetFields();
    }

    // Mengubah data
    public function edit($id)
    {
        $this->editMode = true;
        $golonganObat = GolonganObat::find($id);
        $this->golonganObatId = $golonganObat->id;
        $this->nama = $golonganObat->nama;
        $this->keterangan = $golonganObat->keterangan;
    }

    // Memperbarui data
    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $golonganObat = GolonganObat::find($this->golonganObatId);
        $golonganObat->update([
            'nama' => $this->nama,
            'keterangan' => $this->keterangan,
            'updated_user' => Auth::id(),
        ]);

        session()->flash('message', 'Golongan obat berhasil diperbarui!');
        $this->resetFields();
    }

    // Menghapus data (soft delete)
    public function delete($id)
    {
        $golonganObat = GolonganObat::find($id);
        $golonganObat->update([
            'deleted_user' => Auth::id(),
        ]);
        $golonganObat->delete();

        session()->flash('message', 'Golongan obat berhasil dihapus!');
    }

    // Reset form input
    private function resetFields()
    {
        $this->nama = '';
        $this->keterangan = '';
        $this->editMode = false;
    }
}

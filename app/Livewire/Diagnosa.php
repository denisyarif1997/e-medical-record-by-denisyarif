<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Diagnosas;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Diagnosa extends Component
{
    use WithPagination;

    public $search = '';             // Input dari form pencarian
    public $searchKeyword = '';      // Yang digunakan di query pencarian

    public $code, $name, $description, $diagnosaId;
    public $editMode = false;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $diagnosas = DB::table('diagnosa')
            ->select('id', 'code', 'name', 'description', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->when($this->searchKeyword, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', '%' . $this->searchKeyword . '%')
                        ->orWhere('name', 'like', '%' . $this->searchKeyword . '%')
                        ->orWhere('description', 'like', '%' . $this->searchKeyword . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.diagnosa', compact('diagnosas'));
    }

    public function searchDiagnosa()
    {
        $this->searchKeyword = $this->search;
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->searchKeyword = '';
        $this->resetPage();
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Diagnosas::create([
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetFields();
        return redirect()->route('livewire.diagnosa')->with('message', 'Diagnosa berhasil disimpan!');
    }

    public function edit($id)
    {
        $this->editMode = true;
        $diagnosas = Diagnosas::findOrFail($id);
        $this->diagnosaId = $diagnosas->id;
        $this->code = $diagnosas->code;
        $this->name = $diagnosas->name;
        $this->description = $diagnosas->description;
    }

    public function update()
    {
        $this->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $diagnosas = Diagnosas::findOrFail($this->diagnosaId);
        $diagnosas->update([
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetFields();
        return redirect()->route('livewire.diagnosa')->with('message', 'Diagnosa berhasil diupdate!');
    }
     public function delete($id)
    {
        $diagnosas = Diagnosas::find($id);
        $diagnosas->update([
            // 'deleted_user' => Auth::id(),  // Menyimpan ID user yang menghapus data
        ]);
        $diagnosas->delete();

        return redirect()->route('livewire.diagnosa')->with('message', 'Diagnosa berhasil Dihapus!');
    }
    private function resetFields()
    {
        $this->code = '';
        $this->name = '';
        $this->description = '';
        $this->editMode = false;
        $this->diagnosaId = null;
    }
}

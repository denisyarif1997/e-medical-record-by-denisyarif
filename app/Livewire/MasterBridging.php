<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Master_Bridging;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class MasterBridging extends Component
{
    use WithPagination;

    public $search = '';
    public $searchKeyword = '';

    public $jenis_bridging, $tipe_url, $url, $constid, $secret_key, $user_key, $token, $status;
    public $bridgingId;
    public $editMode = false;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $bridgings = DB::table('master_bridgings')
            ->select('id', 'jenis_bridging', 'tipe_url', 'url', 'constid', 'secret_key', 'user_key', 'token', 'status', 'created_at', 'updated_at')
            // ->whereNull('deleted_at')
            ->when($this->searchKeyword, function ($query) {
                $query->where(function ($q) {
                    $q->where('jenis_bridging', 'ilike', '%' . $this->searchKeyword . '%')
                        ->orWhere('tipe_url', 'ilike', '%' . $this->searchKeyword . '%')
                        ->orWhere('url', 'ilike', '%' . $this->searchKeyword . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.master-bridging', compact('bridgings'));
    }

    public function searchData()
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
            'jenis_bridging' => 'required|string|max:255',
            'tipe_url'       => 'required|string|max:255',
            'url'            => 'required|string|max:255',
            'constid'        => 'nullable|string|max:255',
            'secret_key'     => 'nullable|string|max:255',
            'user_key'       => 'nullable|string|max:255',
            'token'          => 'nullable|string|max:255',
            'status'         => 'boolean',
        ]);

        Master_Bridging::create([
            'jenis_bridging' => $this->jenis_bridging,
            'tipe_url'       => $this->tipe_url,
            'url'            => $this->url,
            'constid'        => $this->constid,
            'secret_key'     => $this->secret_key,
            'user_key'       => $this->user_key,
            'token'          => $this->token,
            'status'         => $this->status ?? true,
        ]);

        $this->resetFields();
        return redirect()->route('forms.master_bridging')->with('message', 'Data bridging berhasil disimpan!');
    }

    public function edit($id)
    {
        $this->editMode = true;
        $bridging = Master_Bridging::findOrFail($id);
        $this->bridgingId    = $bridging->id;
        $this->jenis_bridging = $bridging->jenis_bridging;
        $this->tipe_url       = $bridging->tipe_url;
        $this->url            = $bridging->url;
        $this->constid        = $bridging->constid;
        $this->secret_key     = $bridging->secret_key;
        $this->user_key       = $bridging->user_key;
        $this->token          = $bridging->token;
        $this->status         = $bridging->status;
    }

    public function update()
    {
        $this->validate([
            'jenis_bridging' => 'required|string|max:255',
            'tipe_url'       => 'required|string|max:255',
            'url'            => 'required|string|max:255',
            'constid'        => 'nullable|string|max:255',
            'secret_key'     => 'nullable|string|max:255',
            'user_key'       => 'nullable|string|max:255',
            'token'          => 'nullable|string|max:255',
            'status'         => 'boolean',
        ]);

        $bridging = Master_Bridging::findOrFail($this->bridgingId);
        $bridging->update([
            'jenis_bridging' => $this->jenis_bridging,
            'tipe_url'       => $this->tipe_url,
            'url'            => $this->url,
            'constid'        => $this->constid,
            'secret_key'     => $this->secret_key,
            'user_key'       => $this->user_key,
            'token'          => $this->token,
            'status'         => $this->status ?? true,
        ]);

        $this->resetFields();
        return redirect()->route('forms.master_bridging')->with('message', 'Data bridging berhasil diupdate!');
    }

    public function delete($id)
    {
        $bridging = Master_Bridging::find($id);
        if ($bridging) {
            $bridging->delete();
        }

        return redirect()->route('forms.master_bridging')->with('message', 'Data bridging berhasil dihapus!');
    }

    public function cancel()
    {
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->jenis_bridging = '';
        $this->tipe_url       = '';
        $this->url            = '';
        $this->constid        = '';
        $this->secret_key     = '';
        $this->user_key       = '';
        $this->token          = '';
        $this->status         = true;
        $this->editMode       = false;
        $this->bridgingId     = null;
    }
}
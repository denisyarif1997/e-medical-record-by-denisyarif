<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;


class SpesialisController extends Controller
{
    public function index()
    {
        $spesialis = DB::table('spesialis')->whereNull('deleted_at')->get();
        return view('admin.spesialis.index', compact('spesialis'));
    }

    public function create()
    {
        return view('admin.spesialis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_spesialis' => [
                'required',
                'string',
                Rule::unique('spesialis')->whereNull('deleted_at')
            ],
            'code' => 'required|string|max:20',
        ]);
    
        DB::table('spesialis')->insert([
            'nama_spesialis' => $request->nama_spesialis,
            'code' => $request->code,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('admin.spesialis.index')->with('success', 'Data berhasil ditambahkan.');
    }
    

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $spesialis = DB::table('spesialis')->where('id', $id)->first();
        return view('admin.spesialis.edit', compact('spesialis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_spesialis' => 'required|string|max:100',
            'code' => 'required|string|max:50',
        ]);

        DB::table('spesialis')->where('id', $id)->update([
            'nama_spesialis' => $request->nama_spesialis,
            'code' => $request->code,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.spesialis.index')->with('success', 'Spesialis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        DB::table('spesialis')->where('id', $id)->update([
            'deleted_at' => now(),
        ]);

        return redirect()->route('admin.spesialis.index')->with('success', 'Spesialis berhasil dihapus.');
    }
}

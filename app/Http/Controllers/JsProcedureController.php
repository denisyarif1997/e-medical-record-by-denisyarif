<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JsProcedureController extends Controller
{
    public function index()
    {
        $data = DB::table('js_procedures')
            ->whereNull('deletedat')
            ->get();

        return view('admin.js_procedures.index', compact('data'));
    }

    public function create()
    {
        return view('admin.js_procedures.create');
    }

    public function store(Request $request)
    {
        DB::table('js_procedures')->insert([
            'nama' => $request->nama,
            'status' => $request->has('status'),
            'createdat' => Carbon::now(),
            'createdby' => auth()->id(),
            'createdname' => auth()->user()->name,
        ]);

        return redirect()->route('admin.js_procedures.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = DB::table('js_procedures')->where('id', $id)->first();
        return view('admin.js_procedures.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        DB::table('js_procedures')->where('id', $id)->update([
            'nama' => $request->nama,
            'status' => $request->has('status'),
            'updatedat' => Carbon::now(),
            'updatedby' => auth()->id(),
            'updatedname' => auth()->user()->name,
        ]);

        return redirect()->route('admin.js_procedures.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('js_procedures')->where('id', $id)->update([
            'deletedat' => Carbon::now(),
            'deletedby' => auth()->id(),
            'deletedname' => auth()->user()->name,
        ]);

        return redirect()->route('admin.js_procedures.index')->with('success', 'Data berhasil dihapus');
    }
}


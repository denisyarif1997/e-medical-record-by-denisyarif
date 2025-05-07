<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcedureController extends Controller
{
    public function index()
    {
        $procedures = DB::table('procedures')
            ->join('js_procedures', 'procedures.id_jenis_jasa', '=', 'js_procedures.id')
            ->select('procedures.*', 'js_procedures.nama as jenis_jasa_nama')
            ->whereNull('procedures.deletedat')
            ->get();


        return view('admin.procedures.index', compact('procedures'));
    }

    public function create()
{
    $js_procedures = DB::table('js_procedures')->whereNull('deletedat')->where('status', true)->get();
    return view('admin.procedures.create', compact('js_procedures'));
}


    public function store(Request $request)
{
    $now = Carbon::now();

    // Simpan ke tabel procedures
    $procedureId = DB::table('procedures')->insertGetId([
        'id_jenis_jasa' => $request->id_jenis_jasa,
        'nama' => $request->nama,
        'status' => $request->status === 'true' ? true : false,
        'createdat' => $now,
        'createdby' => auth()->id(),
        'createdname' => auth()->user()->name,
    ]);

    // Loop tarif dari form
    foreach ($request->tarif as $item) {
        DB::table('mp_procedure')->insert([
            'id_procedure' => $procedureId,
            'id_tarif' => $item['id_tarif'],
            'presentase' => $item['presentase'] ?? 0,
            'price' => $item['price'] ?? 0,
            'id_ms_price' => 1,
            'createdat' => $now,
            'createdby' => auth()->id(),
            'createdname' => auth()->user()->name,
        ]);
    }

    return redirect()->route('admin.procedures.index')->with('success', 'Procedure dan tarif berhasil disimpan.');
}


public function edit($id)
{
    $procedure = DB::table('procedures')->where('id', $id)->first();
    $js_procedures = DB::table('js_procedures')->whereNull('deletedat')->where('status', true)->get();


    $tarifs = DB::table('mp_procedure')
        ->where('id_procedure', $id)
        ->whereNull('deletedat')
        ->get()
        ->keyBy('id_tarif')
        ->map(function ($item) {
            return [
                'presentase' => $item->presentase,
                'price' => $item->price,
            ];
        })
        ->toArray();

    return view('admin.procedures.edit', compact('procedure', 'tarifs','js_procedures'));
}


    public function update(Request $request, $id)
    {
        DB::table('procedures')->where('id', $id)->update([
            'id_jenis_jasa' => $request->id_jenis_jasa,
            'nama' => $request->nama,
            'status' => $request->status,
            'updatedat' => Carbon::now(),
            'updatedby' => auth()->id(),
            'updatedname' => auth()->user()->name,
        ]);

        return redirect()->route('admin.procedures.index')->with('success', 'Procedure updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('procedures')->where('id', $id)->update([
            'deletedat' => Carbon::now(),
            'deletedby' => auth()->id(),
            'deletedname' => auth()->user()->name,
        ]);

        return redirect()->route('admin.procedures.index')->with('success', 'Procedure deleted successfully.');
    }
}

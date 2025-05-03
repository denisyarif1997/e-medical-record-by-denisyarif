<?php

namespace App\Http\Controllers;

use App\Models\AsesmenPerawat;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesmenPerawatController extends Controller
{
    public function index()
    {
        $data = AsesmenPerawat::getRegisAskep();
        // dd($data);

        return view('admin.asesmen_perawat.index', compact('data'));
    }

    public function create()
    {
        $pendaftarans = Pendaftaran::getAll();
        return view('admin.asesmen_perawat.create', compact('pendaftarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_regis' => 'required|exists:pendaftaran,id',
            'tujuan_kunjungan' => 'required|string',
            'keluhan_utama' => 'required|string',
            'ttv' => 'nullable|array',
        ]);

        AsesmenPerawat::create([
            'id_regis' => $request->id_regis,
            'asesmen' => [
                'tujuan_kunjungan' => $request->tujuan_kunjungan,
                'keluhan_utama' => $request->keluhan_utama,
                'ttv' => $request->ttv,
            ],
            'inserted_user' => Auth::user()->id ?? null,
        ]);

        return redirect()->route('admin.asesmen_perawat.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $data = AsesmenPerawat::findOrFail($id);
        $pendaftarans = Pendaftaran::getAll();
        return view('admin.asesmen_perawat.edit', compact('data', 'pendaftarans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_regis' => 'required|exists:pendaftaran,id',
            'tujuan_kunjungan' => 'required|string',
            'keluhan_utama' => 'required|string',
            'ttv' => 'nullable|array',
        ]);

        $asesmen = AsesmenPerawat::findOrFail($id);
        $asesmen->update([
            'id_regis' => $request->id_regis,
            'asesmen' => [
                'tujuan_kunjungan' => $request->tujuan_kunjungan,
                'keluhan_utama' => $request->keluhan_utama,
                'ttv' => $request->ttv,
            ],
            'updated_user' => Auth::user()->id ?? null,
        ]);

        return redirect()->route('admin.asesmen_perawat.index')->with('success', 'Data berhasil diubah');
    }

    
}

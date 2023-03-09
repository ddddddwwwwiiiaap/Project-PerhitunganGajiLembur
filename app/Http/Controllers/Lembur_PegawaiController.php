<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lembur_pegawai;
use App\Models\kategori_lembur;
use App\Models\Staff;


class lembur_pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['lembur_pegawai'] = lembur_pegawai::all();
        $data['staff'] = Staff::all();
        $data['count'] = lembur_pegawai::count();
        return view('lembur_pegawai.index', $data);
    }

    public function create()
    {
        $data['title'] = "Buat Lembur Pegawai";
        $data['kategori_lembur'] = kategori_lembur::all();
        $data['staff'] = Staff::all();
        return view('lembur_pegawai.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'mulai_lembur' => 'required',
            'selesai_lembur' => 'required',
            'jumlah_jam' => 'required',
        ]);

        $staff = Staff::where('id', $request->staff_id)->first();
        $kategori_lembur = kategori_lembur::where('position_id', $staff->position_id)->where('departement_id', $staff->departement_id)->first();
        $request->merge(['kategori_lembur_id' => $kategori_lembur->id]);
        

        lembur_pegawai::create($request->all());

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai created successfully'
        ];
        return redirect()->route('lembur_pegawai.index')->with($message);
    }

    public function edit(lembur_pegawai $lembur_pegawai)
    {
        $data['title'] = "Edit lembur_pegawai";
        $data['kategori_lembur'] = kategori_lembur::all();
        $data['staff'] = Staff::all();
        $data['lembur_pegawai'] = $lembur_pegawai;
        return view('lembur_pegawai.edit', $data);
    }

    public function update(Request $request, lembur_pegawai $lembur_pegawai)
    {
        $request->validate([
            'kategori_lembur_id' => 'required',
            'staff_id' => 'required',
            'mulai_lembur' => 'required',
            'selesai_lembur' => 'required',
            'jumlah_jam' => 'required',
        ]);

        $lembur_pegawai->update($request->all());

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai updated successfully'
        ];
        return redirect()->route('lembur_pegawai.index')->with($message);
    }

    public function destroy(lembur_pegawai $lembur_pegawai)
    {
        $lembur_pegawai->delete();

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai deleted successfully'
        ];
        return redirect()->route('lembur_pegawai.index')->with($message);
    }

}
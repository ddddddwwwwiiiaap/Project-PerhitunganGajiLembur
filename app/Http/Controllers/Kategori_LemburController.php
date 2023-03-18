<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori_lembur;
use App\Models\Master\Position;
use App\Models\Master\Departement;
use App\Models\Master\Staff;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class kategori_lemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['kategori_lembur'] = Kategori_Lembur::all();
        $data['count'] = Kategori_Lembur::count();
        return view('kategori_lembur.index', $data);
    }

    public function create(Request $request)
    {
        $data['title'] = "Buat Kategori Lembur";
        $data['position'] = Position::all();
        $data['departement'] = Departement::all();
        return view('kategori_lembur.create', $data);
    }

    public function store(Request $request)
    {
        $request->merge([
            'besaran_uang' => preg_replace('/\D/', '', $request->besaran_uang),
        ]);

        $request->validate([
            'kode_lembur' => 'required',
            'position_id' => 'required',
            'departement_id' => 'required',
            'besaran_uang' => 'required',
        ]);

        //message jika kode_lembur sudah ada
        $kode_lembur = Kategori_Lembur::where('kode_lembur', $request->kode_lembur)->first();
        if ($kode_lembur) {
            $message = [
                'alert-type' => 'error',
                'message' => 'Kode lembur sudah ada'
            ];
            return redirect()->route('kategori_lembur.index')->with($message);
        }

        Kategori_Lembur::create($request->all());

        $message = [
            'alert-type' => 'success',
            'message' => 'Data kategori_lembur created successfully'
        ];
        return redirect()->route('kategori_lembur.index')->with($message);
    }

    public function edit(Kategori_Lembur $kategori_lembur)
    {
        $data['title'] = "Edit kategori_lembur";
        $data['kategori_lembur'] = $kategori_lembur;
        $data['position'] = Position::all();
        $data['departement'] = Departement::all();
        return view('kategori_lembur.edit', $data);
    }

    public function update(Request $request, Kategori_Lembur $kategori_lembur)
    {
        $request->validate([
            'kode_lembur' => 'required',
            'position_id' => 'required',
            'departement_id' => 'required',
            'besaran_uang' => 'required',
        ]);

        //message jika kode_lembur sudah ada
        $kode_lembur = Kategori_Lembur::where('kode_lembur', $request->kode_lembur)->first();
        if ($kode_lembur) {
            $message = [
                'alert-type' => 'error',
                'message' => 'Kode lembur sudah ada'
            ];
            return redirect()->route('kategori_lembur.index')->with($message);
        }

        $kategori_lembur->update($request->all());

        $message = [
            'alert-type' => 'success',
            'message' => 'Data kategori_lembur updated successfully'
        ];
        return redirect()->route('kategori_lembur.index')->with($message);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $kategori_lembur = Kategori_Lembur::find($id);
            if ($kategori_lembur) {
                $kategori_lembur->delete();
            }
            $count = Kategori_Lembur::count();
            $message = [
                'alert-type' => 'success',
                'count' => $count,
                'message' => 'Data kategori_lembur deleted successfully'
            ];
            return response()->json($message);
        }
    }

    public function show(Kategori_Lembur $kategori_lembur)
    {
        $data['title'] = "Detail kategori_lembur";
        $data['kategori_lembur'] = $kategori_lembur;
        return view('kategori_lembur.show', $data);
    }
}

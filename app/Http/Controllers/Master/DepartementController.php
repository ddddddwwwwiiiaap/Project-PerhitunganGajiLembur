<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Departement;

class DepartementController extends Controller
{
    public function index()
    {
        $data['departement'] = Departement::all();
        $data['count'] = Departement::count();
        return view('master.departement.index', $data);
    }

    public function create()
    {
        return view('master.departement.create', ['title' => 'Tambah Job Grade']);
    }

    public function store(Request $request)
    {
        $request->merge([
            'salary_departemen' => preg_replace('/\D/', '', $request->salary_departemen),
        ]);

        $request->validate([
            'name' => 'required|max:100',
            'salary_departemen'=>'required',
        ]);

        Departement::create($request->all());

        $message = [
            'alert-type' => 'success',
            'message' => 'Data Job Grade created successfully'
        ];
        return redirect()->route('master.departement.index')->with($message);
    }

    public function edit(Departement $departement)
    {
        $data['title'] = 'Edit Job Grade';
        $data['departement'] = $departement;
        return view('master.departement.edit', $data);
    }

    public function update(Request $request, Departement $departement)
    {
        $request->merge([
            'salary_departemen' => preg_replace('/\D/', '', $request->salary_departemen),
        ]);

        $request->validate([
            'name' => 'required|max:100',
            'salary_departemen'=>'required',
        ]);

        $departement->update($request->all());

        $message = [
            'alert-type' => 'success',
            'message' => 'Data Job Grade updated successfully'
        ];
        return redirect()->route('master.departement.index')->with($message);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $departement = Departement::find($id);
            if ($departement) {
                $departement->delete();
            }
            $count = Departement::count();
            $message = [
                'alert-type' => 'success',
                'count' => $count,
                'message' => 'Data Job Grade deleted successfully.'
            ];
            return response()->json($message);
        }
    }
}

<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Position;

class PositionController extends Controller
{
    public function index()
    {
        $data['position'] = Position::all();
        $data['count'] = Position::count();
        return view('master.position.index', $data);
    }

    public function create()
    {
        $data['title'] = "Buat Position";
        return view('master.position.create', $data);
    }

    public function store(Request $request)
    {
        $request->merge([
            'salary_position' => preg_replace('/\D/', '', $request->salary_position),
        ]);

        $request->validate([
            'name'=>'required|max:100',
            'salary_position'=>'required',
            'status'=>'required',
        ]);

        Position::create($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data position created successfully'
        ];  
        return redirect()->route('master.position.index')->with($message);
    }

    public function edit(Position $position)
    {
        $data['title'] = "Edit Premium";
        $data['position'] = $position;
        return view('master.position.edit', $data);
    }

    public function update(Request $request, Position $position)
    {
        $request->merge([
            'salary_position' => preg_replace('/\D/', '', $request->salary_position),
        ]);
        
        $request->validate([
            'name'=>'required|max:100',
            'salary_position'=>'required',
            'status'=>'required',
        ]);

        $position->update($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data position updated successfully'
        ];  
        return redirect()->route('master.position.index')->with($message);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if($id)
        {   
            $position = Position::find($id);
            if($position)
            {
                $position->delete();
            }
            $count = Position::count();
            $message = [
                'alert-type'=>'success',
                'message'=> 'Data position deleted successfully'
            ];  
            return redirect()->route('master.position.index')->with($message);
        }
    }
    
    /*public function __invoke(Request $request)
    {

    }
    
    public function index()
    {
        return view('master.position.index', ['position'=>Position::all(), 'count'=>Position::count()]);
    }

    public function create()
    {
        return view('master.position.create', ['title'=>'Tambah Position']);
    }

    public function store(Request $request)
    {   
        $request->merge([
            'salary' => preg_replace('/\D/', '', $request->salary),
        ]);

        $request->validate([
            'name'=>'required',
            'salary'=>'required|max:50|min:3',
            'status'=>'required'
        ]);

        Position::create($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data position created successfully'
        ];  
        return redirect()->route('master.position.index')->with($message);
    }

    public function edit(Position $position)
    {
        $data['title'] = 'Edit Position';
        $data['position'] = $position;
        return view('master.position.edit', $data);       
    }

    public function update(Request $request, Position $position)
    {
        $request->merge([
            'salary' => preg_replace('/\D/', '', $request->salary),
        ]);

        $request->validate([
            'name'=>'required',
            'salary'=>'required|max:50|min:3',
            'status'=>'required'
        ]);

        $position->update($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data position updated successfully'
        ];  
        return redirect()->route('master.position.index')->with($message);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if($id)
        {   
            $position = Position::find($id);
            if($position)
            {
                $position->delete();
            }
            $count = Position::count();
            $message = [
                'alert-type' => 'success',
                'count' => $count,
                'message' => 'Data position deleted successfully.'
            ];
            return response()->json($message);
        }
    }*/
}
<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Staff;
use App\Models\Master\Position;
use App\Models\Master\Departement;
use App\Models\Roles;
use App\Models\Users;

class StaffController extends Controller
{

    public function index()
    {
        $data['staff'] = Staff::all();
        $data['count'] = Staff::count();
        return view('master.staff.index', $data);
    }

    public function create()
    {
        $data['title'] = "Tambah Staff";
        $data['position'] = Position::all();
        $data['roles'] = Roles::all();
        $data['departement'] = Departement::all();
        return view('master.staff.create', $data);
    }

    public function store(Request $request)
    {
        $request->merge([
            'salary_staff' => preg_replace('/\D/', '', $request->salary_staff),
        ]);

        // dd($request->all());
        $request->validate([
            'name'=>'required|max:100',
            'birth'=>'required|date',
            'startdate'=>'required|date',
            'phone'=>'required|max:13',
            'position_id'=>'required',
            'departement_id'=>'required',
            'address'=>'required',
            'nip'=>'required',
            'salary_staff'=>'required',
        ]);

        //message nip tidak boleh sama
        $nip = Staff::where('nip', $request->nip)->first();
        if ($nip) {
            $message = [
                'alert-type' => 'error',
                'message' => 'NIP sudah ada'
            ];
            return redirect()->route('master.staff.index')->with($message);
        }

        //tabel jumlah di dapet dengan salary_staff + salary_position + salary_departement
        $position = Position::where('id', $request->position_id)->first();
        $departement = Departement::where('id', $request->departement_id)->first();
        //perhitungan secara realtime jumlah di dapat di update
        $request->request->add(['jumlah' => $request->salary_staff + $position->salary_position + $departement->salary_departemen]);

        if ($request->has('makeUserAccount')) {
            $msg = [
                'username.min' => 'Username harus terdiri dari minimal 6 karakter.',
                'username.unique' => 'Username sudah digunakan.'
            ];
            $request->validate([
                'username' => 'required|string|min:6|max:255|unique:users',
                'role_id' => 'required|integer',
            ], $msg);

            $user = Users::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->username),
                'role_id' => $request->role_id
            ]);
            $request->request->add(['users_id' => $user->id]);
        }

        Staff::create($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data staff created successfully'
        ];  
        return redirect()->route('master.staff.index')->with($message);
    }

    public function edit(Staff $staff)
    {
        $data['title'] = "Edit Staff";
        $data['position'] = Position::all();
        $data['roles'] = Roles::all();
        $data['departement'] = Departement::all();
        $data['staff'] = $staff;
        return view('master.staff.edit', $data);
    }

    public function update(Request $request, Staff $staff)
    {
        $request->merge([
            'salary_staff' => preg_replace('/\D/', '', $request->salary_staff),
        ]);
        
        $request->validate([
            'name'=>'required|max:100',
            'birth'=>'required|date',
            'startdate'=>'required|date',
            'phone'=>'required|max:13',
            'position_id'=>'required',
            'departement_id'=>'required',
            'address'=>'required',
            'salary_staff'=>'required',
        ]);

        //update otomatis tabel jumlah di dapet dengan salary_staff + salary_position + salary_departement
        $position = Position::where('id', $request->position_id)->first();
        $departement = Departement::where('id', $request->departement_id)->first();
        $jumlah = $request->salary_staff + $position->salary_position + $departement->salary_departemen;
        $request->request->add(['jumlah' => $jumlah]);


        //message nip tidak boleh sama
        /*$nip = Staff::where('nip', $request->nip)->first();
        if ($nip) {
            $message = [
                'alert-type' => 'error',
                'message' => 'NIP sudah ada'
            ];
            return redirect()->route('master.staff.index')->with($message);
        }*/

        if ($request->has('makeUserAccount')) {
            $msg = [
                'username.min' => 'Username harus terdiri dari minimal 6 karakter.',
                'username.unique' => 'Username sudah digunakan.'
            ];
            $request->validate([
                'username' => 'required|string|min:6|max:255|unique:users',
                'role_id' => 'required|integer',
            ], $msg);

            $user = Users::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->username),
                'role_id' => $request->role_id
            ]);
            $request->request->add(['users_id' => $user->id]);
        }

        $staff->update($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data staff updated successfully'
        ];  
        return redirect()->route('master.staff.index')->with($message);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($id)
        {
            $staff = Staff::find($id);
            if($staff)
            {
                $staff->delete();
            }
            $count = Staff::count();
            $message = [
                'alert-type'=>'success',
                'count'=> $count,
                'message'=> 'Data staff deleted successfully'
            ];
            return response()->json($message);
        }
    }

    public function show(Staff $staff)
    {
        $data['title'] = "Detail Staff";
        $data['staff'] = $staff;
        return view('master.staff.show', $data);
    }   




    /*public function index()
    {
        $data['staff'] = Staff::all();
        $data['count'] = Staff::count();
        return view('master.staff.index', $data);
    }

    public function create()
    {
        $data['title'] = "Tambah Staff";
        $data['position'] = Position::all();
        $data['roles'] = Roles::all();
        $data['departement'] = Departement::all();
        return view('master.staff.create', $data);
    }

    public function store(Request $request)
    {   
        // dd($request->all());
        $request->validate([
            'name'=>'required|max:100',
            'birth'=>'required|date',
            'startdate'=>'required|date',
            'phone'=>'required|max:13',
            'position_id'=>'required',
            'departement_id'=>'required',
            'address'=>'required',
        ]);

        if ($request->has('makeUserAccount')) {
            $msg = [
                'username.min' => 'Username harus terdiri dari minimal 6 karakter.',
                'username.unique' => 'Username sudah digunakan.'
            ];
            $request->validate([
                'username' => 'required|string|min:6|max:255|unique:users',
                'role_id' => 'required|integer',
            ], $msg);

            $user = Users::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->username),
                'role_id' => $request->role_id
            ]);
            $request->request->add(['users_id' => $user->id]);
        }

        Staff::create($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data staff created successfully'
        ];  
        return redirect()->route('master.staff.index')->with($message);
    }

    public function edit(Staff $staff)
    {
        $data['title'] = 'Edit Staff';
        $data['staff'] = $staff;
        $data['position'] = Position::all();
        $data['departement'] = Departement::all();
        $data['roles'] = Roles::all();
        return view('master.staff.edit', $data);       
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name'=>'required|max:100',
            'birth'=>'required|date',
            'startdate'=>'required|date',
            'phone'=>'required|max:13',
            'position_id'=>'required',
            'departement_id'=>'required',
            'address'=>'required',
        ]);

        if ($request->has('makeUserAccount')) {
            $msg = [
                'username.min' => 'Username harus terdiri dari minimal 6 karakter.',
                'username.unique' => 'Username sudah digunakan.'
            ];
            $request->validate([
                'username' => 'required|string|min:6|max:255|unique:users',
                'role_id' => 'required|integer',
            ], $msg);

            $user = Users::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->username),
                'role_id' => $request->role_id
            ]);
            $request->request->add(['users_id' => $user->id]);
        }

        $staff->update($request->all());

        $message = [
            'alert-type'=>'success',
            'message'=> 'Data staff updated successfully'
        ];  
        return redirect()->route('master.staff.index')->with($message);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if($id)
        {   
            $staff = Staff::find($id);
            if($staff)
            {
                $staff->delete();
            }
            $count = Staff::count();
            $message = [
                'alert-type' => 'success',
                'count' => $count,
                'message' => 'Data staff deleted successfully.'
            ];
            return response()->json($message);
        }
    }*/
}

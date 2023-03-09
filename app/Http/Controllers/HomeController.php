<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Schedule;
use App\Models\Master\Staff;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $data['salary'] = Salary::count();   
        $data['staff'] = Staff::count();   
        return view('home', $data);
    }

    public function getStaffPosition()
    {
        $data = DB::table('tb_staff')
            ->select('tb_position.name', DB::raw('count(*) as total'))
            ->join('tb_position', 'tb_staff.position_id', '=', 'tb_position.id')
            ->groupBy('tb_position.name')
            ->get();
        return response()->json($data);
    }

    public function getStaffDepartement()
    {
        $data = DB::table('tb_staff', 'a')
                    ->groupBy( 'a.departement_id' )
                    ->orderBy( 'name_departement', 'asc' )
                    ->select(DB::raw('count(a.departement_id) as count, tb_departement.name as name_departement'))
                    // ->where('periode', $id)
                    ->join('tb_departement', 'tb_departement.id', '=', 'a.departement_id')
                    ->get();
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\MasterLembur;

use App\Http\Controllers\Controller;
use App\Models\MasterLembur\Lembur_Pegawai;
use App\Models\Master\Staff;
use App\Models\Master\Position;
use App\Models\Master\Departement;
use Illuminate\Http\Request;
use DB;

class Lembur_PegawaiController extends Controller
{

    public function index(Request $request)
    {
        $data['lembur_pegawai'] = Lembur_Pegawai::all();
        $data['staff'] = Staff::all();
        $data['count'] = Lembur_Pegawai::count();

        $f = $request->filter ?? null;
        //butkan filter berdasarkkan periode
        if ($f) {
            $data['lembur_pegawai'] = Lembur_Pegawai::where('periode', $f)->get();
        }

        $data['periode'] = Lembur_Pegawai::groupBy('periode')
            ->orderBy('periode')
            ->select(DB::raw('count(*) as count, periode'))
            ->get();
        $data['filter'] = $f;

        return view('masterlembur.lembur_pegawai.index', $data);
    }

    public function create()
    {
        $data['title'] = "Buat Lembur Pegawai";
        $data['staff'] = Staff::all();
        $data['position'] = Position::all();
        $data['departement'] = Departement::all();
        return view('masterlembur.lembur_pegawai.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'mulai_lembur' => 'required',
            'selesai_lembur' => 'required',
            'jumlah_jam' => 'required',
            'tanggal_lembur' => 'required|date',
            'periode' => 'required',
        ]);

        $data['request'] = $request->session()->get('salary');
        $data['position'] = Position::where('status', $request->status)->get();
        $data['staff'] = Staff::all();

        //memanggil data tb_position dan tb_departement
        $staff = Staff::where('id', $request->staff_id)->first();

        $lembur_pegawai = new Lembur_Pegawai;
        //$lembur_pegawai->jumlah_jam_lembur_periode = $jumlah_jam_lembur_periode;
        $lembur_pegawai->staff_id = $request->staff_id;
        $lembur_pegawai->periode = $request->periode;
        $lembur_pegawai->mulai_lembur = $request->mulai_lembur;
        $lembur_pegawai->selesai_lembur = $request->selesai_lembur;
        $lembur_pegawai->jumlah_jam = $request->jumlah_jam;
        $lembur_pegawai->tanggal_lembur = $request->tanggal_lembur;
        $lembur_pegawai->save();

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai created successfully'
        ];
        return redirect()->route('masterlembur.lembur_pegawai.index', $data)->with($message);
    }

    public function edit(Lembur_Pegawai $lembur_pegawai)
    {
        $data['title'] = "Edit Lembur Pegawai";
        $data['lembur_pegawai'] = $lembur_pegawai;
        $data['staff'] = Staff::all();
        $data['position'] = Position::all();
        $data['departement'] = Departement::all();
        return view('masterlembur.lembur_pegawai.edit', $data);
    }

    public function update(Request $request, Lembur_Pegawai $lembur_pegawai)
    {
        $request->validate([
            'staff_id' => 'required',
            'mulai_lembur' => 'required',
            'selesai_lembur' => 'required',
            'jumlah_jam' => 'required',
            'tanggal_lembur' => 'required|date',
            'periode' => 'required',
        ]);

        $lembur_pegawai->staff_id = $request->staff_id;
        $lembur_pegawai->periode = $request->periode;
        $lembur_pegawai->mulai_lembur = $request->mulai_lembur;
        $lembur_pegawai->selesai_lembur = $request->selesai_lembur;
        $lembur_pegawai->jumlah_jam = $request->jumlah_jam;
        $lembur_pegawai->tanggal_lembur = $request->tanggal_lembur;
        $lembur_pegawai->save();

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai updated successfully'
        ];
        return redirect()->route('masterlembur.lembur_pegawai.index')->with($message);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $lembur_pegawai = Lembur_Pegawai::find($id);
            if ($lembur_pegawai) {
                $lembur_pegawai->delete();
                $message = [
                    'alert-type' => 'success',
                    'message' => 'Data lembur_pegawai deleted successfully'
                ];
                return redirect()->route('lembur_pegawai.index')->with($message);
            } else {
                $message = [
                    'alert-type' => 'error',
                    'message' => 'Data lembur_pegawai not found'
                ];
                return redirect()->route('masterlembur.lembur_pegawai.index')->with($message);
            }
        }
    }

    public function excel($filter)
    {
        $f = $filter ?? 'all';
        if ($f == '' || $f == 'all') {
            $data['lembur_pegawai'] = Lembur_Pegawai::all();
        } else {
            $data['lembur_pegawai'] = Lembur_Pegawai::where('periode', $f)->get();
        }
        $data['periode'] = Lembur_Pegawai::groupBy('periode')
            ->orderBy('periode')
            ->select(DB::raw('count(*) as count, periode'))
            ->get();
        $data['filter'] = $f;
        return view('masterlembur.lembur_pegawai.excel', $data);
    }
}
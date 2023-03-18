<?php

namespace App\Http\Controllers;

use App\Models\Lembur_Pegawai;
use App\Models\Kategori_Lembur;
use App\Models\Master\Staff;
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

        return view('lembur_pegawai.index', $data);
    }

    public function create()
    {
        $data['title'] = "Buat Lembur Pegawai";
        $data['kategori_lembur'] = Kategori_Lembur::all();
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
            'tanggal_lembur' => 'required|date',
            'periode' => 'required',
        ]);

        //buatkan message kategori lembur tidak sesuai dengan position_id dan departement_id
        $staff = Staff::where('id', $request->staff_id)->first();
        $kategori_lembur = Kategori_Lembur::where('position_id', $staff->position_id)->where('departement_id', $staff->departement_id)->first();
        if (!$kategori_lembur) {
            $message = [
                'alert-type' => 'error',
                'message' => 'Kategori Lembur tidak sesuai dengan position_id dan departement_id'
            ];
            return redirect()->route('lembur_pegawai.index')->with($message);
        }

        $staff = Staff::where('id', $request->staff_id)->first();
        $kategori_lembur = Kategori_Lembur::where('position_id', $staff->position_id)->where('departement_id', $staff->departement_id)->first();

        $lembur_pegawai = new Lembur_Pegawai;
        //$lembur_pegawai->jumlah_jam_lembur_berdasarkan_periode = $jumlah_jam_lembur_berdasarkan_periode;
        $lembur_pegawai->kategori_lembur_id = $kategori_lembur->id;
        $lembur_pegawai->staff_id = $request->staff_id;
        $lembur_pegawai->periode = $request->periode;
        $lembur_pegawai->mulai_lembur = $request->mulai_lembur;
        $lembur_pegawai->selesai_lembur = $request->selesai_lembur;
        $lembur_pegawai->jumlah_jam = $request->jumlah_jam;
        $lembur_pegawai->total_uang_lembur = $kategori_lembur->besaran_uang * $request->jumlah_jam;
        $lembur_pegawai->tanggal_lembur = $request->tanggal_lembur;
        $lembur_pegawai->save();

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai created successfully'
        ];
        return redirect()->route('lembur_pegawai.index')->with($message);
    }

    public function edit($id)
    {
        $data['title'] = "Edit Lembur Pegawai";
        $data['lembur_pegawai'] = Lembur_Pegawai::find($id);
        $data['kategori_lembur'] = Kategori_Lembur::all();
        $data['staff'] = Staff::all();
        return view('lembur_pegawai.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required',
            'mulai_lembur' => 'required',
            'selesai_lembur' => 'required',
            'jumlah_jam' => 'required',
            'tanggal_lembur' => 'required|date',
            'periode' => 'required',
        ]);

        $staff = Staff::where('id', $request->staff_id)->first();
        $kategori_lembur = Kategori_Lembur::where('position_id', $staff->position_id)->where('departement_id', $staff->departement_id)->first();

        $lembur_pegawai = Lembur_Pegawai::find($id);
        $lembur_pegawai->kategori_lembur_id = $kategori_lembur->id;
        $lembur_pegawai->staff_id = $request->staff_id;
        $lembur_pegawai->periode = $request->periode;
        $lembur_pegawai->mulai_lembur = $request->mulai_lembur;
        $lembur_pegawai->selesai_lembur = $request->selesai_lembur;
        $lembur_pegawai->jumlah_jam = $request->jumlah_jam;
        $lembur_pegawai->total_uang_lembur = $kategori_lembur->besaran_uang * $request->jumlah_jam;
        $lembur_pegawai->tanggal_lembur = $request->tanggal_lembur;
        $lembur_pegawai->save();

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai updated successfully'
        ];
        return redirect()->route('lembur_pegawai.index')->with($message);
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
                return redirect()->route('lembur_pegawai.index')->with($message);
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
        return view('lembur_pegawai.excel', $data);
    }
}

    /*public function index()
    {
        $data['lembur_pegawai'] = Lembur_Pegawai::all();
        $data['staff'] = Staff::all();
        $data['count'] = Lembur_Pegawai::count();
        return view('lembur_pegawai.index', $data);
    }

    public function create()
    {
        $data['title'] = "Buat Lembur Pegawai";
        $data['kategori_lembur'] = Kategori_Lembur::all();
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
            'tanggal_lembur' => 'required|date',
        ]);

        $staff = Staff::where('id', $request->staff_id)->first();
        $kategori_lembur = Kategori_Lembur::where('position_id', $staff->position_id)->where('departement_id', $staff->departement_id)->first();

        $lembur_pegawai = new Lembur_Pegawai;
        $lembur_pegawai->kategori_lembur_id = $kategori_lembur->id;
        $lembur_pegawai->staff_id = $request->staff_id;
        $lembur_pegawai->mulai_lembur = $request->mulai_lembur;
        $lembur_pegawai->selesai_lembur = $request->selesai_lembur;
        $lembur_pegawai->jumlah_jam = $request->jumlah_jam;
        $lembur_pegawai->total_uang_lembur = $kategori_lembur->besaran_uang * $request->jumlah_jam;
        $lembur_pegawai->save();

        return redirect()->route('lembur_pegawai.index')->with('success', 'Data Lembur Pegawai Berhasil Ditambahkan');
    }

    public function edit(Lembur_Pegawai $lembur_pegawai)
    {
        $data['title'] = "Edit Lembur Pegawai";
        $data['kategori_lembur'] = Kategori_Lembur::all();
        $data['staff'] = Staff::all();
        $data['lembur_pegawai'] = $lembur_pegawai;
        return view('lembur_pegawai.edit', $data);
    }

    public function update(Request $request, Lembur_Pegawai $lembur_pegawai)
    {
        $request->validate([
            'staff_id' => 'required',
            'mulai_lembur' => 'required',
            'selesai_lembur' => 'required',
            'jumlah_jam' => 'required',
            'tanggal_lembur' => 'required|date',
        ]);

        $staff = Staff::where('id', $request->staff_id)->first();
        $kategori_lembur = Kategori_Lembur::where('position_id', $staff->position_id)->where('departement_id', $staff->departement_id)->first();

        $lembur_pegawai->kategori_lembur_id = $kategori_lembur->id;
        $lembur_pegawai->staff_id = $request->staff_id;
        $lembur_pegawai->mulai_lembur = $request->mulai_lembur;
        $lembur_pegawai->selesai_lembur = $request->selesai_lembur;
        $lembur_pegawai->jumlah_jam = $request->jumlah_jam;
        $lembur_pegawai->total_uang_lembur = $kategori_lembur->besaran_uang * $request->jumlah_jam;
        $lembur_pegawai->save();

        return redirect()->route('lembur_pegawai.index')->with('success', 'Data Lembur Pegawai Berhasil Diubah');
    }

    public function destroy(Lembur_Pegawai $lembur_pegawai)
    {
        $lembur_pegawai->delete();
        return redirect()->route('lembur_pegawai.index')->with('success', 'Data Lembur Pegawai Berhasil Dihapus');
    }
}*/


    /*public function index()
    {
        $data['lembur_pegawai'] = lembur_pegawai::all();
        $data['staff'] = Staff::all();
        $data['count'] = Lembur_Pegawai::count();
        return view('lembur_pegawai.index', $data);
    }

    public function create()
    {
        $data['title'] = "Buat Lembur Pegawai";
        $data['kategori_lembur'] = Kategori_Lembur::all();
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
        $kategori_lembur = Kategori_Lembur::where('position_id', $staff->position_id)->where('departement_id', $staff->departement_id)->first();
        $request->merge(['kategori_lembur_id' => $kategori_lembur->id]);

        Lembur_Pegawai::create($request->all());

        $message = [
            'alert-type' => 'success',
            'message' => 'Data lembur_pegawai created successfully'
        ];
        return redirect()->route('lembur_pegawai.index')->with($message);
    }

    public function edit(Lembur_Pegawai $lembur_pegawai)
    {
        $data['title'] = "Edit lembur_pegawai";
        $data['lembur_pegawai'] = $lembur_pegawai;
        $data['kategori_lembur'] = Kategori_Lembur::all();
        $data['staff'] = Staff::all();
        return view('lembur_pegawai.edit', $data);
    }

    public function update(Request $request, Lembur_Pegawai $lembur_pegawai)
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

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $lembur_pegawai = Lembur_Pegawai::find($id);
            $lembur_pegawai->delete();
            $message = [
                'alert-type' => 'success',
                'message' => 'Data lembur_pegawai deleted successfully'
            ];
            return redirect()->route('lembur_pegawai.index')->with($message);
        }
    }

}*/
<?php

namespace App\Http\Controllers;

use App\CG;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CGMaster extends Controller
{
    public function index()
    {
        $data = CG::with('department')->orderBy('nama_cg','DESC')->get();
        return view('pages.admin.cg.index', compact('data'));
    }


    public function store()
    {
        $validator = Validator::make(request()->all(),[
            'nama_cg' => ['required'],
            'department' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id');
        if($id)
        {
            // update data
            CG::where('id_cg',$id)->update([
                'nama_cg' => request('nama_cg'),
                'id_department' => request('department')
            ]);
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Cg berhasil diupdate.',
                'data' => NULL
            ];
        }else{
            // insert data
            $cg1 = CG::orderBy('id_cg','DESC');
            if($cg1->count() > 0)
            {
                $terakhir = Str::after($cg1->first()->id_cg,'CG_');
                $kode_baru = 'CG_' . str_pad($terakhir + 1,4,"0",STR_PAD_LEFT);
            }else{
                $kode_baru = 'CG_' . str_pad(1,4,"0",STR_PAD_LEFT);
            }
            $cg = CG::create([
                'id_cg' => $kode_baru,
                'nama_cg' => request('nama_cg'),
                'id_department' => request('department')
            ]);
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Cg berhasil ditambahkan.',
                'data' => $cg
            ];
        }
        return response()->json($data);

    }

    public function destroy()
    {
        $id = request('id');
        $item = CG::where('id_cg',$id)->delete();
        $data = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Cg berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($data);
    }
}

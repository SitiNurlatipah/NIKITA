<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScaleCorporateModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;


class ScaleCorporateController extends Controller
{
    public function index()
    {
        
        return view('pages.admin.scale.index');
    }
    public function scaleJson(){
        $data = ScaleCorporateModel::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button data-id="' . $row->id_scale_corporate . '" data-golongan="' . $row->golongan . '" data-kompetensi="' . $row->curriculum_corporate . '" 
                data-scale-satu="' . $row->scale_1 . '" data-scale-dua="' . $row->scale_2 . '" data-scale-tiga="' . $row->scale_3 . '" data-scale-empat="' . $row->scale_4 . '" 
                data-scale-lima="' . $row->scale_5 . '"  class="button-add btn btn-inverse-success btn-icon mr-1 btnEdit"><i class="icon-file menu-icon"></i></button>';
                $btn = $btn . '<button type="button" data-id="' . $row->id_scale_corporate . '" data-kompetensi="' . $row->curriculum_corporate . '" class="btn btn-inverse-info btn-icon btnHapus"><i class="icon-trash"></i></button>';
                    return $btn;
                })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store()
    {
        $id = request('id_scale');
        // $validator = Validator::make(request()->all(),[
        //     'nama_level' => ['required',Rule::unique('level')->ignore($id,'id_level')]
        // ]);

        // if($validator->fails())
        // {
        //     $response = [
        //         'code' => 400,
        //         'status' => 'error',
        //         'message' => $validator->errors()->first(),
        //         'data' => NULL
        //     ];
        //     return response()->json($response);
        // }
        if($id)
        {
            $data = ScaleCorporateModel::where('id_scale_corporate',$id)->update([
                'curriculum_corporate' => request('nama_kompetensi'),
                'golongan' => request('golongan'),
                'scale_1' => request('scale_1'),
                'scale_2' => request('scale_2'),
                'scale_3' => request('scale_3'),
                'scale_4' => request('scale_4'),
                'scale_5' => request('scale_5'),
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Corporate Scale  berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $data = ScaleCorporateModel::create([
                'curriculum_corporate' => request('nama_kompetensi'),
                'golongan' => request('golongan'),
                'scale_1' => request('scale_1'),
                'scale_2' => request('scale_2'),
                'scale_3' => request('scale_3'),
                'scale_4' => request('scale_4'),
                'scale_5' => request('scale_5'),
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Corporate Scale berhasil ditambahkan.',
                 'data' => $data
             ];
        }

        return response()->json($response);
    }

    public function destroy()
    {
        $validator = Validator::make(request()->all(),[
            'id_scale' => ['required']
        ]);

        if($validator->fails())
        {
            $response = [
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'data' => NULL
            ];
            return response()->json($response);
        }

        $id = request('id_scale');
        ScaleCorporateModel::where('id_scale_corporate',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Level berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);
    }
}


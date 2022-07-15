<?php

namespace App\Http\Controllers;

use App\SubDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SubDepartmentController extends Controller
{
    public function index()
    {
        $items = SubDepartment::with('department')->orderBy('nama_subdepartment','ASC')->get();
        return view('pages.admin.sub-department.index',compact('items'));
    }

    public function store()
    {
        $id = request('id');
        $validator = Validator::make(request()->all(),[
            'nama_subdepartment' => ['required'],
            'department' => ['required']
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

        if($id)
        {
            $data = SubDepartment::where('id_subdepartment',$id)->update([
                'nama_subdepartment' => request('nama_subdepartment'),
                'id_department' => request('department')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Sub Department  berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $dep1 = SubDepartment::orderBy('id_subdepartment','DESC');
            if($dep1->count() > 0)
            {
                $terakhir = Str::after($dep1->first()->id_subdepartment,'SDP-');
                $kode_baru = 'SDP-' . str_pad($terakhir + 1,4,"0",STR_PAD_LEFT);
            }else{
                $kode_baru = 'SDP-' . str_pad(1,4,"0",STR_PAD_LEFT);
            }
            $data = SubDepartment::create([
                'id_subdepartment' => $kode_baru,
                'nama_subdepartment' => request('nama_subdepartment'),
                'id_department' => request('department')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Sub Department berhasil ditambahkan.',
                 'data' => $data
             ];
        }

        return response()->json($response);
    }

    public function destroy()
    {
        $validator = Validator::make(request()->all(),[
            'id' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id');
        SubDepartment::where('id_subdepartment',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Sub Department berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

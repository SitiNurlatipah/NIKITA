<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $items = Department::with('divisi')->orderBy('nama_department','ASC')->get();
        return view('pages.admin.department.index',compact('items'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(),[
            'divisi' => ['required'],
            'nama_department' => ['required']
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

        $id = request('id');
        if($id)
        {
            $data = Department::where('id_department',$id)->update([
                'id_divisi' => request('divisi'),
                'nama_department' => request('nama_department')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Department berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $dep1 = Department::orderBy('id_department','DESC');
            if($dep1->count() > 0)
            {
                $terakhir = Str::after($dep1->first()->id_department,'DP-');
                $kode_baru = 'DP-' . str_pad($terakhir + 1,4,"0",STR_PAD_LEFT);
            }else{
                $kode_baru = 'DP-' . str_pad(1,4,"0",STR_PAD_LEFT);
            }
            $data = Department::create([
                'id_department' => $kode_baru,
                'id_divisi' => request('divisi'),
                'nama_department' => request('nama_department')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Department berhasil ditambahkan.',
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
        Department::where('id_department',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Department berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

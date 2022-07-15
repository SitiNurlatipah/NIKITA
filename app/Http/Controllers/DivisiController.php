<?php

namespace App\Http\Controllers;

use App\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class DivisiController extends Controller
{
    public function index()
    {
        $items = Divisi::orderBy('nama_divisi','ASC')->get();
        return view('pages.admin.divisi.index',compact('items'));
    }

    public function store()
    {
        $id = request('id');
        $validator = Validator::make(request()->all(),[
            'nama_divisi' => ['required',Rule::unique('divisi')->ignore($id,'id_divisi')]
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
            $data = Divisi::where('id_divisi',$id)->update([
                'nama_divisi' => request('nama_divisi')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Divisi  berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $dep1 = Divisi::orderBy('id_divisi','DESC');
            if($dep1->count() > 0)
            {
                $terakhir = Str::after($dep1->first()->id_divisi,'DV_');
                $kode_baru = 'DV_' . str_pad($terakhir + 1,4,"0",STR_PAD_LEFT);
            }else{
                $kode_baru = 'DV_' . str_pad(1,4,"0",STR_PAD_LEFT);
            }
            $data = Divisi::create([
                'id_divisi' => $kode_baru,
                'nama_divisi' => request('nama_divisi')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Divisi berhasil ditambahkan.',
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
        Divisi::where('id_divisi',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Divisi berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

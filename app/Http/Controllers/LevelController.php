<?php

namespace App\Http\Controllers;

use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class LevelController extends Controller
{
    public function index()
    {
        $items = Level::orderBy('nama_level','ASC')->get();
        return view('pages.admin.level.index',compact('items'));
    }

    public function store()
    {
        $id = request('id');
        $validator = Validator::make(request()->all(),[
            'nama_level' => ['required',Rule::unique('level')->ignore($id,'id_level')]
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
            $data = Level::where('id_level',$id)->update([
                'nama_level' => request('nama_level')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Level  berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $dep1 = Level::orderBy('id_level','DESC');
            if($dep1->count() > 0)
            {
                $terakhir = Str::after($dep1->first()->id_level,'LV-');
                $kode_baru = 'LV-' . str_pad($terakhir + 1,4,"0",STR_PAD_LEFT);
            }else{
                $kode_baru = 'LV-' . str_pad(1,4,"0",STR_PAD_LEFT);
            }
            $data = Level::create([
                'id_level' => $kode_baru,
                'nama_level' => request('nama_level')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Level berhasil ditambahkan.',
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
        Level::where('id_level',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Level berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

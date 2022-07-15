<?php

namespace App\Http\Controllers;

use App\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function get()
    {
        $items = Jabatan::orderBy('nama_job_title')->get();
        return response()->json($items);
    }

    public function index()
    {
        $items = Jabatan::with('department')->orderBy('nama_job_title','ASC')->get();
        return view('pages.admin.jabatan.index',compact('items'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(),[
            'nama_job_title' => ['required'],
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

        $id = request('id');
        if($id)
        {
            $data = Jabatan::where('id_job_title',$id)->update([
                'id_department' => request('department'),
                'nama_job_title' => request('nama_job_title')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Job Title berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $dep1 = Jabatan::orderBy('id_job_title','DESC');
            if($dep1->count() > 0)
            {
                $terakhir = Str::after($dep1->first()->id_job_title,'JT-');
                $kode_baru = 'JT-' . str_pad($terakhir + 1,4,"0",STR_PAD_LEFT);
            }else{
                $kode_baru = 'JT-' . str_pad(1,4,"0",STR_PAD_LEFT);
            }
            $data = Jabatan::create([
                'id_job_title' => $kode_baru,
                'nama_job_title' => request('nama_job_title'),
                'id_department' => request('department')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Job Title berhasil ditambahkan.',
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
        Jabatan::where('id_job_title',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Job Title berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

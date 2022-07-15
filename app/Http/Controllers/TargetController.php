<?php

namespace App\Http\Controllers;

use App\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TargetController extends Controller
{
    public function index()
    {
        $items = Target::with('jobtitle')->orderBy('name','ASC')->get();
        return view('pages.admin.target.index',compact('items'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(),[
            'job_title' => ['required'],
            'nama_target' => ['required'],
            'value' => ['required','numeric']
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
            // cek apakah sudah ada di database
            $tc = Target::where('id_job_title',request('job_title'))->where('name',request('nama_target'))->where('value',request('value'))->count();
            if($tc > 0)
            {
                $response = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Target job title sudah ada.',
                    'data' => NULL
                ];
                return response()->json($response);
            }
            $data = Target::where('id',$id)->update([
                'id_job_title' => request('job_title'),
                'name' => request('nama_target'),
                'value' => request('value')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Target berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            // cek apakah sudah ada di database
            $tc = Target::where('id_job_title',request('job_title'))->where('name',request('nama_target'))->count();
            if($tc > 0)
            {
                $response = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Target job title sudah ada.',
                    'data' => NULL
                ];
                return response()->json($response);
            }
            $data = Target::create([
                'id_job_title' => request('job_title'),
                'name' => request('nama_target'),
                'value' => request('value')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Target berhasil ditambahkan.',
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
        Target::where('id',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Target berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

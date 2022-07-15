<?php

namespace App\Http\Controllers;

use App\GradeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Grade extends Controller
{
    public function index()
    {
        $data = GradeModel::orderBy('grade','ASC')->get();
        return view('pages.admin.grade.index', compact('data'));
    }

    public function getFormEditGrade(Request $request)
    {
        $grade = GradeModel::where("id_grade", $request->id)->first();
        return view("pages.admin.grade.form", compact("grade"));
    }

    public function store()
    {
        $id = request('id');
        $validator = Validator::make(request()->all(),[
            'grade' => ['required'],
            'tingkatan' => ['required'],
            'level' => ['required'],
            'persen' => ['required'],
            'bg_color' => ['required']
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
            $data = GradeModel::where('id_grade',$id)->update([
                'grade' => request('grade'),
                'tingkatan' => request('tingkatan'),
                'level' => request('level'),
                'persen' => request('persen'),
                'bg_color' => request('bg_color')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Grade  berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $data = GradeModel::create([
                'grade' => request('grade'),
                'tingkatan' => request('tingkatan'),
                'level' => request('level'),
                'persen' => request('persen'),
                'bg_color' => request('bg_color')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Grade berhasil ditambahkan.',
                 'data' => $data
             ];
        }

        return response()->json($response);
    }

    public function show($id)
    {
        $post = GradeModel::find($id);
        return response()->json($post);
    }

    public function destroy()
    {
        $id = request('id');
        if(!$id)
        {
            $response = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Grade gagal dihapus.',
                'data' => NULL
            ];
            return response()->json($response);
        }
        $grade = GradeModel::where('id_grade', $id)->delete();
        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Grade berhasil dihapus.',
            'data' => NULL
        ];
        return response()->json($response);
    }

}

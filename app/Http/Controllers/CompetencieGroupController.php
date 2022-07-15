<?php

namespace App\Http\Controllers;

use App\CompetencieGroup;
use App\SkillCategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompetencieGroupController extends Controller
{
    public function index()
    {
        $items = CompetencieGroup::with('skill_category')->orderBy('name','ASC')->get();
        return view('pages.admin.competencie-group.index',compact('items'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(),[
            'skill_category' => ['required'],
            'name' => ['required']
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
            $data = CompetencieGroup::where('id',$id)->update([
                'id_skill_category' => request('skill_category'),
                'name' => request('name')
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Competencie Group berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $data = CompetencieGroup::create([
                'id_skill_category' => request('skill_category'),
                'name' => request('name')
            ]);
             $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Competencie Group berhasil ditambahkan.',
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
        CompetencieGroup::where('id',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Competencie Group berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }

    public function getBySkillCategory()
    {
        $id = request('id');
        $items = CompetencieGroup::where('id_skill_category',$id)->get();
        return response()->json($items);
    }
}


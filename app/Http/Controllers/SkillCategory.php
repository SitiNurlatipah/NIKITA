<?php

namespace App\Http\Controllers;

use App\SkillCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillCategory extends Controller
{
    public function index()
    {
        $data = SkillCategoryModel::all();
        return view('pages.admin.skill-category.index', compact('data'));
    }

    public function FormEditSkillCategory(Request $request)
    {
        $skill_category = SkillCategoryModel::where("id_skill_category", $request->id)->first();
        $skills = SkillCategoryModel::all();
        return view("pages.admin.skill-category.form", compact("skill_category", "skills", "jabatans"));
    }

    public function get()
    {
        $items = SkillCategoryModel::orderBy('skill_category')->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'skill_category' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }
        $id  = request('id');

       if($id)
       {
           $data = SkillCategoryModel::where('id_skill_category',$id)->update([
               'skill_category' => request('skill_category')
           ]);
           $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Skill Category berhasil diupdate.',
                'data' => $data
            ];

       }else{
           $data = SkillCategoryModel::create([
               'skill_category' => request('skill_category')
           ]);
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Skill Category berhasil ditambahkan.',
                'data' => $data
            ];
       }



        return response()->json($response);
    }

    public function delete()
    {
        $validator = Validator::make(request()->all(),[
            'id' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id');
        $data = SkillCategoryModel::where('id_skill_category', $id)->delete();
        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Skill Category berhasil dihapus.',
            'data' => $data
        ];
        return response()->json($response);
    }
}

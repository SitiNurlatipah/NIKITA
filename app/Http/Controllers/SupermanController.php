<?php

namespace App\Http\Controllers;

use App\CurriculumSuperman;
use App\CurriculumSupermanToUser;
use App\Target;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupermanController extends Controller
{
    public function index()
    {
        $items = Target::with('jobtitle')->orderBy('name','ASC')->get();
        return view('pages.admin.superman.index-curriculum',compact('items'));
    }

    public function getSuperman()
    {
        $superman = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('is_superman', 1)
            ->get(['users.id', 'users.nama_pengguna', 'users.id_department', 'dp.nama_department', 'jt.id_job_title', 'jt.nama_job_title']);

        return response()->json($superman);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'id_skill_category' => ['required'],
            'curriculum_superman' => ['required'],
            'curriculum_group' => ['required'],
            'curriculum_desc' => ['required'],
            'target' => ['required'],
        ]);

        if($validator->fails())
        {
            $response = [
                'code' => 422,
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'data' => $validator->errors()
            ];
            return response()->json($response);
        }else {
            // $data = $this->validate_input_v2($request);
            DB::beginTransaction();
            try {
                $lastId = CurriculumSuperman::orderBy("created_at","desc")->first();
                if(isset($lastId)){
                    $number = explode("/",$lastId->no_training_module);
                    $lastNumber = (int)$number[0];
                }else{
                    $lastNumber = 0;
                }
                $number = str_pad($lastNumber+1,3,'0',STR_PAD_LEFT); 
                if($request->id_skill_category == 1){
                    $noCurriculum = $number."/SUPERMAN/FUNC";
                }else if($request->id_skill_category == 2){
                    $noCurriculum = $number."/SUPERMAN/GEN";
                }
                if(isset($request->id_job_title) && count($request->id_job_title) > 0){
                    $curriculum = new CurriculumSuperman();
                    $curriculum->no_curriculum_ = $noCurriculum;
                    $curriculum->id_skill_category = $request->id_skill_category;
                    $curriculum->curriculum_superman = $request->curriculum_superman;
                    $curriculum->curriculum_group = $request->curriculum_group;
                    $curriculum->curriculum_desc = $request->curriculum_desc;
                    $curriculum->target = $request->target;
                    $curriculum->save();
                    $insert = [];
                    for($i = 0;$i < count($request->id_job_title);$i++){
                        $insert[$i] = [
                            'id_curriculum_superman' => $curriculum->id_curriculum_superman,
                            'id_user' => $request->id_user[$i]
                        ];
                    }
                    if(count($insert) > 0){
                        CurriculumSupermanToUser::insert($insert);
                    }

                }
                DB::commit();
                return response()->json(['code' => 200, 'message' => 'Post Created successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['code' => 422, 'message' => $e->getMessage()], 422);
            }
        }
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

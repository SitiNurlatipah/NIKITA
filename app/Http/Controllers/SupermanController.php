<?php

namespace App\Http\Controllers;

use App\CurriculumSuperman;
use App\CurriculumSupermanToUser;
use App\SkillCategoryModel;
use App\Superman;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SupermanController extends Controller
{
    public function index()
    {
        $users_data = DB::raw("(SELECT GROUP_CONCAT(nama_pengguna) FROM curriculum_superman_to_user AS cstu JOIN users ON users.id = cstu.id_user WHERE cstu.id_curriculum_superman = curriculum_superman.id_curriculum_superman GROUP BY cstu.id_curriculum_superman ) AS users");
        $data = CurriculumSuperman::leftJoin('skill_category as sc', 'curriculum_superman.id_skill_category', '=', 'sc.id_skill_category')
        ->join("competencie_groups as compGroup","compGroup.id","curriculum_superman.curriculum_group")
        ->get(['curriculum_superman.*', 'sc.skill_category','compGroup.name as compGroupName', $users_data]);
        
        return view('pages.admin.superman.index-curriculum', compact('data'));
    }

    public function getSuperman()
    {
        $superman = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
            ->where('is_superman', 1)
            ->orWhere('users.id_level', 'LV-0002')
            ->orWhere('users.id_level', 'LV-0003')
            ->orWhere('users.id_level', 'LV-0004')
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
                    $number = explode("/",$lastId->no_curriculum_superman);
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
                if(isset($request->id_user) && count($request->id_user) > 0){
                    $curriculum = new CurriculumSuperman();
                    $curriculum->no_curriculum_superman = $noCurriculum;
                    $curriculum->id_skill_category = $request->id_skill_category;
                    $curriculum->curriculum_superman = $request->curriculum_superman;
                    $curriculum->curriculum_group = $request->curriculum_group;
                    $curriculum->curriculum_desc = $request->curriculum_desc;
                    $curriculum->target = $request->target;
                    $curriculum->save();

                    $insert = [];
                    for($i = 0;$i < count($request->id_user);$i++){
                        $insert[$i] = [
                            'id_curriculum_superman' => $curriculum->id,
                            'id_user' => $request->id_user[$i]
                        ];
                    }

                    if(count($insert) > 0){
                        CurriculumSupermanToUser::insert($insert);
                    }

                }
                DB::commit();
                return response()->json(['code' => 200, 'message' => 'Curriculum Has Been Created'], 200);
            } catch (\Exception $e) {
                return response()->json(['code' => 422, 'message' => $e->getMessage()], 422);
            }
        }
    }

    public function getFormEdit(Request $request)
    {
        $curriculum = CurriculumSuperman::where("id_curriculum_superman",$request->id)->first();
        $skills = SkillCategoryModel::all();
        $users = User::select("users.id","nama_pengguna",DB::raw("IF(id_cstu IS NULL,0,1) as sts"))
                            ->leftJoin("curriculum_superman_to_user as cstu",function ($join) use ($request){
                                $join->on("cstu.id_user","users.id")
                                    ->where("cstu.id_curriculum_superman",$request->id);
                                    })
                            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                            ->leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                            ->where('is_superman', 1)
                            ->orWhere('users.id_level', 'LV-0002')
                            ->orWhere('users.id_level', 'LV-0003')
                            ->orWhere('users.id_level', 'LV-0004')
                            ->get();
                // User::
                // ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                
                // ->get(['users.id', 'users.nama_pengguna', 'users.id_department', 'dp.nama_department', 'jt.id_job_title', 'jt.nama_job_title']);
        return view("pages.admin.superman.edit-curriculum",compact("curriculum","skills","users"));
    }
    public function edit(Request $request)
    {
        $request->validate([
            'id_skill_category' => ['required'],
            'curriculum_superman' => ['required'],
            'curriculum_group' => ['required'],
            'curriculum_desc' => ['required'],
            'target' => ['required'],
            'id_user' => ['required'],
        ]);
        $curriculum = CurriculumSuperman::where("id_curriculum_superman",$request->id_curriculum_superman)->first();
        $update = [
            'id_skill_category' => $request->id_skill_category,
            'curriculum_superman' => $request->curriculum_superman,
            'curriculum_group' => $request->curriculum_group,
            'curriculum_desc' => $request->curriculum_desc,
            'target' => $request->target,
        ];
        if($curriculum->id_skill_category != $request->id_skill_category){
            $noTraining = explode("/",$curriculum->no_curriculum_superman);
            if($request->id_skill_category == 1){
                $noTraining[2] = "FUNC";
            }else{
                $noTraining[2] = "GEN";
            }
            $update['no_curriculum_superman'] = implode("/",$noTraining);
        }
        CurriculumSuperman::where("id_curriculum_superman",$request->id_curriculum_superman)->update($update);
        $users_array = [];
        for($i = 0; $i < count($request->id_user); $i++){
            array_push($users_array,$request->id_user[$i]);
            CurriculumSupermanToUser::updateOrCreate(['id_curriculum_superman'=>$request->id_curriculum_superman,"id_user"=>$request->id_user[$i]]);
        }
        DB::commit();
        if(count($users_array) > 0){
            CurriculumSupermanToUser::where("id_curriculum_superman",$request->id_curriculum_superman)->whereNotIn("id_user",$users_array)->delete();
        }

        return response()->json(['code' => 200, 'message' => 'Post Edited successfully'], 200);
    }

    public function destroy($id)
    {
        $validator = Validator::make(request()->all(),[
            'id' => ['required']
        ]);
        // dd($id);
        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        CurriculumSuperman::where('id_curriculum_superman', $id)->delete();
        CurriculumSupermanToUser::where("id_curriculum_superman",$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Curriculum Deleted successfully',
            'data' => NULL
        ];

        return response()->json($response);

    }










    // Kelola User
    
    public function indexKelola(){
        return view('pages.admin.superman.index');

    }
    public function supermanJson(Request $request)
    {   
        $id = Auth::user()->id;
        $dp = Auth::user()->id_department;

        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
        ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
        ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
        ->Where('users.id_level', 'LV-0002')
        ->orWhere('users.id_level', 'LV-0003')
        ->orWhere('users.id_level', 'LV-0004')
        ->orderBy('users.id_level', 'DESC')
        ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','level.nama_level']);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button data-id="' . $row->id . '" onclick="getCompSuperman('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-edit"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" onclick="detail('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                    return $btn;
                })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function formSuperman(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     "id" => "requeired|numeric",
        //     "type" => "required|string|in:functional,general"
        // ]);
        // $type = $request->type;
        $user = User::select("id","id_level")
                    ->where("id",$request->id)
                    ->orWhere('users.id_level', 'LV-0002')
                    ->orWhere('users.id_level', 'LV-0003')
                    ->orWhere('users.id_level', 'LV-0004')
                    ->first();

        $comps = CurriculumSupermanToUser::join("curriculum_superman",function ($join) use ($user){
                                                $join->on("curriculum_superman.id_curriculum_superman","curriculum_superman_to_user.id_curriculum_superman")
                                                    ->whereRaw("curriculum_superman_to_user.id_user = '".$user->id."'");
                                            })
                                            ->get(['curriculum_superman.*']);
        dd($comps);

        return view("pages.admin.superman.form",compact('comps','user','type'));
    }

    public function actionSuperman(Request $request)
    {
        $request->validate([
            "user_id" => "required|numeric",
            "data" => "nullable|array",
            "data.*.id" => "nullable|numeric",
            "data.*.start" => "nullable|numeric",
            "data.*.actual" => "nullable|numeric",
            "data.*.ket" => "nullable|string",
        ]);
        DB::beginTransaction();
        try{
            $data = $this->validate_input_v2($request);
            $skillId = [1,2];
            $cek = Superman::whereRaw("id_user = '".$request->user_id."' AND (select count(*) from taging_reason where taging_reason.id_white_tag = white_tag.id_white_tag) <= 0 ")
                        ->join("competencies_directory",function ($join) use ($skillId){
                            $join->on('competencies_directory.id_directory','white_tag.id_directory')
                                ->join('curriculum','curriculum.id_curriculum','competencies_directory.id_curriculum')
                                ->whereIn('curriculum.id_skill_category',$skillId);
                        })
                        ->delete();
            if(isset($data["data"]) && count($data["data"]) > 0){
                $insert = [];
                for($i=0; $i < count($data["data"]); $i++){
                    if($data["data"][$i]["start"] != "" && $data["data"][$i]["actual"] != ""){
                        $insert[$i] = [
                            "id_white_tag"=> $this->random_string(5,5,false).time(),
                            "id_directory" => $data["data"][$i]["id"],
                            "id_user" => $data["user_id"],
                            "start" => $data["data"][$i]["start"],
                            "actual" => $data["data"][$i]["actual"],
                            "keterangan" => $data["data"][$i]["ket"],

                        ];
                    }
                }
                if(count($insert) > 0)Superman::insert($insert);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return response()->json(['code' => 200, 'message' => 'Post successfully'], 200);
    }
}

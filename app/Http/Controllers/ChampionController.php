<?php

namespace App\Http\Controllers;

use App\Champion;
use App\ChampionToUser;
use App\SkillCategoryModel;
use App\User;
use App\WhiteTagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ChampionController extends Controller
{
    public function indexMaster()
    {
        $users_data = DB::raw("(SELECT GROUP_CONCAT(nama_pengguna) FROM curriculum_champion_to_user AS cctu JOIN users ON users.id = cctu.id_user WHERE cctu.id_curriculum_champion = curriculum_champion.id_curriculum_champion GROUP BY cctu.id_curriculum_champion ) AS users");
        $data = Champion::leftJoin('skill_category as sc', 'curriculum_champion.id_skill_category', '=', 'sc.id_skill_category')
        ->join("competencie_groups as compGroup","compGroup.id","curriculum_champion.curriculum_group")
        ->get(['curriculum_champion.*', 'sc.skill_category','compGroup.name as compGroupName', $users_data]);
        return view('pages.admin.champion.index-curriculum', compact('data'));
    }

    public function getChampion()
    {
        $champion = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
            ->where('is_champion', 1)
            ->get(['users.id', 'users.nama_pengguna', 'users.id_department', 'dp.nama_department', 'jt.id_job_title', 'jt.nama_job_title', 'level.nama_level']);

        return response()->json($champion);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'id_skill_category' => ['required'],
            'curriculum_champion' => ['required'],
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
            DB::beginTransaction();
            try {
                $lastId = Champion::orderBy("created_at","desc")->first();
                if(isset($lastId)){
                    $number = explode("/",$lastId->no_curriculum_superman);
                    $lastNumber = (int)$number[0];
                }else{
                    $lastNumber = 0;
                }
                $number = str_pad($lastNumber+1,3,'0',STR_PAD_LEFT); 
                if($request->id_skill_category == 1){
                    $noCurriculum = $number."/4.0/FUNC";
                }else if($request->id_skill_category == 2){
                    $noCurriculum = $number."/4.0/GEN";
                }
                
                if(isset($request->id_user) && count($request->id_user) > 0){
                    $curriculum = new Champion();
                    $curriculum->no_curriculum_champion = $noCurriculum;
                    $curriculum->id_skill_category = $request->id_skill_category;
                    $curriculum->curriculum_champion = $request->curriculum_champion;
                    $curriculum->curriculum_group = $request->curriculum_group;
                    $curriculum->curriculum_desc = $request->curriculum_desc;
                    $curriculum->target = $request->target;
                    $curriculum->save();

                    $insert = [];
                    for($i = 0;$i < count($request->id_user);$i++){
                        $insert[$i] = [
                            'id_curriculum_champion' => $curriculum->id,
                            'id_user' => $request->id_user[$i]
                        ];
                    }

                    if(count($insert) > 0){
                        ChampionToUser::insert($insert);
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
        $curriculum = Champion::where("id_curriculum_champion",$request->id)->first();
        $skills = SkillCategoryModel::all();
        $users = User::select("users.id","nama_pengguna",DB::raw("IF(id_cctu IS NULL,0,1) as sts"))
                            ->leftJoin("curriculum_champion_to_user as cctu",function ($join) use ($request){
                                $join->on("cctu.id_user","users.id")
                                    ->where("cctu.id_curriculum_champion",$request->id);
                                    })
                            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                            ->leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                            ->where('is_champion', 1)
                            ->get();
        return view("pages.admin.champion.edit-curriculum",compact("curriculum","skills","users"));
    }
    
    public function edit(Request $request)
    {
        $request->validate([
            'id_skill_category' => ['required'],
            'curriculum_champion' => ['required'],
            'curriculum_group' => ['required'],
            'curriculum_desc' => ['required'],
            'target' => ['required'],
            'id_user' => ['required'],
        ]);
        $curriculum = Champion::where("id_curriculum_superman",$request->id_curriculum_superman)->first();
        $update = [
            'id_skill_category' => $request->id_skill_category,
            'curriculum_champion' => $request->curriculum_champion,
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
        Champion::where("id_curriculum_superman",$request->id_curriculum_superman)->update($update);
        $users_array = [];
        for($i = 0; $i < count($request->id_user); $i++){
            array_push($users_array,$request->id_user[$i]);
            ChampionToUser::updateOrCreate(['id_curriculum_superman'=>$request->id_curriculum_superman,"id_user"=>$request->id_user[$i]]);
        }
        DB::commit();
        if(count($users_array) > 0){
            ChampionToUser::where("id_curriculum_superman",$request->id_curriculum_superman)->whereNotIn("id_user",$users_array)->delete();
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

        Champion::where('id_curriculum_superman', $id)->delete();
        ChampionToUser::where("id_curriculum_superman",$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Curriculum Deleted successfully',
            'data' => NULL
        ];

        return response()->json($response);

    }








    // Index
    public function index()
    {
        return view('pages.admin.champion.index');
    }

    public function getJson(Request $request)
    {   
        $champion = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
            ->where('is_champion', 1)
            ->get(['users.id', 'users.nama_pengguna', 'users.id_department', 'dp.nama_department', 'jt.id_job_title', 'jt.nama_job_title', 'level.nama_level']);

        
        return Datatables::of($champion)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button data-id="' . $row->id . '" onclick="getCompChampion('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-edit"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" onclick="detailMapcomChampion('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                    return $btn;
                })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function formChampion(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id" => "requeired|numeric",
            "type" => "required|string|in:functional,general"
        ]);
        $type = $request->type;
        $user = User::select("id","id_level")
                    ->where("id",$request->id)
                    ->first();

        $select = [
            "curriculum_champion.no_curriculum_champion as no_curriculum", "curriculum_champion.target as target",
            "curriculum_champion.curriculum_champion as curriculum_champion","curriculum_champion.curriculum_group as curriculum_group",
            "skill_category.skill_category as skill_category","white_tag.start as start", "white_tag.actual as actual","white_tag.keterangan as ket",
            
            DB::raw("(SELECT COUNT(*) FROM taging_reason as tr where tr.id_white_tag = white_tag.id_white_tag) as cntTagingReason"),
            DB::raw("(CASE WHEN (white_tag.actual - curriculum_champion.target) < 0 THEN 'Open'
                            WHEN (white_tag.actual IS NULL) THEN 'Belum diatur'
                            WHEN white_tag.actual >= curriculum_champion.target THEN 'Close' 
                            END) as tagingStatus"),"compGroup.name as compGroupName"
        ];
        $comps = ChampionToUser::select($select)
                                    ->join("curriculum_champion",function ($join) use ($user){
                                        $join->on("curriculum_champion.id_curriculum_champion","curriculum_champion_to_user.id_curriculum_champion")
                                            ->whereRaw("curriculum_champion_to_user.id_user = '".$user->id."'");
                                    })
                                    ->join("competencie_groups as compGroup","compGroup.id","curriculum_champion.curriculum_group")
                                    ->join("skill_category","skill_category.id_skill_category","curriculum_champion.id_skill_category")
                                    ->leftJoin("white_tag",function ($join) use ($user){
                                        $join->on("white_tag.id_cctu","curriculum_champion_to_user.id_cctu")
                                            ->where("white_tag.id_user",$user->id);
                                    })
                                    ->get();
        // dd($comps);                                    
        return view("pages.admin.champion.form",compact('comps','user','type'));
    }

    public function actionChampion(Request $request)
    {
        $request->validate([
            "user_id" => "required|numeric",
            "data" => "nullable|array",
            "data.*.id" => "nullable|numeric",
            "data.*.start" => "nullable|numeric",
            "data.*.actual" => "nullable|numeric",
            "data.*.ket" => "nullable|string",
        ]);
    
        try{
        DB::beginTransaction();
            $data = $this->validate_input_v2($request);
            $skillId = [1,2];

            // Check
            $cek = WhiteTagModel::whereRaw("id_user = '".$request->user_id."' AND (select count(*) from taging_reason where taging_reason.id_white_tag = white_tag.id_white_tag) <= 0 ")
                        ->join("curriculum_champion_to_user",function ($join) use ($skillId){
                            $join->on('curriculum_champion_to_user.id_cctu','white_tag.id_cctu')
                                ->join('curriculum_champion','curriculum_champion.id_curriculum_champion','curriculum_champion_to_user.id_curriculum_champion')
                                ->whereIn('curriculum.id_skill_category',$skillId);
                        })
                        ->delete();
            if(isset($data["data"]) && count($data["data"]) > 0){
                $insert = [];
                for($i=0; $i < count($data["data"]); $i++){
                    if($data["data"][$i]["start"] != "" && $data["data"][$i]["actual"] != ""){
                        $insert[$i] = [
                            "id_white_tag"=> $this->random_string(5,5,false).time(),
                            "id_cctu" => $data["data"][$i]["id"],
                            "id_user" => $data["user_id"],
                            "start" => $data["data"][$i]["start"],
                            "actual" => $data["data"][$i]["actual"],
                            "keterangan" => $data["data"][$i]["ket"],
                        ];
                    }
                }
                // dd($insert);
                if(count($insert) > 0)WhiteTagModel::insert($insert);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        return response()->json(['code' => 500, 'message' => $e], 500);

        }
        return response()->json(['code' => 200, 'message' => 'Post successfully'], 200);
    }

    public function detailMapcomChampion(Request $request)
    {
        $user = User::select("id","id_job_title")->where("id",$request->id)->first();
        $skillId = [1,2];
        $select = [
            "curriculum_champion.no_curriculum_champion as no_curriculum","curriculum_champion.curriculum_champion as curriculum_champion","compGroup.name as curriculum_group","curriculum_champion.target as target","skill_category.skill_category as skill_category","white_tag.start as start","white_tag.actual as actual",
            DB::raw("(CASE WHEN (white_tag.actual - curriculum_champion.target) < 0 THEN 'Open'
                            WHEN (white_tag.actual IS NULL) THEN 'Belum diatur'
                            WHEN white_tag.actual >= curriculum_champion.target THEN 'Close' 
                            END) as tagingStatus"),
                            "white_tag.keterangan as ket"
        ];
        $data = ChampionToUser::select($select)
                                ->join("curriculum_champion",function ($join) use ($user,$skillId){
                                    $join->on("curriculum_champion.id_curriculum_champion","curriculum_champion_to_user.id_curriculum_champion")
                                        ->whereIn("id_skill_category",$skillId);
                                })
                                ->join("skill_category","skill_category.id_skill_category","curriculum_champion.id_skill_category")
                                ->leftJoin("white_tag",function ($join) use ($user){
                                    $join->on("white_tag.id_cctu","curriculum_champion_to_user.id_cctu")
                                        ->where("white_tag.id_user",$user->id);
                                })
                                ->join("competencie_groups as compGroup","compGroup.id","curriculum_champion.curriculum_group")
                                ->groupBy("curriculum_champion.id_curriculum_champion")
                                ->orderBy("tagingStatus", "DESC")
                                ->get();
        // dd($data);                        
        return Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('start', function ($row) {
            switch($row->start){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto tooltip-info" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;
                    
            }
            return $icon;
        })
        ->editColumn('actual', function ($row) {
            switch($row->actual){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;
                    
            }
            return $icon;
        })
        ->editColumn('target', function ($row) {
            switch($row->target){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;
                    
            }
            return $icon;
        })
        ->addColumn('tagingStatus', function ($row) {
            if (isset($row->tagingStatus)) {
                if ($row->tagingStatus == 'Close') {
                    $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                    return $label;
                } else {
                    $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                    return $label;
                }
            }
        })
        ->rawColumns(['start','actual','target','tagingStatus'])
        ->make(true);
        
    }



    public function indexMember(){
        return view('pages.admin.champion.index-member');
    }
}

<?php

namespace App\Http\Controllers;

use App\Champion;
use App\ChampionToUser;
use App\SkillCategoryModel;
use App\User;
use App\WhiteTagModel;
use App\TagingReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

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
                    $number = explode("/", $lastId->no_curriculum_champion);
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
        $curriculum = Champion::where("id_curriculum_champion", $request->id_curriculum_champion)->first();
        $update = [
            'id_skill_category' => $request->id_skill_category,
            'curriculum_champion' => $request->curriculum_champion,
            'curriculum_group' => $request->curriculum_group,
            'curriculum_desc' => $request->curriculum_desc,
            'target' => $request->target,
        ];
        if($curriculum->id_skill_category != $request->id_skill_category){
            $noTraining = explode("/", $curriculum->no_curriculum_champion);
            if($request->id_skill_category == 1){
                $noTraining[2] = "FUNC";
            }else{
                $noTraining[2] = "GEN";
            }
            $update['no_curriculum_champion'] = implode("/", $noTraining);
        }
        Champion::where("id_curriculum_champion", $request->id_curriculum_champion)->update($update);
        $users_array = [];
        for($i = 0; $i < count($request->id_user); $i++){
            array_push($users_array,$request->id_user[$i]);
            ChampionToUser::updateOrCreate(['id_curriculum_champion' => $request->id_curriculum_champion, "id_user" => $request->id_user[$i]]);
        }
        DB::commit();
        if(count($users_array) > 0){
            ChampionToUser::where("id_curriculum_champion", $request->id_curriculum_champion)->whereNotIn("id_user", $users_array)->delete();
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

        Champion::where('id_curriculum_champion', $id)->delete();
        ChampionToUser::where("id_curriculum_champion", $id)->delete();

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
            "curriculum_champion_to_user.id_cctu",
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
            $cek = WhiteTagModel::whereRaw("white_tag.id_user = '".$request->user_id."' AND (select count(*) from taging_reason where taging_reason.id_white_tag = white_tag.id_white_tag) <= 0 ")
                        ->join("curriculum_champion_to_user",function ($join) use ($skillId){
                            $join->on('curriculum_champion_to_user.id_cctu','white_tag.id_cctu')
                                ->join('curriculum_champion','curriculum_champion.id_curriculum_champion','curriculum_champion_to_user.id_curriculum_champion')
                                ->whereIn('curriculum_champion.id_skill_category',$skillId);
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

    //Halaman member champion
    public function indexMember(){
        return view('pages.admin.champion.index-member');
    }

    public function championJson()
    {
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
        ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
        ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
        ->where('is_champion', 1)
        ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                // $btn = '<button class="btn btn-inverse-success btn-icon mr-1" data-toggle="modal" onclick="formEdit(' . $row->id . ')" data-target="#modal-edit"><i class="icon-file menu-icon"></i></button>';
                $btn = '<button data-id="' . $row->id . '" class="btn btn-inverse-danger btn-icon member-hapus mr-1" data-toggle="modal" data-target="#modal-hapus"><i class="icon-trash"></i></button>';
                $btn = $btn . '<button type="button" onclick="detail(' . $row->id . ')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function championMemberStore(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
        ]);
        
        try {
            DB::beginTransaction();
                $data = [
                    'is_champion' => 1,
                ];
                User::whereIn('id',$request->id_user)->update($data); 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        return response()->json(['code' => 300, 'message' => $e], 300);

        }
        return response()->json(['code' => 200, 'message' => 'Enroll Update'], 200);
    }

    public function championMemberDelete($id)
    {
        $data = [
            'is_champion' => 0,
        ];
        User::where('id',$id)->update($data);  
        return redirect()->route('Member')->with(['success' => 'Champion Deleted successfully']);
    
    }

    //Tangging Champion
    public function indexTangging(){
        return view ("pages.admin.champion.taging-champion.index");
    }

    public function tagingChampionJson(Request $request)
    {
        $where = "white_tag.actual < cc.target OR (SELECT COUNT(*) FROM taging_reason where white_tag.id_white_tag = taging_reason.id_white_tag) > 0";
        $cgAuth = Auth::user()->id_cg;
        $select = [
            "id_taging_reason","white_tag.id_white_tag","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "skill_category","curriculum_champion","nama_cg","nik",
            "curriculum_group","white_tag.actual as actual",
            "cc.target as target",DB::raw("(white_tag.actual - cc.target) as actualTarget"),DB::raw("(IF((white_tag.actual - cc.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        $data = WhiteTagModel::select($select)
                            ->join("curriculum_champion_to_user as cctu",function ($join){
                                $join->on("cctu.id_cctu","white_tag.id_cctu");
                            })
                            ->join("curriculum_champion as cc",function ($join){
                                $join->on("cc.id_curriculum_champion","cctu.id_curriculum_champion");
                            })
                            ->leftJoin("taging_reason as tr","tr.id_white_tag","white_tag.id_white_tag")
                            ->join("users","users.id","white_tag.id_user")
                            ->join("skill_category as sc","sc.id_skill_category","cc.id_skill_category")
                            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                            ->whereRaw($where)
                            ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            if (isset($row->id_taging_reason)) {
                $btn = '<button white-tag-id="' . $row->id_white_tag . '" taging-reason-id="' . $row->id_taging_reason . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" onclick="detailTaging(' . $row->id_taging_reason . ')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                $btn = $btn . '<button data-id="' . $row->id_taging_reason . '" class="btn btn-inverse-danger btn-icon tagging-hapus mr-1" data-toggle="modal" data-target="#modal-hapus"><i class="icon-trash"></i></button>';
                return $btn;
            } else {
                $btn = '<button white-tag-id="' . $row->id_white_tag . '" taging-reason-id="' . $row->id_taging_reason . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                return $btn;
            }
        })
            ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Finished') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    } else {
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }

                    // switch ($row->tagingStatus) {
                    //     case "Finished":
                    //         $label = '<span class="badge badge-success">"' . $row->tagingStatus . '"</span>';
                    //         return $label;
                    //         break;
                    //     case "Follow Up":
                    //         $label = '<span class="badge badge-secondary">"' . $row->tagingStatus . '"</span>';
                    //         return $label;
                    //         break;
                    //     default:
                    //         return '';
                    // }
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tagingStatus'])
            ->make(true);
    }
    public function tagingJsonAtasan(Request $request)
    {
        $where = "white_tag.actual < cd.target OR (SELECT COUNT(*) FROM taging_reason where white_tag.id_white_tag = taging_reason.id_white_tag) > 0";
        $dept = Auth::user()->id_department;
        $id = Auth::user()->id;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $select = [
            "id_taging_reason","white_tag.id_white_tag","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "skill_category","training_module","nik",
            "level","training_module_group","white_tag.actual as actual",
            "cd.target as target",DB::raw("(white_tag.actual - cd.target) as actualTarget"),DB::raw("(IF((white_tag.actual - cd.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        $data = WhiteTagModel::select($select)
                            ->join("competencies_directory as cd",function ($join){
                                $join->on("cd.id_directory","white_tag.id_directory");
                            })
                            ->leftJoin("taging_reason as tr","tr.id_white_tag","white_tag.id_white_tag")
                            ->join("users",function ($join) use ($request,$dept,$cgtambah,$id,$cgtambah2,$cgtambah3,$cgtambah4,$cgtambah5) {
                                $join->on("users.id","white_tag.id_user");
                                if (isset($request->type)) {
                                    if ($request->type == 'depthead') {
                                        $join->where("users.id_department", $dept);
                                    } elseif ($request->type == 'spv') {
                                        $join->where(function ($query) use ($id, $cgtambah,$cgtambah2,$cgtambah3,$cgtambah4,$cgtambah5) {
                                            $query->where('users.id', $id)
                                                  ->orWhere('users.id_cg', $cgtambah)
                                                  ->orWhere('users.id_cg', $cgtambah2)
                                                  ->orWhere('users.id_cg', $cgtambah3)
                                                  ->orWhere('users.id_cg', $cgtambah4)
                                                  ->orWhere('users.id_cg', $cgtambah5);
                                        });
                                    }
                                }
                            })
                            ->join("curriculum","curriculum.id_curriculum","cd.id_curriculum")
                            ->join("skill_category as sc","sc.id_skill_category","curriculum.id_skill_category")
                            ->whereRaw($where)
                            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            if (isset($row->id_taging_reason)) {
                $btn = '<button white-tag-id="' . $row->id_white_tag . '" taging-reason-id="' . $row->id_taging_reason . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" onclick="detailTaging(' . $row->id_taging_reason . ')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            } else {
                $btn = '<button white-tag-id="' . $row->id_white_tag . '" taging-reason-id="' . $row->id_taging_reason . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                return $btn;
            }
        })
            ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Finished') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    } else {
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }

                    // switch ($row->tagingStatus) {
                    //     case "Finished":
                    //         $label = '<span class="badge badge-success">"' . $row->tagingStatus . '"</span>';
                    //         return $label;
                    //         break;
                    //     case "Follow Up":
                    //         $label = '<span class="badge badge-secondary">"' . $row->tagingStatus . '"</span>';
                    //         return $label;
                    //         break;
                    //     default:
                    //         return '';
                    // }
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tagingStatus'])
            ->make(true);
    }

    public function tagingJsonMember(Request $request)
    {
        $where = "white_tag.actual < cd.target OR (SELECT COUNT(*) FROM taging_reason where white_tag.id_white_tag = taging_reason.id_white_tag) > 0";
        $id_user = Auth::user()->id;
        $select = [
            "id_taging_reason","white_tag.id_white_tag","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "skill_category","training_module","nik",
            "level","training_module_group","white_tag.actual as actual",
            "cd.target as target",DB::raw("(white_tag.actual - cd.target) as actualTarget"),DB::raw("(IF((white_tag.actual - cd.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        $data = WhiteTagModel::select($select)
                            ->join("competencies_directory as cd",function ($join){
                                $join->on("cd.id_directory","white_tag.id_directory");
                            })
                            ->leftJoin("taging_reason as tr","tr.id_white_tag","white_tag.id_white_tag")
                            ->join("users",function ($join) use ($request,$id_user) {
                                $join->on("users.id","white_tag.id_user");
                                if(isset($request->type) && $request->type == 'member'){
                                    $join->where("users.id",$id_user);
                                }
                            })
                            ->join("curriculum","curriculum.id_curriculum","cd.id_curriculum")
                            ->join("skill_category as sc","sc.id_skill_category","curriculum.id_skill_category")
                            ->whereRaw($where)
                            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            if (isset($row->id_taging_reason)) {
                $btn = '<button type="button" onclick="detailTaging(' . $row->id_taging_reason . ')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            } else {
                $btn = '';
                return $btn;
            }
        })
            ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Finished') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    } else {
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tagingStatus'])
            ->make(true);
    }
    

    public function championFormTagging(Request $request)
    {   
        $id_white_tag = $request->white_tag_id;
        $id_reason_tag = $request->reasonTagId;
        $white_tag = WhiteTagModel::select("actual")
                                    ->where("id_white_tag",$request->white_tag_id)
                                    ->first();
        if(isset($id_reason_tag)){
            $select = [
                "taging_reason.id_taging_reason","taging_reason.id_white_tag as id_white_tag","year","period",
                DB::raw("DATE_FORMAT(date_open,'%d-%m-%Y') AS date_open"),DB::raw("DATE_FORMAT(due_date,'%d-%m-%Y') AS due_date"),"learning_method","trainer",DB::raw("DATE_FORMAT(date_plan_implementation,'%d-%m-%Y') AS date_plan_implementation"),
                "notes_learning_implementation",DB::raw("DATE_FORMAT(date_closed,'%d-%m-%Y') AS date_closed"),
                DB::raw("(TIME_FORMAT(taging_reason.start,'%H:%i')) as start"),
                DB::raw("(TIME_FORMAT(finish,'%H:%i')) as finish"),"duration",DB::raw("DATE_FORMAT(date_verified,'%d-%m-%Y') AS date_verified"),
                "result_score","notes_for_result"
            ];
            $taging = TagingReason::select($select)
                                    ->join("white_tag as wt",function ($join) use ($id_reason_tag){
                                        $join->on("taging_reason.id_white_tag","wt.id_white_tag")
                                            ->where("id_taging_reason",$id_reason_tag);
                                    })
                                    ->first();
        }else{
            $taging = null;
        }
        return view("pages.admin.champion.taging-champion.form",compact(["id_white_tag","id_reason_tag","taging","white_tag"]));
    }

    public function championActionTaging(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi !',
            'min'      => ':attribute harus di isi minimal :min karakter !!',
            'max'      => ':attribute jangan diisi lebih dari :max karakter !!'
        ];

        $this->validate($request,[
            "id_taging_reason" => "nullable|numeric",
            "id_white_tag" => "required|string|min:15|max:15",
            "year" => "required|digits:4",
            "period" => "required|string|max:20",
            // "date_open" => "required|date_format:d-m-Y",
            // "due_date" => "required|date_format:d-m-Y",
            "learning_method" => "required|string|in:0,1,2,3,4,5,6",
            "trainer" => "required|string|max:50",
            "date_plan_implementation" => "required|date_format:d-m-Y",
            // "notes_learning_implementation" => "nullable|string",
            // "date_closed" => "required|date_format:d-m-Y",
            // "start" => "required|date_format:H:i",
            // "finish" => "required|date_format:H:i",
            // "duration" => "nullable|string",
            "date_verified" => "required|date_format:d-m-Y",
            "result_score" => "required|numeric|min:0|max:5",
            "notes_for_result" => "nullable|string"
        ],$messages);
        DB::beginTransaction();
        try {
            $data = $request->all();
            $tempData = [
                "year" => $data["year"],
                "period" => $data["period"],
                // "date_open" => date("Y-m-d", strtotime($data["date_open"])),
                // "due_date" => date("Y-m-d", strtotime($data["due_date"])),
                "learning_method" => $data["learning_method"],
                "trainer" => $data["trainer"],
                "date_plan_implementation" => date("Y-m-d", strtotime($data["date_plan_implementation"])),
                // "notes_learning_implementation" => $data["notes_learning_implementation"],
                // "date_closed" => date("Y-m-d", strtotime($data["date_closed"])),
                // "start" => $data["start"],
                // "finish" => $data["finish"],
                // "duration" => $data["duration"],
                "date_verified" => date("Y-m-d", strtotime($data["date_verified"])),
                "result_score" => $data["result_score"],
                "notes_for_result" => $data["notes_for_result"]
            ];
            if(isset($data["id_taging_reason"])){
                TagingReason::where("id_taging_reason",$data["id_taging_reason"])
                ->update($tempData);
                $messages = "Success! Data berhasil diperbaharui";
            }else{
                $lastId = TagingReason::orderBy("id_taging_reason","desc")->first();
                if(isset($lastId)){
                    $lastNumber = (int)$lastId->no_taging;
                }else{
                    $lastNumber = 0;
                }
                $tempData["no_taging"] = str_pad($lastNumber+1,5,'0',STR_PAD_LEFT);
                $tempData["id_white_tag"] = $data["id_white_tag"];
                $tempData["id_verified_by"] = Auth::user()->id;
                TagingReason::insert($tempData);
                $messages = "Success! Data berhasil di Follow Up";
            }
            WhiteTagModel::where("id_white_tag",$data["id_white_tag"])
                            ->update([
                                "actual" => $data["result_score"],
                                "keterangan" => $data["notes_for_result"] // Tambahkan kolom "keterangan" ke sini
                            ]);
            DB::commit();
            return Response::json(['success' => $messages]);
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['errors' => $e->getMessage(),'message'=>'error'],402);
        }
    }

    public function tagingDetail(Request $request){
        $validator = Validator::make($request->all(),[
            "id" => "required|numeric"
        ]);

        if($validator->fails()){
            // dd($validator->errors());
        }else{
            $select = [
                "taging_reason.no_taging as no_taging",
                "taging_reason.year as year",
                "taging_reason.period as period",
                "member.nama_pengguna as name",
                "cg.nama_cg as name_cg",
                "curriculum_champion.curriculum_group as training_module_group",
                "curriculum_champion.curriculum_champion as training_module",
                "wt.actual as actual",
                "curriculum_champion.target as target",
                // "taging_reason.date_open as date_open",
                // "taging_reason.due_date as due_date",
                "taging_reason.date_plan_implementation as date_plan_implementation",
                DB::raw("(CASE WHEN taging_reason.learning_method = '0' THEN 'Internal Training'
                                        WHEN taging_reason.learning_method = '1' THEN 'External Training'
                                        WHEN taging_reason.learning_method = '2' THEN 'In House Training'
                                        WHEN taging_reason.learning_method = '3' THEN 'Learn From Expertise' 
                                        WHEN taging_reason.learning_method = '4' THEN 'Learn From Book' 
                                        WHEN taging_reason.learning_method = '5' THEN 'On the-Job Training' 
                                ELSE 'Sharing' END) as learning_method"),
                "taging_reason.trainer as trainer",
                // "taging_reason.notes_learning_implementation as notes_learning_implementation",
                // "taging_reason.date_closed as date_closed",
                // DB::raw("TIME_FORMAT(taging_reason.start,'%H:%i') as start"),
                // DB::raw("TIME_FORMAT(taging_reason.finish,'%H:%i') as finish"),
                "taging_reason.date_verified as date_verified",
                "verified.nama_pengguna as verified_by",
                "taging_reason.result_score as result_score",
                "taging_reason.notes_for_result as notes_for_result"
            ];
            $data = TagingReason::select($select)
                                ->join("users as verified",function ($join) use ($request){
                                    $join->on("verified.id","id_verified_by")
                                            ->where("id_taging_reason",$request->id);
                                })
                                ->join("white_tag as wt","wt.id_white_tag","taging_reason.id_white_tag")
                                ->join("users as member","member.id","wt.id_user")
                                ->join("curriculum_champion_to_user as cctu","cctu.id_cctu","wt.id_cctu")
                                ->join("curriculum_champion","curriculum_champion.id_curriculum_champion","cctu.id_curriculum_champion")
                                ->join("cg","cg.id_cg","member.id_cg")
                                ->first();
            return view("pages.admin.champion.taging-champion.detail",compact("data"));
        }
    }

    public function exportTaggingList(Request $request)
    {
        $this->validate($request,[
            "category"=>"required|in:0,1,2",
            "all"=>"required|in:0,1"
        ]);
        $type = "";
        if($request->all == 0){
            $cg = CG::where("id_cg",Auth::user()->id_cg)->first();
            $type = "(".$cg->nama_cg.")";
        }
        $dateTime = date("d-m-Y H:i"); 
        switch ($request->category) {
            case '0':
                $fileName = "Tagging List ".$type." Semua (".$dateTime.").xlsx";
            break;
            case '1':
                $fileName = "Tagging List ".$type." Belum Finish (".$dateTime.").xlsx";
            break;
            case '2':
                $fileName = "Tagging List ".$type." Finish (".$dateTime.").xlsx";
            break;
        }
        return Excel::download(new TaggingListExport($request->category,$request->all), $fileName);
        return redirect()->back();
    }

    public function championTaggingPrint(Request $request)
    {
        $this->validate($request,[
            "id"=>"required"
        ]);
        $select = [
            "taging_reason.no_taging as no_taging",
            "taging_reason.year as year",
            "taging_reason.period as period",
            "member.nama_pengguna as name",
            "curriculum_champion.curriculum_group as training_module_group",
            "curriculum_champion.curriculum_champion as training_module",
            "wt.actual as actual",
            "curriculum_champion.target as target",
            // "taging_reason.date_open as date_open",
            // "taging_reason.due_date as due_date",
            "taging_reason.date_plan_implementation as date_plan_implementation",
            DB::raw("(CASE WHEN taging_reason.learning_method = '0' THEN 'Internal Training'
                            WHEN taging_reason.learning_method = '1' THEN 'External Training'
                            WHEN taging_reason.learning_method = '2' THEN 'In House Training'
                            WHEN taging_reason.learning_method = '3' THEN 'Learn From Expertise' 
                            WHEN taging_reason.learning_method = '4' THEN 'Learn From Book' 
                            WHEN taging_reason.learning_method = '5' THEN 'On the-Job Training' 
                            ELSE 'Sharing' END) as learning_method"),
            "taging_reason.trainer as trainer",
            // "taging_reason.notes_learning_implementation as notes_learning_implementation",
            // "taging_reason.date_closed as date_closed",
            // DB::raw("TIME_FORMAT(taging_reason.start,'%H:%i') as start"),
            // DB::raw("TIME_FORMAT(taging_reason.finish,'%H:%i') as finish"),
            "taging_reason.date_verified as date_verified",
            "verified.nama_pengguna as verified_by",
            "taging_reason.result_score as result_score",
            "taging_reason.notes_for_result as notes_for_result"
        ];
        $data = TagingReason::select($select)
                            ->join("users as verified",function ($join) use ($request){
                                $join->on("verified.id","id_verified_by")
                                        ->where("id_taging_reason",$request->id);
                            })
                            ->join("white_tag as wt","wt.id_white_tag","taging_reason.id_white_tag")
                            ->join("users as member","member.id","wt.id_user")
                            ->join("curriculum_champion_to_user as cctu","cctu.id_cctu","wt.id_cctu")
                            ->join("curriculum_champion","curriculum_champion.id_curriculum_champion","cctu.id_curriculum_champion")
                            ->first();
        return view("pages.admin.champion.taging-champion.print-competency-tag",compact("data"));
    }
    public function deleteTagging()
    {
        $validator = Validator::make(request()->all(),[
            'id' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id');
        TagingReason::where('id_taging_reason',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Tagging berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

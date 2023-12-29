<?php

namespace App\Http\Controllers;

use App\Champion;
use App\ChampionToUser;
use App\SkillCategoryModel;
use App\User;
use App\WhiteTagModel;
use App\TagingReason;
use App\GroupChampionModel;
use App\SubGroupChampionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Exports\TaggingChampionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class ChampionController extends Controller
{
    //Curriculum Champion
    public function indexMaster()
    {
        $users_data = DB::raw("(SELECT GROUP_CONCAT(nama_pengguna) FROM curriculum_champion_to_user AS cctu JOIN users ON users.id = cctu.id_user WHERE cctu.id_curriculum_champion = curriculum_champion.id_curriculum_champion GROUP BY cctu.id_curriculum_champion ) AS users");
        $data = Champion::leftJoin('group_champion as sc', 'curriculum_champion.id_group_champion', '=', 'sc.id_group_champion')
        ->join("sub_group_champion as compGroup","compGroup.id_sub_group_champion","curriculum_champion.id_sub_group_champion")
        ->get(['curriculum_champion.*', 'sc.nama_group_champion','compGroup.name as compGroupName', $users_data]);
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
            'id_group_champion' => ['required'],
            'curriculum_champion' => ['required'],
            'id_sub_group_champion' => ['required'],
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
                if($request->id_group_champion == 1){
                    $noCurriculum = $number."/4.0/DATA";
                }else if($request->id_group_champion == 2){
                    $noCurriculum = $number."/4.0/DEV";
                }else if($request->id_group_champion == 3){
                    $noCurriculum = $number."/4.0/MULMED";
                }else if($request->id_group_champion == 4){
                    $noCurriculum = $number."/4.0/ITOT";
                }
                
                if(isset($request->id_user) && count($request->id_user) > 0){
                    $curriculum = new Champion();
                    $curriculum->no_curriculum_champion = $noCurriculum;
                    $curriculum->id_group_champion = $request->id_group_champion;
                    $curriculum->curriculum_champion = $request->curriculum_champion;
                    $curriculum->id_sub_group_champion = $request->id_sub_group_champion;
                    $curriculum->curriculum_desc = $request->curriculum_desc;
                    $curriculum->target = $request->target;
                    $curriculum->trainer = $request->trainer;
                    $curriculum->level = $request->level;
                    $curriculum->save();
                    // dd($curriculum);
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
        $skills = GroupChampionModel::all();
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
            'id_group_champion' => ['required'],
            'curriculum_champion' => ['required'],
            'id_sub_group_champion' => ['required'],
            'curriculum_desc' => ['required'],
            'target' => ['required'],
            'id_user' => ['required'],
        ]);
        $curriculum = Champion::where("id_curriculum_champion", $request->id_curriculum_champion)->first();
        $update = [
            'id_group_champion' => $request->id_group_champion,
            'curriculum_champion' => $request->curriculum_champion,
            'id_sub_group_champion' => $request->id_sub_group_champion,
            'curriculum_desc' => $request->curriculum_desc,
            'target' => $request->target,
            'trainer' => $request->trainer,
            'level' => $request->level,
        ];
        if($curriculum->id_group_champion != $request->id_group_champion){
            $noTraining = explode("/", $curriculum->no_curriculum_champion);
            if($request->id_group_champion == 1){
                $noTraining[2] = "DATA";
            }else if($request->id_group_champion == 2){
                $noTraining[2] = "DEV";
            }else if($request->id_group_champion == 3){
                $noTraining[2] = "MULMED";
            }else{
                $noTraining[2] = "ITOT";
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

    public function destroyCurriculum()
    {
        $validator = Validator::make(request()->all(),[
            'id' => ['required']
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors());
        }
        $id = request('id');
        // dd($id);
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


    // Mapping Competency Champion Index
    public function index()
    {
        return view('pages.admin.champion.index');
    }

    public function getJson(Request $request)
    {   
        $dp = Auth::user()->id_department;
        $id = Auth::user()->id;
        $cgExtraAuth = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        if(Auth::user()->id_level == 'LV-0003'){
            $champion = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
            ->where('is_champion', 1)
            ->Where('users.id_department', $dp)
            ->get(['users.id', 'users.nama_pengguna', 'users.id_department', 'dp.nama_department', 'jt.id_job_title', 'jt.nama_job_title', 'level.nama_level']);
        }else if(Auth::user()->id_level == 'LV-0004'){
            $champion = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
            ->where('is_champion', 1)
            ->where(function ($query) use ($cgExtraAuth, $cgtambah2, $cgtambah3, $cgtambah4, $cgtambah5, $id) {
                $query->Where('users.id', $id)
                ->orWhere('users.id_cg', $cgExtraAuth)
                ->orWhere('users.id_cg', $cgtambah2)
                ->orWhere('users.id_cg', $cgtambah3)
                ->orWhere('users.id_cg', $cgtambah4)
                ->orWhere('users.id_cg', $cgtambah5);
            })
            ->get(['users.id', 'users.nama_pengguna', 'users.id_department', 'dp.nama_department', 'jt.id_job_title', 'jt.nama_job_title', 'level.nama_level']);
        }else{
            $champion = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
            ->where('is_champion', 1)
            ->get(['users.id', 'users.nama_pengguna', 'users.id_department', 'dp.nama_department', 'jt.id_job_title', 'jt.nama_job_title', 'level.nama_level']);
        }
        
        
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
            "curriculum_champion.curriculum_champion as curriculum_champion","curriculum_champion.id_sub_group_champion as curriculum_group",
            "group_champion.nama_group_champion as group_champion","white_tag.start as start", "white_tag.actual as actual","white_tag.keterangan as ket",
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
                                    ->join("sub_group_champion as compGroup","compGroup.id_sub_group_champion","curriculum_champion.id_sub_group_champion")
                                    ->join("group_champion","group_champion.id_group_champion","curriculum_champion.id_group_champion")
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
                                ->whereIn('curriculum_champion.id_group_champion',$skillId);
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
        $skillId = [1,2,3,4];
        $select = [
            "curriculum_champion.no_curriculum_champion as no_curriculum","curriculum_champion.curriculum_champion as curriculum_champion","compGroup.name as curriculum_group","curriculum_champion.target as target","group_champion.nama_group_champion as group_champion","white_tag.start as start","white_tag.actual as actual",
            DB::raw("(CASE WHEN (white_tag.actual - curriculum_champion.target) < 0 THEN 'Open'
                            WHEN (white_tag.actual IS NULL) THEN 'Belum diatur'
                            WHEN white_tag.actual >= curriculum_champion.target THEN 'Close' 
                            END) as tagingStatus"),
                            "white_tag.keterangan as ket"
        ];
        $data = ChampionToUser::select($select)
                                ->join("curriculum_champion",function ($join) use ($user){
                                    $join->on("curriculum_champion.id_curriculum_champion","curriculum_champion_to_user.id_curriculum_champion")
                                        ->whereRaw("curriculum_champion_to_user.id_user = '".$user->id."'");
                                })
                                ->leftJoin("white_tag",function ($join) use ($user){
                                    $join->on("white_tag.id_cctu","curriculum_champion_to_user.id_cctu")
                                    ->where("white_tag.id_user",$user->id);
                                })
                                ->join("group_champion","group_champion.id_group_champion","curriculum_champion.id_group_champion")
                                ->join("sub_group_champion as compGroup","compGroup.id_sub_group_champion","curriculum_champion.id_sub_group_champion")
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
                    $label = '<span class="badge badge-danger text-white">' . $row->tagingStatus . '</span>';
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
        return redirect()->route('member.champion.index')->with(['success' => 'Champion Deleted successfully']);
    
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
            "nama_group_champion","curriculum_champion","nama_cg","nik",
            "id_sub_group_champion","white_tag.actual as actual",
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
                            ->join("group_champion as sc","sc.id_group_champion","cc.id_group_champion")
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
        $where = "white_tag.actual < cc.target OR (SELECT COUNT(*) FROM taging_reason where white_tag.id_white_tag = taging_reason.id_white_tag) > 0";
        $dept = Auth::user()->id_department;
        $id = Auth::user()->id;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $select = [
            "id_taging_reason","white_tag.id_white_tag","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "nama_group_champion","curriculum_champion","nama_cg","nik",
            "id_sub_group_champion","white_tag.actual as actual","cc.level",
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
                            ->join("group_champion as sc","sc.id_group_champion","cc.id_group_champion")
                            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
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
            "group_champion","training_module","nik",
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
                            ->join("group_champion as sc","sc.id_group_champion","curriculum.id_group_champion")
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
            "learning_method" => "required|string|in:0,1,2,3,4,5,6",
            "trainer" => "required|string|max:50",
            "date_plan_implementation" => "required|date_format:d-m-Y",
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
                "learning_method" => $data["learning_method"],
                "trainer" => $data["trainer"],
                "date_plan_implementation" => date("Y-m-d", strtotime($data["date_plan_implementation"])),
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
                "curriculum_champion.id_sub_group_champion as training_module_group",
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
        return Excel::download(new TaggingChampionExport($request->category,$request->all), $fileName);
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
            "curriculum_champion.id_sub_group_champion as training_module_group",
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

    //Ceme Champion
    public function indexCemeChampion(Request $request)
    {
        return view('pages.admin.champion.ceme-champion');
    }
    public function competentChampionJson(Request $request)
    {    
        $id = Auth::user()->id;
        $dp = Auth::user()->id_department;
        $cgExtraAuth = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5; 
        if(Auth::user()->id_level == 'LV-0003'){
            $competent = WhiteTagModel::select('users.*', 'dp.nama_department', 'cg.nama_cg','jt.nama_job_title')
            ->join("users",function ($join) use ($request){
                $join->on("users.id","white_tag.id_user")
                ->where([
                    ["white_tag.actual",">=","cc.target"]
                ]);
            })
            ->join("curriculum_champion_to_user as cctu","cctu.id_cctu","white_tag.id_cctu")
            ->join("curriculum_champion as cc","cc.id_curriculum_champion","cctu.id_curriculum_champion")
            ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->where('users.is_champion', 1)
            ->where('users.id_department', $dp)
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->groupBy('white_tag.id_user')
            ->get();
        }else if(Auth::user()->id_level == 'LV-0004'){
            $competent = WhiteTagModel::select('users.*', 'dp.nama_department', 'cg.nama_cg','jt.nama_job_title')
            ->join("users",function ($join) use ($request){
                $join->on("users.id","white_tag.id_user")
                ->where([
                    ["white_tag.actual",">=","cc.target"]
                ]);
            })
            ->join("curriculum_champion_to_user as cctu","cctu.id_cctu","white_tag.id_cctu")
            ->join("curriculum_champion as cc","cc.id_curriculum_champion","cctu.id_curriculum_champion")
            ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('users.is_champion', 1)
            ->where(function ($query) use ($cgExtraAuth, $cgtambah2, $cgtambah3, $cgtambah4, $cgtambah5, $id) {
                $query->Where('users.id', $id)
                ->orWhere('users.id_cg', $cgExtraAuth)
                ->orWhere('users.id_cg', $cgtambah2)
                ->orWhere('users.id_cg', $cgtambah3)
                ->orWhere('users.id_cg', $cgtambah4)
                ->orWhere('users.id_cg', $cgtambah5);
            })
            ->groupBy('white_tag.id_user')
            ->get();
        }else{
            $competent = WhiteTagModel::select('users.*', 'dp.nama_department', 'cg.nama_cg','jt.nama_job_title')
            ->join("users",function ($join) use ($request){
                $join->on("users.id","white_tag.id_user")
                ->where([
                    ["white_tag.actual",">=","cc.target"]
                ]);
            })
            ->join("curriculum_champion_to_user as cctu","cctu.id_cctu","white_tag.id_cctu")
            ->join("curriculum_champion as cc","cc.id_curriculum_champion","cctu.id_curriculum_champion")
            ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->groupBy('white_tag.id_user')
            ->get();
        }

        
            
        return Datatables::of($competent)
        ->addIndexColumn()
        ->addColumn('rata_nilai', function ($item) {
            $avg = round($item->championScore($item->id), 2);
            return $avg >= 86.67 ? '<span class="badge badge-warning">' . $avg . '%</span>' : $avg . '%';
        })
        ->rawColumns(['rata_nilai']) // Ini penting untuk merender elemen HTML
        ->make(true);      
    }

    public function chartCemeChampion(Request $request)
    {
        $ceme = request('q');
        $pie = [
            'label' => [],
            'totalScore' => []
        ];
         
        $wt=User::select(DB::raw("count(id) as total"),DB::raw("CASE WHEN is_competent_champion = '1' THEN 'Competent' ELSE 'Non-Competent' END as competency_status"))
                ->where('is_champion', 1)
                ->groupBy('is_competent_champion')
                ->get();
        $totalUsers = $wt->sum('total');
        foreach($wt as $data)
        {
            $percentage = ($data->total / $totalUsers) * 100; // Calculate the percentage
            $labelWithPercentage = $data->competency_status . ' (' . round($percentage, 2) . '%)';

            $pie['label'][] = $labelWithPercentage; // Use [] to append to the array
            $pie['totalScore'][] = $data->total;
        };

        return response()->json($pie);
    }

    public function chartMeChampion()
    {
        $ceme = request('q');
        $users = DB::table('users')
            ->where('is_superman', 1)
            ->orWhere('users.id_level', 'LV-0002')
            ->orWhere('users.id_level', 'LV-0003')
            ->orWhere('users.id_level', 'LV-0004')
            ->Join('job_title_users','job_title_users.user_id','users.id')
            ->groupBy('job_title_users.user_id')
            ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
            ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
            ->get();
        return response()->json($users);
    }

    public function cgJsonChampion(Request $request)
    {
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
        ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
        ->leftJoin('cg', 'users.id_cg', '=', 'cg.id_cg')
        ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
        ->where('is_competent',1)
        ->where(function ($query) {
            $query->where('is_superman', 1)
                ->orWhere('users.id_level', 'LV-0002')
                ->orWhere('users.id_level', 'LV-0003')
                ->orWhere('users.id_level', 'LV-0004');
        })
        ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg', 'divisi.nama_divisi']);

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {

            $datajobmultiskill = JobTitleUsers::where('user_id', $row->id)->count();

            $datajobmultiskilltglupdate = JobTitleUsers::where('user_id', $row->id)->latest('updated_at')->first();

            // var_dump($datajobmultiskilltglupdate); die;

            $btn = '<button data-id="' . $row->id . '" class="button-add btn btn-inverse-success btnAddJobTitle btn-icon mr-1" data-nama="'.$row->nama_pengguna.'" data-userid="'.$row->id.'"><i class="icon-plus menu-icon"></i></button>';
            $btn = $btn . '<button type="button" data-id="'.$row->id.'" data-name="'.$row->nama_pengguna.'" data-cg="'.$row->nama_cg.'" data-divisi="'.$row->nama_divisi.'" data-jobtitle="'.$row->nama_job_title.'" data-department="'.$row->nama_department.'" class="btn btnDetail btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';

            if($datajobmultiskill >= 1){
                $btn = $btn . '<td class="font-weight-medium"><div class="ml-1 mt-2 badge badge-success">Transfered at '.$datajobmultiskilltglupdate->updated_at.'</div></td>';
            }else{
                $btn = $btn . '<td class="font-weight-medium"><div class="ml-1 mt-2 badge badge-warning">Ready to Transfer</div></td>';
            }

            // $btn = $btn . '<button type="button" class="btn btn-warning">Warning</button>';
            return $btn;
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getGroupChampion()
    {
        $skill = GroupChampionModel::all();
        return response()->json([
            'data' => $skill,
            'status' => 200,
            'success' => true,
        ]);
    }
    public function getSubGroupChampion()
    {
        $id = request('id');
        $items = SubGroupChampionModel::where('id_group_champion',$id)->get();
        return response()->json($items);
    }
}

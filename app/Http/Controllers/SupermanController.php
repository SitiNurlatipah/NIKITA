<?php

namespace App\Http\Controllers;

use App\CurriculumSuperman;
use App\CurriculumSupermanToUser;
use App\CompDictionarySupermanModel;
use App\Department;
use App\Jabatan;
use App\Level;
use App\SkillCategoryModel;
use App\SubDepartment;
use App\Superman;
use App\User;
use App\CompetencySupermanModel;
use App\JobTitleUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\curriculumSupermanImport;
use Maatwebsite\Excel\Facades\Excel;
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
            ->orderBy('nama_pengguna', 'ASC')
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
            // 'target' => ['required'],
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
                    // $curriculum->target = $request->target;
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
            'id_user' => ['required'],
        ]);
        $curriculum = CurriculumSuperman::where("id_curriculum_superman",$request->id_curriculum_superman)->first();
        $update = [
            'id_skill_category' => $request->id_skill_category,
            'curriculum_superman' => $request->curriculum_superman,
            'curriculum_group' => $request->curriculum_group,
            'curriculum_desc' => $request->curriculum_desc,
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
    public function importCurriculum(Request $request){
        Excel::import(new curriculumSupermanImport, $request->file('file'));
        return redirect()->route('superman.index')->with('message', 'Data berhasil di-import.');
    }
    // Kelola User
    public function indexKelola(){
        return view('pages.admin.superman.index');
    }
    
    public function supermanJson(Request $request)
    {   
        $id = Auth::user()->id;
        $dp = Auth::user()->id_department;
        if(Auth::user()->id_level == 'LV-0003'){
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                    ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                    ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
                    ->Where('users.is_superman', 1)
                    ->Where('users.id_department', $dp)
                    ->orderBy('nama_pengguna', 'DESC')
                    ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','level.nama_level']);
        }else if(Auth::user()->id_level == 'LV-0004'){
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                    ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                    ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
                    ->Where('users.is_superman', 1)
                    ->Where('users.id', $id)
                    ->orderBy('nama_pengguna', 'DESC')
                    ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','level.nama_level']);
        }else{
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                    ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                    ->leftJoin('level', 'users.id_level', '=', 'level.id_level')
                    ->Where('users.id_level', 'LV-0002')
                    ->orWhere('users.id_level', 'LV-0003')
                    ->orWhere('users.id_level', 'LV-0004')
                    ->orderBy('nama_pengguna', 'DESC')
                    ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','level.nama_level']);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button data-id="' . $row->id . '" onclick="getCompSuperman('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-edit"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" onclick="detailMapcomSuperman('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                    return $btn;
                })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function formSuperman(Request $request)
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
            "curriculum_superman.no_curriculum_superman as no_curriculum", "competencies_dictionary_superman.target as target",
            "curriculum_superman.curriculum_superman as curriculum_superman","curriculum_superman.curriculum_group as curriculum_group",
            "skill_category.skill_category as skill_category","competencies_superman.start as start", "competencies_superman.actual as actual","competencies_superman.keterangan as ket",
            "competencies_dictionary_superman.id_dictionary_superman",
            // DB::raw("(SELECT COUNT(*) FROM taging_reason as tr where tr.id_competencies_superman = competencies_superman.id_competencies_superman) as cntTagingReason"),
            DB::raw("(CASE WHEN (competencies_superman.actual - competencies_dictionary_superman.target) < 0 THEN 'Open'
                            WHEN (competencies_superman.actual IS NULL) THEN 'Belum diatur'
                            WHEN competencies_superman.actual >= competencies_dictionary_superman.target THEN 'Close' 
                            END) as tagingStatus"),"compGroup.name as compGroupName"
        ];

        $comps = CompDictionarySupermanModel::select($select)
                ->join("curriculum_superman",function ($join) use ($user){
                    $join->on("curriculum_superman.id_curriculum_superman","competencies_dictionary_superman.id_curriculum_superman")
                        ->whereRaw("competencies_dictionary_superman.id_user = '".$user->id."'");
                })
                ->join("competencie_groups as compGroup","compGroup.id","curriculum_superman.curriculum_group")
                ->join("skill_category","skill_category.id_skill_category","curriculum_superman.id_skill_category")
                ->leftJoin("competencies_superman",function ($join) use ($user){
                    $join->on("competencies_superman.id_cstu","competencies_dictionary_superman.id_dictionary_superman")
                        ->where("competencies_superman.id_user",$user->id);
                })
                ->get();
                // dd($comps);
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
            // "data.*.ket" => "nullable|string",
        ]);
        DB::beginTransaction();
        try{
            $data = $this->validate_input_v2($request);
            $skillId = [1,2];
            Superman::where('id_user', $request->user_id)->where(function ($query){
                $query->whereIn('id_cstu', function ($subquery) {
                    $subquery->select('id_dictionary_superman')
                        ->from('competencies_dictionary_superman')
                        ->join('curriculum_superman', 'curriculum_superman.id_curriculum_superman', '=', 'competencies_dictionary_superman.id_curriculum_superman');
                        // ->whereIn('curriculum_superman.id_skill_category', $skillId);
                });
            })->delete();
           if(isset($data["data"]) && count($data["data"]) > 0){
                $insert = [];
                for($i=0; $i < count($data["data"]); $i++){
                    if($data["data"][$i]["start"] != "" && $data["data"][$i]["actual"] != ""){
                        $insert[$i] = [
                            "id_competencies_superman"=> $this->random_string(5,5,false).time(),
                            "id_cstu" => $data["data"][$i]["id"],
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
            return response()->json(['code' => 500, 'message' => 'Error saving data: ' . $e->getMessage()], 500);
        }
        return response()->json(['code' => 200, 'message' => 'Post successfully'], 200);
    }

    public function detailMapcomSuperman(Request $request)
    {
        $user = User::select("id","id_job_title")->where("id",$request->id)->first();
        $skillId = [1,2];
        $select = [
            "curriculum_superman.no_curriculum_superman as no_curriculum","curriculum_superman.curriculum_superman as curriculum_superman","compGroup.name as curriculum_group","competencies_dictionary_superman.target as target","skill_category.skill_category as skill_category","competencies_superman.start as start","competencies_superman.actual as actual",
            DB::raw("(CASE WHEN (competencies_superman.actual - competencies_dictionary_superman.target) < 0 THEN 'Open'
                            WHEN (competencies_superman.actual IS NULL) THEN 'Belum diatur'
                            WHEN competencies_superman.actual >= competencies_dictionary_superman.target THEN 'Close' 
                            END) as tagingStatus"),
                            "competencies_superman.keterangan as ket"
        ];
        $data = CompDictionarySupermanModel::select($select)
                ->join("curriculum_superman",function ($join) use ($user){
                    $join->on("curriculum_superman.id_curriculum_superman","competencies_dictionary_superman.id_curriculum_superman")
                        ->whereRaw("competencies_dictionary_superman.id_user = '".$user->id."'");
                })
                ->join("competencie_groups as compGroup","compGroup.id","curriculum_superman.curriculum_group")
                ->join("skill_category","skill_category.id_skill_category","curriculum_superman.id_skill_category")
                ->leftJoin("competencies_superman",function ($join) use ($user){
                    $join->on("competencies_superman.id_cstu","competencies_dictionary_superman.id_dictionary_superman")
                        ->where("competencies_superman.id_user",$user->id);
                })
                ->groupBy("curriculum_superman.id_curriculum_superman")
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

    //halaman member superman
    public function indexMember(){
        return view('pages.admin.superman.index-member');
    }

    public function supermanMemberJson()
    {
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->where('is_superman', 1)
            ->orWhere('users.id_level', 'LV-0002')
            ->orWhere('users.id_level', 'LV-0003')
            ->orWhere('users.id_level', 'LV-0004')
            ->orderBy('nama_pengguna', 'DESC')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            // $btn = '<button class="btn btn-inverse-success btn-icon mr-1" data-toggle="modal" onclick="formEdit('.$row->id.')" data-target="#modal-edit"><i class="icon-file menu-icon"></i></button>';
            $btn = '<button data-id="' . $row->id . '" class="btn btn-inverse-danger btn-icon member-hapus mr-1" data-toggle="modal" data-target="#modal-hapus"><i class="icon-trash"></i></button>';
            $btn = $btn . '<button type="button" onclick="detail('.$row->id.')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function supermanMemberStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id' => 'int',
            'id_level' => 'nullable|string',
        ]);
        
        try {
            DB::beginTransaction();
                $data = [
                    'is_superman' => 1,
                    'id_level' => $request->id_level
                ];
                User::whereIn('id',$request->id_user)->update($data); 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        return response()->json(['code' => 300, 'message' => $e], 300);

        }
        return response()->json(['code' => 200, 'message' => 'Enroll Update'], 200);
    }

    public function supermanMemberDelete($id)
    {
        $data = [
            'is_superman' => 0,
            'id_level' => 'LV-0005'
        ];
        User::where('id',$id)->update($data);  
        return redirect()->route('member.superman.index')->with(['success' => 'Member Superman Deleted successfully']);
    }

    //halaman dictionary superman
    public function jsonDataTable(Request $request)
    {
        $select = [
            "id_dictionary_superman", "cr.id_curriculum_superman", "cr.no_curriculum_superman as no_training_module", "sc.skill_category as skill_category", "cr.curriculum_superman as training_module","compGroup.name as compGroupName"
        ];
        $data = CompDictionarySupermanModel::select($select)
                                            ->join("curriculum_superman as cr",function ($join){
                                                $join->on("cr.id_curriculum_superman","competencies_dictionary_superman.id_curriculum_superman");
                                            })
                                            ->join("competencie_groups as compGroup","compGroup.id","cr.curriculum_group")
                                            ->join('skill_category as sc', 'cr.id_skill_category', '=', 'sc.id_skill_category')
                                            ->groupBy("competencies_dictionary_superman.id_curriculum_superman")
                                            ->get();
                                            // dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
            $btn = '<button class="btn btn-inverse-success btn-icon edit-directory mr-1" data-toggle="modal" data-target="#modal-tambah" data-id="' . $row->id_curriculum_superman . '" onclick="formCompetencyDirectory(this)" data-placement="top" title="Atur Target"><i class="icon-file menu-icon"></i></button>
            <button class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail" onclick="detailCompetencyDirectory(this)" data-id="' . $row->id_curriculum . '" data-placement="top" title="Lihat Target"><i class="icon-eye"></i></button>';
            
            return $btn;
                        })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function dataTableGrouping(Request $request)
    {
        $users = CompDictionarySupermanModel::select("id_curriculum_superman","id_dictionary_superman","nama_pengguna",
        DB::raw("CONCAT('{\"list\":[',GROUP_CONCAT(CONCAT('{','\"target\":\"',target,'\"','}') ORDER BY target ASC SEPARATOR ','),']}') as list"))
                                            ->join("users","users.id","competencies_dictionary_superman.id_user")
                                            ->groupBy("competencies_dictionary_superman.id_user","competencies_dictionary_superman.id_curriculum_superman")
                                            ->get();
                                            // dd($users);
        $select = [
            "no_curriculum_superman","curriculum_superman"
        ];
        $directories = CompDictionarySupermanModel::select($select)
                                                ->join("curriculum_superman as cr",function ($join) use ($request){
                                                    $join->on("cr.id_curriculum_superman","competencies_dictionary_superman.id_curriculum_superman")
                                                        ->groupBy("competencies_dictionary_superman.id_curriculum_superman","competencies_dictionary_superman.id_curriculum_superman");
                                                })
                                                ->groupBy("competencies_dictionary_superman.id_curriculum_superman")
                                                ->get();

                                // dd($directories);
    }
    public function indexDictionary()
    {
        return view('pages.admin.superman.index-dictionary');
    }
    
    public function formDictionary(Request $request)
    {
        $type = $request->type;
        $select = [
            "id_curriculum_superman", "curriculum_superman", "no_curriculum_superman", "curriculum_group"
        ];
        $competencies = CurriculumSuperman::select($select)->whereRaw("id_curriculum_superman NOT IN (select cd.id_curriculum_superman from competencies_dictionary_superman as cd group by cd.id_curriculum_superman)")->get();
        if($request->type == 'add'){
            $curriculum = null;
            $directories = [];
            $users = [];
        }else{
            $curriculum = CurriculumSuperman::where("id_curriculum_superman",$request->id)->first();
            $users = CurriculumSupermanToUser::select("curriculum_superman_to_user.id_user","users.nama_pengguna")
                                    ->join("users","users.id","curriculum_superman_to_user.id_user")
                                    ->join("curriculum_superman","curriculum_superman.id_curriculum_superman","curriculum_superman_to_user.id_curriculum_superman")
                                    ->where("curriculum_superman_to_user.id_curriculum_superman",$request->id)
                                    ->get();
            $select = [
                "competencies_dictionary_superman.id_curriculum_superman","competencies_dictionary_superman.id_user",
                DB::raw("CONCAT('{\"list\":[',GROUP_CONCAT(CONCAT('{','\"id\":\"',id_dictionary_superman,'\",','\"target\":\"',target,'\"','}') ORDER BY target ASC SEPARATOR ','),']}') AS list")

            ];
            $directories = CompDictionarySupermanModel::select($select)
                                                    ->join("curriculum_superman as cr",function ($join) use ($request){
                                                        $join->on("cr.id_curriculum_superman","competencies_dictionary_superman.id_curriculum_superman")
                                                            ->where("competencies_dictionary_superman.id_curriculum_superman",$request->id);
                                                    })
                                                    ->groupBy("competencies_dictionary_superman.id_curriculum_superman","competencies_dictionary_superman.id_user")
                                                    ->get();
        }
        return view("pages.admin.superman.form-dictionary",compact("competencies","type","users","curriculum","directories"));
    }

    public function addRow(Request $request)
    {
        $users = CurriculumSupermanToUser::select("curriculum_superman_to_user.id_user","users.nama_pengguna")
                                    ->join("users","users.id","curriculum_superman_to_user.id_user")
                                    ->join("curriculum_superman","curriculum_superman.id_curriculum_superman","curriculum_superman_to_user.id_curriculum_superman")
                                    ->where("curriculum_superman_to_user.id_curriculum_superman",$request->curriculumId)
                                    ->get();
        $time = rand(time(),2);
        return view("pages.admin.superman.tr-dictionary",compact("users","time"));
    }

    public function storeDictionarySuperman(Request $request)
    {
        $request->validate([
            "id_curriculum_superman" => "required|numeric",
            "datas" => "array",
            "datas.*.id_user" => "required|string",
            "datas.*.data" => "array",
            // "datas.*.data.*.between" => "required|numeric",
            "datas.*.data.*.target" => "required|numeric|min:0|max:5"
        ]);
        try {
            $data = $this->validate_input_v2($request);
            $directoryId = [];
            $insert = [];
            if(isset($data["datas"])){
                for ($i=0; $i < count($data["datas"]); $i++) { 
                    for ($j=0; $j < count($data["datas"][$i]["data"]); $j++) { 
                        $tempData = [
                            "id_curriculum_superman" => $data["id_curriculum_superman"],
                            "id_user" => $data["datas"][$i]["id_user"],
                            // "between_year" => $data["datas"][$i]["data"][$j]["between"],
                            "target" => $data["datas"][$i]["data"][$j]["target"]
                        ];
                        if(isset($data["datas"][$i]["data"][$j]["id_dictionary_superman"])){
                            array_push($directoryId,$data["datas"][$i]["data"][$j]["id_dictionary_superman"]);
                            CompDictionarySupermanModel::where("id_dictionary_superman",$data["datas"][$i]["data"][$j]["id_dictionary_superman"])
                                ->update($tempData);
                        }else{
                            $cek = CompDictionarySupermanModel::where([
                                ["id_curriculum_superman",$data["id_curriculum_superman"]],
                                ["id_user",$data["datas"][$i]["id_user"]]
                                ])->count();
                            if($cek == 0){
                                array_push($insert,$tempData);
                            }
                        }
                    }
                }
                if(count($directoryId) > 0){
                    CompDictionarySupermanModel::where("id_curriculum_superman",$data["id_curriculum_superman"])->whereNotIn("id_dictionary_superman",$directoryId)->delete();
                }
            }else{
                CompDictionarySupermanModel::where("id_curriculum_superman",$data["id_curriculum_superman"])->delete();
            }
            
            if(count($insert) > 0){
                CompDictionarySupermanModel::insert($insert);
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
        return response()->json(['code' => 200, 'message' => 'Post successfully'], 200);
    }

    public function indexCemeSuperman(Request $request)
    {
        return view('pages.admin.superman.ceme-superman');
    }
    public function competentEmployeeSupermanJson(Request $request)
    { 
        $dp = Auth::user()->id_department;
        $id = Auth::user()->id;

        if(Auth::user()->id_level == 'LV-0003'){
            $competent = Superman::select('users.*', 'dp.nama_department','jt.nama_job_title')
            ->join("users",function ($join) use ($request){
                $join->on("users.id","competencies_superman.id_user")
                ->where([
                    ["competencies_superman.actual",">=","cd.target"]
                ]);
            })
            ->join("competencies_dictionary_superman as cd","cd.id_dictionary_superman","competencies_superman.id_cstu")
            ->join("curriculum_superman as crclm","crclm.id_curriculum_superman","cd.id_curriculum_superman")
            ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->groupBy('competencies_superman.id_user')
            ->where('users.id_department',$dp)
            ->get();
        }else if(Auth::user()->id_level == 'LV-0004'){
            $competent = Superman::select('users.*', 'dp.nama_department','jt.nama_job_title')
            ->join("users",function ($join) use ($request){
                $join->on("users.id","competencies_superman.id_user")
                ->where([
                    ["competencies_superman.actual",">=","cd.target"]
                ]);
            })
            ->join("competencies_dictionary_superman as cd","cd.id_dictionary_superman","competencies_superman.id_cstu")
            ->join("curriculum_superman as crclm","crclm.id_curriculum_superman","cd.id_curriculum_superman")
            ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('users.id',$id)
            ->groupBy('competencies_superman.id_user')
            ->get();
        }else{
            $competent = Superman::select('users.*', 'dp.nama_department','jt.nama_job_title')
            ->join("users",function ($join) use ($request){
                $join->on("users.id","competencies_superman.id_user")
                ->where([
                    ["competencies_superman.actual",">=","cd.target"]
                ]);
            })
            ->join("competencies_dictionary_superman as cd","cd.id_dictionary_superman","competencies_superman.id_cstu")
            ->join("curriculum_superman as crclm","crclm.id_curriculum_superman","cd.id_curriculum_superman")
            ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->groupBy('competencies_superman.id_user')
            ->get();
        }
            
            
        return Datatables::of($competent)
        ->addIndexColumn()
        ->addColumn('rata_rata', function ($item) {
            $avg = round($item->totalScore($item->id), 2);
            return $avg >= 86.67 ? '<span class="badge badge-warning">' . $avg . '%</span>' : $avg . '%';
        })
        ->rawColumns(['rata_rata']) // Ini penting untuk merender elemen HTML
        ->make(true);      
    }

    public function chartCemeSuperman(Request $request)
    {
        $ceme = request('q');
        $pie = [
            'label' => [],
            'totalScore' => []
        ];
         
        $wt=User::select(DB::raw("count(id) as total"),DB::raw("CASE WHEN is_competent = '1' THEN 'Competent' ELSE 'Non-Competent' END as competency_status"))
                ->where('is_superman', 1)
                ->orWhere('users.id_level', 'LV-0002')
                ->orWhere('users.id_level', 'LV-0003')
                ->orWhere('users.id_level', 'LV-0004')
                ->groupBy('is_competent')
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

    public function chartMeSuperman()
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

    public function cgJsonSuperman(Request $request)
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
}

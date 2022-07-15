<?php

namespace App\Http\Controllers;

use App\CemeModel;
use App\JobTitleUsers;
use App\User;
use App\WhiteTagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class Ceme extends Controller
{
    public function index(Request $request)
    {
        $q= request('q');
        if($q === 'all')
        {
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')->get();
        }else{
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
                ->where('id_cg',auth()->user()->id_cg)
                ->groupBy('id_user')->get();
        }
        $pie = [
            'label' => [],
            'totalScore' => []
        ];
        foreach($wt as $data)
        {
            array_push($pie['label'],$data->nama_pengguna);
            array_push($pie['totalScore'],round($data->totalScore($data->id),2));
        };
        return view('pages.admin.ceme',[
            'q' => $q,
            'wt' => $wt,
            'pie' => $pie
        ]);
    }

    public function chartCeme(Request $request)
    {
        $ceme = request('q');
        $pie = [
            'label' => [],
            'totalScore' => []
        ];
        $cgAuth = Auth::user()->id_cg;
        if($ceme === 'all')
        {
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')->get();
        }else{
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join('cg', function ($join) use ($cgAuth) {
                    $join->on('users.id_cg', 'cg.id_cg')
                    ->where('users.id_cg', $cgAuth);
                })
                ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')->get();
        }
        foreach($wt as $data)
        {
            array_push($pie['label'],$data->nama_pengguna);
            array_push($pie['totalScore'],round($data->totalScore($data->id),2));
        };

        return response()->json($pie);
    }

    public function chartMe()
    {
        $ceme = request('ceme');

        if($ceme === 'all')
        {
            $users = DB::table('users')->where('is_competent',1)
            ->leftJoin('job_title_users','job_title_users.user_id','users.id')
            ->groupBy('job_title_users.user_id')
            ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
            ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
            ->get();

        }else{
            $users = DB::table('users')->where('is_competent',1)
            ->leftJoin('job_title_users','job_title_users.user_id','users.id')
            ->groupBy('job_title_users.user_id')
            ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
            ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
            ->where('id_cg',auth()->user()->id_cg)
            ->get();
        }
        return response()->json($users);
    }

    public function cgJson(Request $request)
    {
        $cgAuth = Auth::user()->id_cg;
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
        ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
        ->join('cg', function ($join) use ($cgAuth) {
            $join->on('users.id_cg', 'cg.id_cg')
            ->where('users.id_cg', $cgAuth);
        })
            ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
            ->where('is_competent',1)
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg', 'divisi.nama_divisi']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button data-id="' . $row->id . '" class="button-add btn btn-inverse-success btnAddJobTitle btn-icon mr-1" data-nama="'.$row->nama_pengguna.'" data-userid="'.$row->id.'"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" data-id="'.$row->id.'" data-name="'.$row->nama_pengguna.'" data-cg="'.$row->nama_cg.'" data-divisi="'.$row->nama_divisi.'" data-jobtitle="'.$row->nama_job_title.'" data-department="'.$row->nama_department.'" class="btn btnDetail btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function cgJsonAll(Request $request)
    {
        $cgAuth = Auth::user()->id_cg;
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
        ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
            ->leftJoin('cg','users.id_cg','=', 'cg.id_cg')
            ->where('is_competent',1)
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg', 'divisi.nama_divisi']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button data-id="' . $row->id . '" class="button-add btn btn-inverse-success btnAddJobTitle btn-icon mr-1" data-nama="'.$row->nama_pengguna.'" data-userid="'.$row->id.'"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" data-id="'.$row->id.'" data-name="'.$row->nama_pengguna.'" data-cg="'.$row->nama_cg.'" data-divisi="'.$row->nama_divisi.'" data-jobtitle="'.$row->nama_job_title.'" data-department="'.$row->nama_department.'" class="btn btnDetail btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function actionCeme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "on_the_job_training" => "nullable|numeric",
            "temporary_back_up" => "nullable|numeric",
            "full_back_up" => "nullable|numeric",
            "main_back_up" => "nullable|numeric",
            "result_multiskill" => "nullable|numeric",
            "job_title_id" => "nullable|numeric",
        ]);

        if ($validator->fails()) {
            dd($validator->errors());
        } else {
            DB::beginTransaction();
            try {
                if (isset($request->data)) {
                    $insert = [];
                    for ($i = 0; $i < count($request->data); $i++) {
                        $insert[$i] = [
                            "id_ceme" => $this->random_string(5, 5, false) . time(),
                            "id_user" => $request->user_id,
                            "on_the_job_training" => $request->data[$i]["id"],
                            "temporary_back_up" => $request->data[$i]["start"],
                            "full_back_up" => $request->data[$i]["actual"],
                            "result_multiskill" => $request->data[$i]["actual"],
                            "id_job_title" => $request->data[$i]["actual"]
                        ];
                    }
                    CemeModel::insert($insert);
                }
                $messages = [
                    "type" => "success",
                    "message" => "Berhasil mengubah CEME tag!"
                ];
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
                $messages = [
                    "type" => "error",
                    "message" => "Terjadi kesalahan dalam penyimpanan data"
                ];
            }
            return redirect()
                ->route('WhiteTag')
                ->with($messages["type"], $messages["message"]);
        }
    }

    // public function index()
    // {
    //     $data = CemeModel::leftJoin('skill_category as sc', 'ceme.id_skill_category', '=', 'sc.id_skill_category')
    //     ->leftJoin('job_title as jt', 'ceme.id_job_title', '=', 'jt.id_job_title')
    //     ->get(['ceme.*', 'jt.nama_job_title', 'sc.skill_category']);
    //     return view('pages.admin.ceme.index', compact('data'));
    // }

    public function getFormEditceme(Request $request)
    {
        $ceme = CemeModel::where("id_ceme", $request->id)->first();
        $skills = SkillCategory::all();
        $jabatans = Jabatan::all();
        return view("pages.admin.ceme.form", compact("ceme", "skills", "jabatans"));
    }

    public function editCeme(Request $request)
    {
        $request->validate([
            "on_the_job_training" => "nullable|numeric",
            "temporary_back_up" => "nullable|numeric",
            "full_back_up" => "nullable|numeric",
            "main_back_up" => "nullable|numeric",
            "result_multiskill" => "nullable|numeric",
            "job_title_id" => "nullable|numeric",
        ]);
        $post = CemeModel::updateOrCreate(['id_ceme' => $request->id_ceme], [
            "id_ceme" => $this->random_string(5, 5, false) . time(),
            "id_user" => $request->user_id,
            "on_the_job_training" => $request->on_the_job_training,
            "temporary_back_up" => $request->temporary_back_up,
            "full_back_up" => $request->full_back_up,
            "result_multiskill" => $request->result_multiskill,
            "id_job_title" => $request->id_job_title
        ]);

        return response()->json(['code' => 200, 'message' => 'Post Created successfully', 'data' => $post], 200);
    }

    public function show($id)
    {
        $post = CemeModel::find($id);
        return response()->json($post);
    }
    public function delete($id)
    {
        $post = CemeModel::where('id_ceme', $id)->delete();
        return redirect()->route('ceme')->with(['success' => 'ceme Deleted successfully']);
    }

    public function getSkill()
    {
        $skill = SkillCategory::all();
        return response()->json([
            'data' => $skill,
            'status' => 200,
            'success' => true,
        ]);
    }

    public function addJobTitle()
    {
        $id  = request('id');
        if($id)
        {
            $validator = Validator::make(request()->all(),[
                'id' => ['required'],
                'job_title_edit' => ['required'],
                'level_edit' => ['required','numeric']
            ]);
        }else{
            $validator = Validator::make(request()->all(),[
                'user_id' => ['required'],
                'job_title' => ['required'],
                'level' => ['required','numeric']
            ]);
        }

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $userCheck = JobTitleUsers::where('user_id',request('user_id'))->where('job_title_id',request('job_title'))->count();
        if($userCheck > 0)
        {
            $data = [
                'status' => 'error',
                'message' => 'Job title is already exist in user',
                'data' => NULL
            ];
        }else{
            if($id)
            {
                $jt = JobTitleUsers::find($id);
                $jt2 = $jt->update([
                    'job_title_id' => request('job_title_edit'),
                    'value' => request('level_edit')
                ]);
                $data = [
                    'status' => 'success',
                    'message' => 'Job title from User Updated Successfully',
                    'data' => $jt
                ];
            }else{

                $jt = JobTitleUsers::create([
                    'user_id' => request('user_id'),
                    'job_title_id' => request('job_title'),
                    'value' => request('level')
                ]);
                $data = [
                    'status' => 'success',
                    'message' => 'Job Title Added To User Successfully',
                    'data' => $jt
                ];
            }
        }

        return response()->json($data);
    }

    public function getJobTitle()
    {
        $jt = JobTitleUsers::with('jobTitle')->where('user_id',request('id'))->get();
        $data = [
            'status' => 'success',
            'message' => 'Get Job title from users',
            'data' => $jt
        ];

        return response()->json($data);
    }

    public function deleteJobTitle()
    {
        $id = request('id');
        $jt = JobTitleUsers::findOrFail($id);
        $data = [
            'status' => 'success',
            'message' => 'Job Title Deleted Successfully',
            'data' => $jt
        ];
        $jt->delete();

        return response()->json($data);
    }
}

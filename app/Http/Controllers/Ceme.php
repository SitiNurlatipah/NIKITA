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
        $cg = Auth::user()->id_cg;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
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
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')
                ->get();
        }else{
            if(Auth::user()->id_level == 'LV-0003'){
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->where('users.id_department', $dp)
                ->groupBy('id_user')
                ->get();
            } else if(Auth::user()->id_level == 'LV-0004'){
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->where('users.id', $id)
                ->orWhere('users.id_cg', $cgtambah)
                ->orWhere('users.id_cg', $cgtambah2)
                ->orWhere('users.id_cg', $cgtambah3)
                ->orWhere('users.id_cg', $cgtambah4)
                ->orWhere('users.id_cg', $cgtambah5)
                ->groupBy('id_user')
                ->get();
            } else if(Auth::user()->peran_pengguna == 1){
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')
                ->get();
            } else {
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->where('id_cg', $cg)
                ->groupBy('id_user')
                ->get();
            }
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
    public function competentEmployeeJson(Request $request)
    {
        $cg = Auth::user()->id_cg;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
        $q= request('q');
        
            if(Auth::user()->id_level == 'LV-0003'){
            $competent = WhiteTagModel::select('users.*', 'dp.nama_department', 'cg.nama_cg')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->where('users.id_department', $dp)
                ->groupBy('id_user')
                ->get();
            } else if(Auth::user()->id_level == 'LV-0004'){
            $competent = WhiteTagModel::select('users.*', 'dp.nama_department', 'cg.nama_cg')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->where('users.id', $id)
                ->orWhere('users.id_cg', $cgtambah)
                ->orWhere('users.id_cg', $cgtambah2)
                ->orWhere('users.id_cg', $cgtambah3)
                ->orWhere('users.id_cg', $cgtambah4)
                ->orWhere('users.id_cg', $cgtambah5)
                ->groupBy('id_user')
                ->get();
            } else if(Auth::user()->peran_pengguna == 1){
            $competent = WhiteTagModel::select('users.*', 'dp.nama_department', 'cg.nama_cg')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->groupBy('id_user')
                ->get();
            } else {
            $competent = WhiteTagModel::select('users.*', 'dp.nama_department','cg.nama_cg')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->where('users.id_cg', $cg)
                ->groupBy('id_user')
                ->get();
            }
        
        return Datatables::of($competent)
        ->addIndexColumn()
        ->addColumn('score_b', function ($item) {
            return round($item->score($item->id, 'B'), 2) . '%';
        })
        ->addColumn('score_i', function ($item) {
            return round($item->score($item->id, 'I'), 2) . '%';
        })
        ->addColumn('score_a', function ($item) {
            return round($item->score($item->id, 'A'), 2) . '%';
        })
        ->addColumn('rata_rata', function ($item) {
            $avg = round($item->totalScore($item->id), 2);
            return $avg >= 86.67 ? '<span class="badge badge-warning">' . $avg . '%</span>' : $avg . '%';
        })
        ->rawColumns(['rata_rata']) // Ini penting untuk merender elemen HTML
        ->make(true);      
    }
    public function expertiseJson(){
        $expertise = WhiteTagModel::select('users.nik','users.nama_pengguna', 'dp.nama_department', 'cg.nama_cg','crclm.training_module')
                ->join("users",function ($join){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual","=",4]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->join('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->join('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->where('crclm.id_skill_category', '=', 1)
                ->where('dp.nama_department', '=', 'ENG')
                ->groupBy('id_white_tag')
                ->get();
        return Datatables::of($expertise)
        ->addIndexColumn()
        ->make(true);         
    }

    public function chart(Request $request)
    {
        $ceme = request('q');
        $pie = [
            'label' => [],
            'totalScore' => []
        ];
        $cgAuth = Auth::user()->id_cg;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
        if($ceme === 'all')
        {
            $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')->get();
        }else{
            if (Auth::user()->id_level == 'LV-0003') {
                $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join('department', function ($join) use ($dp) {
                    $join->on('users.id_department', 'department.id_department')
                    ->where('users.id_department', $dp);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')->get();
            }else if (Auth::user()->id_level == 'LV-0004') {
                $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join('cg', function ($join) use ($id,$cgAuth, $cgtambah,$cgtambah2,$cgtambah3,$cgtambah4,$cgtambah5) {
                    $join->on('users.id_cg', 'cg.id_cg')
                    ->Where('users.id', $id)
                    ->orWhere('users.id_cg', $cgtambah)
                    ->orWhere('users.id_cg', $cgtambah2)
                    ->orWhere('users.id_cg', $cgtambah3)
                    ->orWhere('users.id_cg', $cgtambah4)
                    ->orWhere('users.id_cg', $cgtambah5);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')->get();
            }else if (Auth::user()->peran_pengguna == 1) {
                $wt = WhiteTagModel::select('users.*')
                ->join("users",function ($join) use ($request){
                    $join->on("users.id","white_tag.id_user")
                    ->where([
                        ["white_tag.actual",">=","cd.target"]
                    ]);
                })
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
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
                ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                ->join("competencies_directory as cd","crclm.id_curriculum","cd.id_curriculum")
                ->groupBy('id_user')->get();
            }
            
        }
        foreach($wt as $data)
        {
            array_push($pie['label'],$data->nama_pengguna);
            array_push($pie['totalScore'],round($data->totalScore($data->id),2));
        };

        return response()->json($pie);
    }
    public function chartCeme(Request $request)
    {
        $ceme = request('q');
        $pie = [
            'label' => [],
            'totalScore' => []
        ];
         
        $wt=User::select(DB::raw("count(id) as total"),DB::raw("CASE WHEN is_competent = '1' THEN 'Competent' ELSE 'Non-Competent' END as competency_status"))->groupBy('is_competent')->get();
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

    public function chartMe()
    {
        $ceme = request('ceme');
        $cgAuth = Auth::user()->id_cg;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
        if($ceme === 'all')
        {
            $users = DB::table('users')->where('is_competent',1)
            ->Join('job_title_users','job_title_users.user_id','users.id')
            ->groupBy('job_title_users.user_id')
            ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
            ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
            ->get();

        }else{
            if (Auth::user()->id_level == 'LV-0003') {
            $users = DB::table('users')->where('is_competent',1)
                ->Join('job_title_users','job_title_users.user_id','users.id')
                ->groupBy('job_title_users.user_id')
                ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
                ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
                ->where('users.id_department', $dp)
                ->get();
            }else if (Auth::user()->id_level == 'LV-0004') {
            $users = DB::table('users')->where('is_competent',1)
                ->Join('job_title_users','job_title_users.user_id','users.id')
                ->groupBy('job_title_users.user_id')
                ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
                ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
                ->where('users.id', $id)
                ->orWhere('users.id_cg', $cgtambah)
                ->orWhere('users.id_cg', $cgtambah2)
                ->orWhere('users.id_cg', $cgtambah3)
                ->orWhere('users.id_cg', $cgtambah4)
                ->orWhere('users.id_cg', $cgtambah5)
                ->get();
            }else if(Auth::user()->peran_pengguna == 1){
            $users = DB::table('users')->where('is_competent',1)
                ->Join('job_title_users','job_title_users.user_id','users.id')
                ->groupBy('job_title_users.user_id')
                ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
                ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
                ->get();
            }else{
            $users = DB::table('users')->where('is_competent',1)
                ->Join('job_title_users','job_title_users.user_id','users.id')
                ->groupBy('job_title_users.user_id')
                ->select('users.nama_pengguna',DB::raw('count(job_title_users.user_id) as totalSkill'))
                ->groupBy(DB::Raw('IFNULL( job_title_users.user_id , 0 )'))
                ->where('id_cg',auth()->user()->id_cg)
                ->get();
            }
        }
        return response()->json($users);
    }

    public function cgJson(Request $request)
    {
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $cgAuth = Auth::user()->id_cg;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
        if(Auth::user()->id_level == 'LV-0004'){
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('cg', 'users.id_cg', '=', 'cg.id_cg')
            ->where('is_competent',1)
            ->where(function ($query) use ($cgtambah, $cgtambah2, $cgtambah3, $cgtambah4, $cgtambah5, $id) {
                $query->where('users.id', $id)
                    ->orWhere('users.id_cg', $cgtambah)
                    ->orWhere('users.id_cg', $cgtambah2)
                    ->orWhere('users.id_cg', $cgtambah3)
                    ->orWhere('users.id_cg', $cgtambah4)
                    ->orWhere('users.id_cg', $cgtambah5);
            })
            ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg', 'divisi.nama_divisi']);

        } else if(Auth::user()->id_level == 'LV-0003'){
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->leftJoin('cg', 'users.id_cg', '=', 'cg.id_cg')
                ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
                ->where('is_competent',1)
                ->where('users.id_department', $dp)
                ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg', 'divisi.nama_divisi']);
        } else if(Auth::user()->peran_pengguna == 1){
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->leftJoin('cg', 'users.id_cg', '=', 'cg.id_cg')
                ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
                ->where('is_competent',1)
                // ->where('users.id_department', $dp)
                ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg', 'divisi.nama_divisi']);
    
        }else{
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->join('cg', function ($join) use ($cgAuth) {
                $join->on('users.id_cg', 'cg.id_cg')
                ->where('users.id_cg', $cgAuth);
            })
                ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
                ->where('is_competent',1)
                ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg', 'divisi.nama_divisi']);
    
        }
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
                'level_edit' => ['required','numeric'],
                'transfer_period_edit' => ['required']
            ]);
        }else{
            $validator = Validator::make(request()->all(),[
                'user_id' => ['required'],
                'job_title' => ['required'],
                'level' => ['required','numeric'],
                'transfer_period' => ['required','numeric']
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
                    'value' => request('level_edit'),
                    'transfer_period' => request('transfer_period_edit')
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
                    'value' => request('level'),
                    'transfer_period' => request('transfer_period')
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

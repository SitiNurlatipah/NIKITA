<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rotation;
use App\Target;
use App\WhiteTagHistory;

class RotationController extends Controller
{
    public function index()
    {
        $cg_new = Rotation::leftjoin('cg', 'rotation_history.cg_new' , '=', 'cg.id_cg');
        $role = Auth::user()->peran_pengguna;
        $dp= Auth::user()->id_department;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        if (Auth::user()->peran_pengguna === '2') {
            $cgId = Auth::user()->id_cg;
            $history = Rotation::
                    leftJoin('users', 'rotation_history.id_user', '=', 'users.id')
                    ->leftjoin('cg', 'rotation_history.cg_old' , '=', 'cg.id_cg')
                    ->leftJoin('cg as cg2', 'rotation_history.cg_new', '=', 'cg2.id_cg')
                    ->leftjoin('job_title', 'rotation_history.job_title_old' , '=', 'job_title.id_job_title')
                    ->leftJoin('job_title as jt2', 'rotation_history.job_title_new', '=', 'jt2.id_job_title')
                    ->orderBy('date','DESC')
                    ->where('rotation_history.cg_new', $cgId)
                    ->orWhere('rotation_history.cg_old', $cgId)
                    ->get(['users.nama_pengguna', 'cg.nama_cg as cg_out' , 'cg2.nama_cg as cg_in', 'job_title.nama_job_title as jt_out', 'jt2.nama_job_title as jt_in', 'date']);    
        }else if(Auth::user()->id_level == 'LV-0003'){
            $history = Rotation::
                    leftJoin('users', 'rotation_history.id_user', '=', 'users.id')
                    ->leftjoin('cg', 'rotation_history.cg_old' , '=', 'cg.id_cg')
                    ->leftJoin('cg as cg2', 'rotation_history.cg_new', '=', 'cg2.id_cg')
                    ->leftjoin('job_title', 'rotation_history.job_title_old' , '=', 'job_title.id_job_title')
                    ->leftJoin('job_title as jt2', 'rotation_history.job_title_new', '=', 'jt2.id_job_title')
                    ->leftJoin('department as dept_old', 'cg.id_department', '=', 'dept_old.id_department')
                    ->leftJoin('department as dept_new', 'cg2.id_department', '=', 'dept_new.id_department')
                    ->where('dept_old.id_department', $dp)
                    ->orWhere('dept_new.id_department', $dp)
                    ->orderBy('date','DESC')
                    ->get(['users.nama_pengguna', 'cg.nama_cg as cg_out' , 'cg2.nama_cg as cg_in', 'job_title.nama_job_title as jt_out', 'jt2.nama_job_title as jt_in', 'date']);
        }else if(Auth::user()->id_level == 'LV-0004'){
            $history = Rotation::
                    leftJoin('users', 'rotation_history.id_user', '=', 'users.id')
                    ->leftjoin('cg', 'rotation_history.cg_old' , '=', 'cg.id_cg')
                    ->leftJoin('cg as cg2', 'rotation_history.cg_new', '=', 'cg2.id_cg')
                    ->leftjoin('job_title', 'rotation_history.job_title_old' , '=', 'job_title.id_job_title')
                    ->leftJoin('job_title as jt2', 'rotation_history.job_title_new', '=', 'jt2.id_job_title')
                    ->whereIn('cg.id_cg', [$cgtambah,$cgtambah2,$cgtambah3,$cgtambah4,$cgtambah5])
                    ->orWhereIn('cg2.id_cg', [$cgtambah,$cgtambah2,$cgtambah3,$cgtambah4,$cgtambah5])
                    ->orderBy('date','DESC')
                    ->get(['users.nama_pengguna', 'cg.nama_cg as cg_out' , 'cg2.nama_cg as cg_in', 'job_title.nama_job_title as jt_out', 'jt2.nama_job_title as jt_in', 'date']);
        }else{
            $history = Rotation::
                    leftJoin('users', 'rotation_history.id_user', '=', 'users.id')
                    ->leftjoin('cg', 'rotation_history.cg_old' , '=', 'cg.id_cg')
                    ->leftJoin('cg as cg2', 'rotation_history.cg_new', '=', 'cg2.id_cg')
                    ->leftjoin('job_title', 'rotation_history.job_title_old' , '=', 'job_title.id_job_title')
                    ->leftJoin('job_title as jt2', 'rotation_history.job_title_new', '=', 'jt2.id_job_title')
                    ->orderBy('date','DESC')
                    ->get(['users.nama_pengguna', 'cg.nama_cg as cg_out' , 'cg2.nama_cg as cg_in', 'job_title.nama_job_title as jt_out', 'jt2.nama_job_title as jt_in', 'date']);
        }
        // dd($history);
        return view('pages.admin.rotation.index', compact('history'));
    }

    public function indexHistory()
    {
        $cgId = Auth::user()->id_cg;
        if (Auth::user()->peran_pengguna === '2') {
            $history = WhiteTagHistory::leftJoin('users', 'white_tag_history.id_user', '=', 'users.id')
                    ->leftJoin('cg','users.id_cg', '=', 'cg.id_cg')
                    ->where('users.id_cg', $cgId)
                    ->orderBy('id_user','ASC')
                    ->get();
        }else{
            $history = WhiteTagHistory::
            orderBy('id_user','ASC')->get();
        }
        

        return view('pages.admin.rotation.competency-history', compact('history'));
    }

}

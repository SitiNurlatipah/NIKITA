<?php

namespace App\Http\Controllers;

use App\CG;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index()
    {

        $total_cg = DB::table('users')
        ->select(array(DB::raw('COUNT(id_cg) as cg')))
        ->get();

        $total_cg_name = DB::table('cg')
        ->select(array(DB::raw('COUNT(nama_cg) as cg')))
        ->get();

        $jml_cg = DB::table('users')
        ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
        // ->select(array('id_cg', DB::raw('COUNT(id_cg) as cg')))
        ->whereNotNull('users.id_cg')
            ->orderBy('cg', 'DESC')
        ->groupBy('users.id_cg')
        ->get(array('users.id_cg', 'nama_cg', DB::raw('COUNT(users.id_cg) as cg')));


        $email = Auth::user()->email;
        $cg = Auth::user()->id_cg;

        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->whereEmail($email)->first(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg']);

        $jumlah = DB::table('users')
            ->select(array('users.*', DB::raw('COUNT(id_cg) as cg')))
            ->where('id_cg', '=', $cg)
            ->groupBy('id_cg')
            ->get();

        $rotate_out = DB::table('rotation_history')
            ->select(array(DB::raw('COUNT(cg_old) as cg_out')))
            ->where('cg_old', $cg)
            ->get();

        $rotate_in = DB::table('rotation_history')
            ->select(array(DB::raw('COUNT(cg_new) as cg_in')))
            ->where('cg_new', $cg)
            ->get();

        $cg = Auth::user()->id_cg;
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
        // $id = Auth::user()->is_superman;
        if(Auth::user()->peran_pengguna == '2'){
            $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('id_cg', $cg)
            // ->orderBy('nik', 'ASC')
            ->get(['users.*', 'dp.*', 'jt.*']);
        }else if(Auth::user()->peran_pengguna == '1'){
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('id_cg', $cg)
                // ->orderBy('nik', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
        }else if(Auth::user()->id_level == 'LV-0003')//LV-0003=dept. head
        {
            $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('users.id_department', $dp)
            // ->orderBy('nik', 'ASC')
            ->get(['users.*', 'dp.*', 'jt.*']);
        }else if(Auth::user()->id_level == 'LV-0004')//LV-0004=spv
        {
            $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('id', $id)
            ->orWhere('id_cg', $cgtambah)
            ->orWhere('id_cg', $cgtambah2)
            ->orWhere('id_cg', $cgtambah3)
            ->orWhere('id_cg', $cgtambah4)
            ->orWhere('id_cg', $cgtambah5)
            // ->orderBy('id_level', 'ASC')
            ->orderBy('nama_pengguna', 'ASC')
            ->get(['users.*', 'dp.*', 'jt.*']);
        }else {
            $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('id', $id)
            ->orderBy('nik', 'ASC')
            ->get(['users.*', 'dp.*', 'jt.*']);
        }

        return view('pages.admin.dashboard', compact(
            'data',
            'jumlah',
            'members',
            'jml_cg',
            'total_cg',
            'total_cg_name',
            'rotate_out',
            'rotate_in'
        ));
    }

    public function card_profile()
    {
        $cg = Auth::user()->id_cg;

        $profile = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->where('id_cg', $cg)
            ->orderBy('nik', 'DESC')
        ->get(['users.*', 'dp.*', 'jt.*']);
        return response()->json([
            'data' => $profile,
            'status' => 200,
            'success' => true,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\CG;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index(Request $request)
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
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->whereEmail($email)->first(['users.*', 'dp.nama_department', 'jt.nama_job_title', 'cg.nama_cg']);
        
        if (Auth::user()->id_level == 'LV-0003') {
            $jumlah = DB::table('users')
            ->select(array('users.*', DB::raw('COUNT(users.nik) as cg')))
                    ->where('users.id_department', '=', $dp)
                    ->groupBy('id_department')
                    ->get();
        }
        else if (Auth::user()->id_level == 'LV-0004') {
            $jumlah = DB::table('users')
                ->select(array('users.*', DB::raw('COUNT(users.nik) as cg')))
                ->where(function ($query) use ($id) {
                    $query->where('id', $id)
                        ->groupBy('users.id_cg');
                })
                ->orWhere(function ($query) use ($cgtambah) {
                    $query->where('users.id_cg', $cgtambah)
                        ->groupBy('users.id_cg');
                })
                ->orWhere(function ($query) use ($cgtambah2) {
                    $query->where('users.id_cg', $cgtambah2)
                        ->groupBy('users.id_cg');
                })
                ->orWhere(function ($query) use ($cgtambah3) {
                    $query->where('users.id_cg', $cgtambah3)
                        ->groupBy('users.id_cg');
                })
                ->orWhere(function ($query) use ($cgtambah4) {
                    $query->where('users.id_cg', $cgtambah4)
                        ->groupBy('users.id_cg');
                })
                ->orWhere(function ($query) use ($cgtambah5) {
                    $query->where('users.id_cg', $cgtambah5)
                        ->groupBy('users.id_cg');
                })
                // Lanjutkan untuk kondisi lainnya
                ->get();            
        } else{
            $jumlah = DB::table('users')
            ->select(array('users.*', DB::raw('COUNT(id_cg) as cg')))
            ->where('id_cg', '=', $cg)
            ->groupBy('id_cg')
            ->get();
        }
        // dd($jumlah);
        // $jumlah = DB::table('users')
        //     ->select(array('users.*', DB::raw('COUNT(id_cg) as cg')))
        //     ->where('id_cg', '=', $cg)
        //     ->groupBy('id_cg')
        //     ->get();

        $rotate_out = DB::table('rotation_history')
            ->select(array(DB::raw('COUNT(cg_old) as cg_out')))
            ->where('cg_old', $cg)
            ->get();

        $rotate_in = DB::table('rotation_history')
            ->select(array(DB::raw('COUNT(cg_new) as cg_in')))
            ->where('cg_new', $cg)
            ->get();

        
        $name = $request->search;
        // $id = Auth::user()->is_superman;
        if($request->has('search') && !empty($request->search)){
            if(Auth::user()->peran_pengguna == '2'){
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('nama_pengguna','like','%'.$name.'%')
                ->where('id_cg', $cg)
                ->orderBy('nama_pengguna', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }else if(Auth::user()->peran_pengguna == '1'){
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('nama_pengguna','like','%'.$name.'%')
                ->where('id_cg', $cg)
                ->orderBy('nama_pengguna', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }else if(Auth::user()->id_level == 'LV-0003')//LV-0003=dept. head
            {
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('nama_pengguna','like','%'.$name.'%')
                ->where('users.id_department', $dp)
                ->orderBy('nama_pengguna', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }else if(Auth::user()->id_level == 'LV-0004')//LV-0004=spv
            {
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                // ->where('id', $id)
                ->orwhere(function ($query) use ($cgtambah, $cgtambah2, $cgtambah3, $cgtambah4, $cgtambah5, $id) {
                    $query->orwhere('id_cg', $cgtambah)
                        ->orWhere('id_cg', $cgtambah2)
                        ->orWhere('id_cg', $cgtambah3)
                        ->orWhere('id_cg', $cgtambah4)
                        ->orWhere('id_cg', $cgtambah5)
                        ->orWhere('id', $id);
                })
                ->where('nama_pengguna', 'like', '%' . $name . '%')
                ->orderBy('nama_pengguna', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }else {
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('id', $id)
                ->orderBy('nik', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }
        }else{
            if(Auth::user()->peran_pengguna == '2'){
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('id_cg', $cg)
                ->orderBy('nama_pengguna', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }else if(Auth::user()->peran_pengguna == '1'){
                    $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                    ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                    ->where('id_cg', $cg)
                    ->orderBy('nama_pengguna', 'ASC')
                    ->get(['users.*', 'dp.*', 'jt.*']);
            }else if(Auth::user()->id_level == 'LV-0003')//LV-0003=dept. head
            {
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('users.id_department', $dp)
                ->orderBy('nama_pengguna', 'ASC')
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
                ->orderBy('nama_pengguna', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }else {
                $members = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->where('id', $id)
                ->orderBy('nik', 'ASC')
                ->get(['users.*', 'dp.*', 'jt.*']);
            }
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

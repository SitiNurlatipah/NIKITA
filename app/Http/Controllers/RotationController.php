<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rotation;
use App\Target;
use App\WhiteTagHistory;

class RotationController extends Controller
{
    public function index()
    {
        $cg_new = Rotation::leftjoin('cg', 'rotation_history.cg_new' , '=', 'cg.id_cg');
        $history = Rotation::
        leftJoin('users', 'rotation_history.id_user', '=', 'users.id')
        ->leftjoin('cg', 'rotation_history.cg_old' , '=', 'cg.id_cg')
        ->leftJoin('cg as cg2', 'rotation_history.cg_new', '=', 'cg2.id_cg')
        ->orderBy('id_user','ASC')->get(['users.nama_pengguna', 'cg.nama_cg as cg_out' , 'cg2.nama_cg as cg_in', 'date']);
        // dd($history);
        return view('pages.admin.rotation.index', compact('history'));
    }

    public function indexHistory()
    {
        $history = WhiteTagHistory::
        // leftJoin('users', 'rotation_history.id_user', '=', 'users.id')
        // ->leftjoin('cg', 'rotation_history.cg_old' , '=', 'cg.id_cg')
        // ->leftJoin('cg', 'rotation_history.cg_new', '=', 'cg.id_cg')
        orderBy('id_user','ASC')->get();

        return view('pages.admin.rotation.competency-history', compact('history'));
    }

}

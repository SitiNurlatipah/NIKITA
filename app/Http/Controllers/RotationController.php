<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rotation;
use App\Target;

class RotationController extends Controller
{
    public function index()
    {
        $history = Rotation::
        leftJoin('users', 'rotation_history.id_user', '=', 'users.id')
        ->leftjoin('cg', 'rotation_history.cg_old' , '=', 'cg.id_cg')
        // ->leftJoin('cg', 'rotation_history.cg_new', '=', 'cg.id_cg')
        ->orderBy('id_user','ASC')->get(['users.nama_pengguna', 'cg.nama_cg', 'rotation_history.cg_old', 'date']);

        return view('pages.admin.rotation.index', compact('history'));
    }

}

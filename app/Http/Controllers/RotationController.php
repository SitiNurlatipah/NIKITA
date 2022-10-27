<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rotation;

class RotationController extends Controller
{
    public function index()
    {
        // $items = Rotation::with('jobtitle')->orderBy('name','ASC')->get();
        return view('pages.admin.rotation.index');
    }

}

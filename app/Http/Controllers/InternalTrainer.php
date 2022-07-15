<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalTrainer extends Controller
{
    public function index()
    {
        return view('pages.admin.ceme');
    }
}

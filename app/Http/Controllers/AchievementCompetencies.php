<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AchievementCompetencies extends Controller
{
    public function index()
    {
        return view('pages.admin.achievement-competencies');
    }
}

<?php

namespace App\Http\Controllers;
use App\CurriculumActivityLog;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CurriculumActivityLogController extends Controller
{
    public function index()
    {
        return view('pages.admin.curriculum-log-activity.index');
    }
    public function json()
    {
        $data = CurriculumActivityLog::leftJoin('users', 'curriculum_log_activity.user_id', '=', 'users.id')
                ->orderBy('created_at', 'asc')
                ->get(['curriculum_log_activity.*', 'users.nik', 'users.nama_pengguna']);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                // Ubah format default Laravel ke 'Y-m-d H:i:s'
                $formattedCreatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);
        
                // Set zona waktu ke 'Asia/Jakarta' dan format sesuai kebutuhan
                return $formattedCreatedAt->setTimezone('Asia/Jakarta')->format('d/m/Y G:i');
            })
            ->addIndexColumn()
            ->make(true);
    }
}

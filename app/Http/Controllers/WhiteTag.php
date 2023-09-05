<?php

namespace App\Http\Controllers;

use App\CompetencieGroup;
use App\User;
use App\WhiteTagModel;
use App\Exports\WhiteTagExport;
use App\CompetenciesDirectoryModel;
use App\SkillCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;



class WhiteTag extends Controller
{
    public function whiteTagJson(Request $request)
    {
        $cgAuth = Auth::user()->id_cg;
        $cgExtraAuth = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp = Auth::user()->id_department;
        $id = Auth::user()->id;

        if(Auth::user()->id_level == 'LV-0003'){ //LV-0003 = Level Dept. Head
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
            ->leftJoin('cg', 'users.id_cg', '=', 'cg.id_cg')
            ->Where('users.id_department', $dp)
            ->orderBy('users.nama_pengguna', 'DESC')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','cg.nama_cg','divisi.nama_divisi']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            $btn = '<button type="button" onclick="detailWhiteTag('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }else if(Auth::user()->id_level == 'LV-0004'){ //LV-0004 = Level Spv
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
            ->leftJoin('cg', 'users.id_cg', '=', 'cg.id_cg')
            ->Where('users.id', $id)
            ->orWhere('users.id_cg', $cgExtraAuth)
            ->orWhere('users.id_cg', $cgtambah2)
            ->orWhere('users.id_cg', $cgtambah3)
            ->orWhere('users.id_cg', $cgtambah4)
            ->orWhere('users.id_cg', $cgtambah5)
            ->orderBy('users.nama_pengguna', 'DESC')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','cg.nama_cg','divisi.nama_divisi']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            $btn = '<button type="button" onclick="detailWhiteTag('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }else if (Auth::user()->peran_pengguna == '1'){
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            // ->join('cg',function ($join) use ($cgAuth){
            //     $join->on('users.id_cg','cg.id_cg')
            //         ->where('users.id_cg',$cgAuth);
            // })
            ->leftJoin('cg', 'users.id_cg', '=', 'cg.id_cg')
            ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
            ->orderBy('users.nama_pengguna', 'DESC')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','cg.nama_cg','divisi.nama_divisi']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            $btn = '<button data-id="' . $row->id . '" onclick="getMapComp('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
            $btn = $btn . '<button type="button" onclick="detailWhiteTag('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }else{
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->join('cg',function ($join) use ($cgAuth){
                $join->on('users.id_cg','cg.id_cg')
                    ->where('users.id_cg',$cgAuth);
            })
            ->leftJoin('divisi', 'users.id_divisi', '=', 'divisi.id_divisi')
            ->orderBy('users.nama_pengguna', 'DESC')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title','cg.nama_cg','divisi.nama_divisi']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            $btn = '<button data-id="' . $row->id . '" onclick="getMapComp('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
            $btn = $btn . '<button type="button" onclick="detailWhiteTag('.$row->id.',this)" userName="'.$row->nama_pengguna.'" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function whiteTagAll(Request $request)
    {
        $cgAuth = Auth::user()->id_cg;
        $cgExtraAuth = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp = Auth::user()->id_department;
        $id = Auth::user()->id;
        $select = [
            "nama_pengguna","no_training_module","skill_category","training_module","level","training_module_group","start","actual","target","compGroup.name as compGroupName", "white_tag.keterangan as ket",
            DB::raw("(IF(actual < target,'Open','Close' )) as tagingStatus")
        ];
        if(Auth::user()->id_level == 'LV-0003'){ //LV-0003 = Level Dept. Head
            $data = WhiteTagModel::select($select)
                ->join("users","users.id","white_tag.id_user")
                ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
                ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                // ->whereRaw("white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0")
                ->Where('users.id_department', $dp)
                ->get();
        }else if(Auth::user()->id_level == 'LV-0004'){ //LV-0004 = Level Spv
            $data = WhiteTagModel::select($select)
                ->join("users","users.id","white_tag.id_user")
                ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
                ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                // ->whereRaw("white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0")
                ->Where('users.id', $id)
                ->orWhere('users.id_cg', $cgExtraAuth)
                ->orWhere('users.id_cg', $cgtambah2)
                ->orWhere('users.id_cg', $cgtambah3)
                ->orWhere('users.id_cg', $cgtambah4)
                ->orWhere('users.id_cg', $cgtambah5)
                ->get();
        }else if (Auth::user()->peran_pengguna == '1'){
            $data = WhiteTagModel::select($select)
                ->join("users","users.id","white_tag.id_user")
                ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
                ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                // ->whereRaw("white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0")
                // ->where("users.id_cg", $cgAuth)
                ->get();
        }else{
            $data = WhiteTagModel::select($select)
                ->join("users","users.id","white_tag.id_user")
                ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
                ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                // ->whereRaw("white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0")
                ->where("users.id_cg", $cgAuth)
                ->get();
        }
        
        return Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('start', function ($row) {
            switch($row->start){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto tooltip-info" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->editColumn('actual', function ($row) {
            switch($row->actual){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->editColumn('target', function ($row) {
            switch($row->target){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Close') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    }elseif ($row->tagingStatus == 'Open') {
                        $label = '<span class="badge badge-danger text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }else{
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }
                }
            })

        ->addIndexColumn()
        ->rawColumns(['start','actual','target','tagingStatus'])
        ->make(true);
    }

    public function whiteTagRoleMember(Request $request)
    {
        $id = Auth::user()->id;
        $select = [
            "nama_pengguna","no_training_module","skill_category","training_module","level","training_module_group","start","actual","target","compGroup.name as compGroupName", "white_tag.keterangan as ket",
            DB::raw("(IF(actual < target,'Open','Close' )) as tagingStatus")
        ];
        $data = WhiteTagModel::select($select)
                ->join("users","users.id","white_tag.id_user")
                ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
                ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                // ->whereRaw("white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0")
                ->where("users.id", $id)
                ->orderBy("tagingStatus")
                ->get();

        return Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('start', function ($row) {
            switch($row->start){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto tooltip-info" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->editColumn('actual', function ($row) {
            switch($row->actual){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->editColumn('target', function ($row) {
            switch($row->target){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Close') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    }elseif ($row->tagingStatus == 'Open') {
                        $label = '<span class="badge badge-danger text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }else{
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }

                    // switch ($row->tagingStatus) {
                    //     case "Closeed":
                    //         $label = '<span class="badge badge-success">"' . $row->tagingStatus . '"</span>';
                    //         return $label;
                    //         break;
                    //     case "Follow Up":
                    //         $label = '<span class="badge badge-secondary">"' . $row->tagingStatus . '"</span>';
                    //         return $label;
                    //         break;
                    //     default:
                    //         return '';
                    // }
                }
            })

        ->addIndexColumn()
        ->rawColumns(['start','actual','target','tagingStatus'])
        ->make(true);
    }

    public function exportWhiteTagAll()
    {
        $dateTime = date("d-m-Y H:i");
        $fileName = "White Tag (".$dateTime.").xlsx";
        return Excel::download(new WhiteTagExport, $fileName);
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $colors = ["#fcba03","#03fc0f","#03fcf8","#0373fc","#1403fc","#9403fc","#fc03eb","#fc0335","#fc6703"];
        $chartData = [
            "label" => [],
            "data" => [],
            "identity" => [],
            "backgroundColour" => []
        ];
        $skill_categories = SkillCategoryModel::select("skill_category.id_skill_category","skill_category",DB::raw("COUNT(wt.id_white_tag) as total"))
                                ->leftJoin("curriculum",function ($join){
                                    $join->on("curriculum.id_skill_category","skill_category.id_skill_category")
                                         ->join("competencies_directory as cd","cd.id_curriculum","curriculum.id_curriculum")
                                         ->join("white_tag as wt",function ($j){
                                             $j->on("wt.id_directory","cd.id_directory")
                                               ->where("wt.actual",">=","cd.target");
                                         });
                                })
                                ->groupBy("curriculum.id_skill_category")
                                ->get()
                                ->toArray();
        foreach($skill_categories as $key => $sc){
            $chartData["label"][$key] = $sc["skill_category"];
            $chartData["data"][$key] = $sc["total"];
            $chartData["identity"][$key] = $sc["id_skill_category"];
            $chartData["backgroundColour"][$key] = $colors[rand(0,8)];
        }
        $where = "competencie_groups.id_skill_category = 2";
        $compGroup = CompetencieGroup::select("name",DB::raw("COUNT(wt.id_white_tag) as total"))
                                    ->leftJoin("curriculum",function ($join){
                                        $join->on("curriculum.training_module_group","competencie_groups.id")
                                             ->join("competencies_directory as cd","cd.id_curriculum","curriculum.id_curriculum")
                                             ->join("white_tag as wt",function ($j){
                                                 $j->on("wt.id_directory","cd.id_directory")
                                                   ->where("wt.actual",">=","cd.target");
                                             });
                                            })
                                    ->groupBy("competencie_groups.name");
                                    if($where != ""){
                                        $compGroup->whereRaw($where);
                                    }
                                    $compGroup = $compGroup->get();
        return view('pages.admin.white-tag.index',compact("chartData"));
    }

    public function randomColor()
    {
        $r = str_pad( dechex( mt_rand( 0, 255 ) ), 1, '0', STR_PAD_LEFT);
        $g = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
        $b = str_pad( dechex( mt_rand( 0, 255 ) ), 3, '0', STR_PAD_LEFT);

        return "rgb(".$r.",".$g.",".$b.")";
    }

    public function chartSkillCategory(Request $request)
    {
        $chartData = [
            "label" => [],
            "data" => [],
            "identity" => [],
            "backgroundColour" => ['#9AD0F5', '#FFB1C1']
        ];
        $skill_categories = SkillCategoryModel::select("skill_category.id_skill_category","skill_category",DB::raw("COUNT(wt.id_white_tag) as total"))
                                ->leftJoin("curriculum",function ($join) use ($request){
                                    $join->on("curriculum.id_skill_category","skill_category.id_skill_category")
                                         ->join("competencies_directory as cd","cd.id_curriculum","curriculum.id_curriculum")
                                         ->leftjoin("white_tag as wt",function ($j) use ($request){
                                             $j->on("wt.id_directory","cd.id_directory")
                                                ->whereRaw("wt.actual >= cd.target AND wt.actual > 0 AND wt.start >= 0")
                                                ->join("users",function ($u) use ($request){
                                                    $u->on("users.id","wt.id_user");
                                                    if($request->cg != 'all'){
                                                        $u->where("users.id_cg","=",$request->cg);
                                                    }
                                                });
                                         });
                                })
                                ->groupBy("curriculum.id_skill_category")
                                ->get();
        foreach($skill_categories as $key => $sc){
            $chartData["label"][$key] = $sc["skill_category"];
            $chartData["data"][$key] = $sc["total"];
            $chartData["identity"][$key] = $sc["id_skill_category"];
            $chartData["backgroundColour"][$key];
            // $chartData["backgroundColour"][$key] = '#'.substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
        return response()->json(['data'=>$chartData,'code' => 200, 'message' => 'Post successfully'], 200);
    }

    public function chartCompGroup(Request $request)
    {
        $colors = ["#FFD8E1", "#D7ECFB", "#FFF3D6", "#D3F5F5", "#E6D9FF", "#FFE9D3"];
        $sc = SkillCategoryModel::where("id_skill_category",$request->id)->first();
        $chartData = [
            "title" => $sc->skill_category,
            "label" => [],
            "data" => [],
            "identity" => [],
            "backgroundColor" => ["#FFF3D6", "#D3F5F5", "#E6D9FF", "#FFE9D3", "#FFD8E1", "#D7ECFB"]
        ];
        $where = "competencie_groups.id_skill_category = '".$request->id."'";
        $compGroups = CompetencieGroup::select("name",DB::raw("COUNT(wt.id_white_tag) as total"))
                                    ->leftJoin("curriculum",function ($join) use ($request){
                                        $join->on("curriculum.training_module_group","competencie_groups.id")
                                             ->join("competencies_directory as cd","cd.id_curriculum","curriculum.id_curriculum")
                                             ->leftJoin("white_tag as wt",function ($j) use ($request){
                                                 $j->on("wt.id_directory","cd.id_directory")
                                                   ->whereRaw("wt.actual >= cd.target AND wt.actual > 0 AND wt.start >= 0")
                                                   ->join("users",function ($u) use ($request){
                                                    $u->on("users.id","wt.id_user");
                                                    if($request->cg != 'all'){
                                                        $u->where("users.id_cg","=",$request->cg);
                                                    }
                                                });
                                             });
                                            })
                                    ->groupBy("competencie_groups.name")
                                    ->whereRaw($where)
                                    ->get();
        foreach($compGroups as $key => $cg){
            $chartData["label"][$key] = $cg["name"];
            $chartData["data"][$key] = $cg["total"];
            // $chartData["backgroundColor"][$key] = '#'.substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
        return response()->json(['data'=>$chartData,'code' => 200, 'message' => 'Post successfully'], 200);
    }

    public function formWhiteTag(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id" => "requeired|numeric",
            "type" => "required|string|in:functional,general"
        ]);
        $type = $request->type;
        // $user = User::select("id","id_job_title",DB::raw("(YEAR(NOW()) - YEAR(tgl_masuk)) AS tahun"))->where("id",$request->id)->first();
        $user = User::select("id", "id_job_title", DB::raw("(YEAR(NOW()) - YEAR(IFNULL(tgl_rotasi, tgl_masuk))) AS tahun"))
                ->where("id", $request->id)
                ->first();
        
        
        $between = 0;
        if($user->tahun > 5){
            $between = 5;
        }else{
            $between = $user->tahun;
        }
        $select = [
            "competencies_directory.id_directory as id_directory","curriculum.no_training_module as no_training",
            "curriculum.training_module as training_module","curriculum.training_module_group as training_module_group",
            "curriculum.level as level","skill_category.skill_category as skill_category","white_tag.start as start",
            "white_tag.actual as actual","competencies_directory.target as target",
            "white_tag.keterangan as ket",
            DB::raw("(SELECT COUNT(*) FROM taging_reason as tr where tr.id_white_tag = white_tag.id_white_tag) as cntTagingReason"),
            // DB::raw("(IF(((white_tag.actual - competencies_directory.target) < 0),'Open','Close' )) as tagingStatus")
            DB::raw("(CASE WHEN (white_tag.actual - competencies_directory.target) < 0 THEN 'Open'
                            WHEN (white_tag.actual IS NULL) THEN 'Belum diatur'
                            WHEN white_tag.actual >= competencies_directory.target THEN 'Close'
                            END) as tagingStatus"),"compGroup.name as compGroupName"
        ];
        $comps = CompetenciesDirectoryModel::select($select)
                                            ->join("curriculum",function ($join) use ($user,$between){
                                                $join->on("curriculum.id_curriculum","competencies_directory.id_curriculum")
                                                    ->whereRaw("competencies_directory.id_job_title = '".$user->id_job_title."' AND competencies_directory.between_year = '".$between."'");
                                            })
                                            ->join("competencie_groups as compGroup","compGroup.id","curriculum.training_module_group")
                                            ->join("skill_category","skill_category.id_skill_category","curriculum.id_skill_category")
                                            ->leftJoin("white_tag",function ($join) use ($user){
                                                $join->on("white_tag.id_directory","competencies_directory.id_directory")
                                                    ->where("white_tag.id_user",$user->id);
                                            })
                                            ->get();
        return view("pages.admin.white-tag.form",compact('comps','user','type'));
    }

    public function actionWhiteTag(Request $request)
    {
        $request->validate([
            "user_id" => "required|numeric",
            "data" => "nullable|array",
            "data.*.id" => "nullable|numeric",
            "data.*.start" => "nullable|numeric",
            "data.*.actual" => "nullable|numeric",
            "data.*.ket" => "nullable|string",
        ]);
        DB::beginTransaction();
        try{
            $data = $this->validate_input_v2($request);
            $skillId = [1,2];
            $cek = WhiteTagModel::whereRaw("id_user = '".$request->user_id."' AND (select count(*) from taging_reason where taging_reason.id_white_tag = white_tag.id_white_tag) <= 0 ")
                        ->join("competencies_directory",function ($join) use ($skillId){
                            $join->on('competencies_directory.id_directory','white_tag.id_directory')
                                ->join('curriculum','curriculum.id_curriculum','competencies_directory.id_curriculum')
                                ->whereIn('curriculum.id_skill_category',$skillId);
                        })
                        ->delete();
            if(isset($data["data"]) && count($data["data"]) > 0){
                $insert = [];
                for($i=0; $i < count($data["data"]); $i++){
                    if($data["data"][$i]["start"] != "" && $data["data"][$i]["actual"] != ""){
                        $insert[$i] = [
                            "id_white_tag"=> $this->random_string(5,5,false).time(),
                            "id_directory" => $data["data"][$i]["id"],
                            "id_user" => $data["user_id"],
                            "start" => $data["data"][$i]["start"],
                            "actual" => $data["data"][$i]["actual"],
                            "keterangan" => $data["data"][$i]["ket"],

                        ];
                    }
                }
                if(count($insert) > 0)WhiteTagModel::insert($insert);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return response()->json(['code' => 200, 'message' => 'Post successfully'], 200);
    }

    public function detailWhiteTag(Request $request)
    {
        $user = User::select("id","id_job_title")->where("id",$request->id)->first();
        $skillId = [1,2];
        $select = [
            "curriculum.no_training_module as no_training","curriculum.training_module as training_module","curriculum.training_module_group as training_module_group","curriculum.level as level","skill_category.skill_category as skill_category","white_tag.start as start","white_tag.actual as actual","competencies_directory.target as target",
            // DB::raw("(IF((white_tag.actual - competencies_directory.target) < 0,'Open','Close' )) as tagingStatus")
            DB::raw("(CASE WHEN (white_tag.actual - competencies_directory.target) < 0 THEN 'Open'
                            WHEN (white_tag.actual IS NULL) THEN 'Belum diatur'
                            WHEN white_tag.actual >= competencies_directory.target THEN 'Close'
                            END) as tagingStatus"),
                            "white_tag.keterangan as ket"
        ];
        $data = CompetenciesDirectoryModel::select($select)
                                            ->join("curriculum",function ($join) use ($user,$skillId){
                                                $join->on("curriculum.id_curriculum","competencies_directory.id_curriculum")
                                                    ->where("competencies_directory.id_job_title",$user->id_job_title)
                                                    ->whereIn("id_skill_category",$skillId);
                                            })
                                            ->join("skill_category","skill_category.id_skill_category","curriculum.id_skill_category")
                                            ->Join("white_tag",function ($join) use ($user){
                                                $join->on("white_tag.id_directory","competencies_directory.id_directory")
                                                    ->where("white_tag.id_user",$user->id);
                                            })
                                            ->groupBy("competencies_directory.id_curriculum")
                                            ->orderBy("tagingStatus", "DESC")
                                            ->get();
        
        return Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('start', function ($row) {
            switch($row->start){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto tooltip-info" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->editColumn('actual', function ($row) {
            switch($row->actual){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->editColumn('target', function ($row) {
            switch($row->target){
                case 0:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                break;
                case 1:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                break;
                case 2:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                break;
                case 3:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                break;
                case 4:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                break;
                case 5:
                    $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                break;

            }
            return $icon;
        })
        ->addColumn('tagingStatus', function ($row) {
            if (isset($row->tagingStatus)) {
                if ($row->tagingStatus == 'Close') {
                    $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                    return $label;
                } else {
                    $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                    return $label;
                }
            }
        })
        ->rawColumns(['start','actual','target','tagingStatus'])
        ->make(true);

    }
}












<?php

namespace App\Http\Controllers;
use App\Superman;
use App\TagingSupermanModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exports\TaggingSupermanExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;

class TagingSupermanController extends Controller
{
    public function index(){
        return view ("pages.admin.superman.tagging.index-taging-superman");
    }

    public function tagingSupermanJson(Request $request)
    {
        $where = "competencies_superman.actual < cd.target OR (SELECT COUNT(*) FROM tagging_superman where competencies_superman.id_competencies_superman = tagging_superman.id_competency_superman) > 0";
        $select = [
            "id_taging_superman","competencies_superman.id_competencies_superman","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "skill_category","curriculum_superman.curriculum_superman as curriculum_name","nama_cg","nik",
            "curriculum_group","competencies_superman.actual as actual",
            "cd.target as target",DB::raw("(competencies_superman.actual - cd.target) as actualTarget"),DB::raw("(IF((competencies_superman.actual - cd.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        $data = Superman::select($select)
                            ->join("competencies_dictionary_superman as cd",function ($join){
                                $join->on("cd.id_dictionary_superman","competencies_superman.id_cstu");
                            })
                            ->leftJoin("tagging_superman as tr","tr.id_competency_superman","competencies_superman.id_competencies_superman")
                            ->join("users","users.id","competencies_superman.id_user")
                            ->join("curriculum_superman","curriculum_superman.id_curriculum_superman","cd.id_curriculum_superman")
                            ->join("skill_category as sc","sc.id_skill_category","curriculum_superman.id_skill_category")
                            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                            ->whereRaw($where)
                            ->get();
                            // dd($data);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            if (isset($row->id_taging_superman)) {
                $btn = '<button white-tag-id="' . $row->id_competencies_superman . '" taging-reason-id="' . $row->id_taging_superman . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" onclick="detailTaging(' . $row->id_taging_superman . ')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                $btn = $btn . '<button data-id="' . $row->id_taging_superman . '" class="btn btn-inverse-danger btn-icon tagging-hapus mr-1" data-toggle="modal" data-target="#modal-hapus"><i class="icon-trash"></i></button>';
                return $btn;
            } else {
                $btn = '<button white-tag-id="' . $row->id_competencies_superman . '" taging-reason-id="' . $row->id_taging_superman . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                return $btn;
            }
        })
            ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Finished') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    } else {
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tagingStatus'])
            ->make(true);
    }
    public function tagingSupermanJsonAtasan(Request $request)
    {
        $where = "competencies_superman.actual < cd.target OR (SELECT COUNT(*) FROM tagging_superman where competencies_superman.id_competencies_superman = tagging_superman.id_competency_superman) > 0";
        $dept = Auth::user()->id_department;
        $select = [
            "id_taging_superman","competencies_superman.id_competencies_superman","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "skill_category","training_module","nik",
            "level","curriculum_group","competencies_superman.actual as actual",
            "cd.target as target",DB::raw("(competencies_superman.actual - cd.target) as actualTarget"),DB::raw("(IF((competencies_superman.actual - cd.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        $data = Superman::select($select)
                            ->join("competencies_dictionary_superman as cd",function ($join){
                                $join->on("cd.id_dictionary_superman","competencies_superman.id_cstu");
                            })
                            ->leftJoin("tagging_superman as tr","tr.id_competency_superman","competencies_superman.id_competencies_superman")
                            ->join("users",function ($join) use ($request,$dept) {
                                $join->on("users.id","competencies_superman.id_user");
                                if (isset($request->type)) {
                                    $join->where("users.id_department", $dept);
                                }
                            })
                            ->join("curriculum_superman","curriculum_superman.id_curriculum_superman","cd.id_curriculum_superman")
                            ->join("skill_category as sc","sc.id_skill_category","curriculum_superman.id_skill_category")
                            ->whereRaw($where)
                            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            if (isset($row->id_taging_superman)) {
                $btn = '<button white-tag-id="' . $row->id_competencies_superman . '" taging-reason-id="' . $row->id_taging_superman . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                $btn = $btn . '<button type="button" onclick="detailTaging(' . $row->id_taging_superman . ')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            } else {
                $btn = '<button white-tag-id="' . $row->id_competencies_superman . '" taging-reason-id="' . $row->id_taging_superman . '" onclick="formTaging(this)" class="button-add btn btn-inverse-success btn-icon mr-1" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus menu-icon"></i></button>';
                return $btn;
            }
        })
            ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Finished') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    } else {
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }

                    // switch ($row->tagingStatus) {
                    //     case "Finished":
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
            ->rawColumns(['action', 'tagingStatus'])
            ->make(true);
    }

    public function tagingSupermanJsonMember(Request $request)
    {
        $where = "competencies_superman.actual < cd.target OR (SELECT COUNT(*) FROM tagging_superman where competencies_superman.id_competencies_superman = tagging_superman.id_competencies_superman) > 0";
        $id_user = Auth::user()->id;
        $select = [
            "id_taging_superman","competencies_superman.id_competencies_superman","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "skill_category","training_module","nik",
            "level","curriculum_group","competencies_superman.actual as actual",
            "cd.target as target",DB::raw("(competencies_superman.actual - cd.target) as actualTarget"),DB::raw("(IF((competencies_superman.actual - cd.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        $data = Superman::select($select)
                            ->join("competencies_dictionary_superman as cd",function ($join){
                                $join->on("cd.id_dictionary_superman","competencies_superman.id_cstu");
                            })
                            ->leftJoin("tagging_superman as tr","tr.id_competency_superman","competencies_superman.id_competencies_superman")
                            ->join("users",function ($join) use ($request,$id_user) {
                                $join->on("users.id","competencies_superman.id_user");
                                if(isset($request->type) && $request->type == 'member'){
                                    $join->where("users.id",$id_user);
                                }
                            })
                            ->join("curriculum_superman","curriculum_superman.id_curriculum_superman","cd.id_curriculum_superman")
                            ->join("skill_category as sc","sc.id_skill_category","curriculum_superman.id_skill_category")
                            ->whereRaw($where)
                            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            if (isset($row->id_taging_superman)) {
                $btn = '<button type="button" onclick="detailTaging(' . $row->id_taging_superman . ')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            } else {
                $btn = '';
                return $btn;
            }
        })
            ->addColumn('tagingStatus', function ($row) {
                if (isset($row->tagingStatus)) {
                    if ($row->tagingStatus == 'Finished') {
                        $label = '<span class="badge badge-success">' . $row->tagingStatus . '</span>';
                        return $label;
                    } else {
                        $label = '<span class="badge badge-secondary text-white">' . $row->tagingStatus . '</span>';
                        return $label;
                    }
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tagingStatus'])
            ->make(true);
    }
    

    public function supermanFormTaggingList(Request $request)
    {   
        $id_competencies_superman = $request->competencies_superman_id;
        $id_reason_tag = $request->reasonTagId;
        $competencies_superman = Superman::select("start",'actual')
                                    ->where("id_competencies_superman",$request->competencies_superman_id)
                                    ->first();
                                    // dd($competencies_superman);
        if(isset($id_reason_tag)){
            $select = [
                "tagging_superman.id_taging_superman","tagging_superman.id_competency_superman as id_competency_superman","tahun","periode",
                DB::raw("DATE_FORMAT(date_open,'%d-%m-%Y') AS date_open"),DB::raw("DATE_FORMAT(due_date,'%d-%m-%Y') AS due_date"),"learning_method","trainer",DB::raw("DATE_FORMAT(date_plan_implementation,'%d-%m-%Y') AS date_plan_implementation"),
                "notes_learning_implementation",DB::raw("DATE_FORMAT(date_closed,'%d-%m-%Y') AS date_closed"),
                DB::raw("(TIME_FORMAT(tagging_superman.start,'%H:%i')) as start"),
                DB::raw("(TIME_FORMAT(finish,'%H:%i')) as finish"),"duration",DB::raw("DATE_FORMAT(date_verified,'%d-%m-%Y') AS date_verified"),
                "result_score","notes_for_result"
            ];
            $taging = TagingSupermanModel::select($select)
                                    ->join("competencies_superman as wt",function ($join) use ($id_reason_tag){
                                        $join->on("tagging_superman.id_competency_superman","wt.id_competencies_superman")
                                            ->where("id_taging_superman",$id_reason_tag);
                                    })
                                    ->first();
        }else{
            $taging = null;
        }
        return view("pages.admin.superman.tagging.form-taging-superman",compact(["id_competencies_superman","id_reason_tag","taging","competencies_superman"]));
    }

    public function supermanActionTagingList(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi !',
            'min'      => ':attribute harus di isi minimal :min karakter !!',
            'max'      => ':attribute jangan diisi lebih dari :max karakter !!'
        ];

        $this->validate($request,[
            "id_taging_superman" => "nullable|numeric",
            "id_competency_superman" => "required|string",
            "tahun" => "required|digits:4",
            "periode" => "required|string|max:20",
            "learning_method" => "required|string|in:0,1,2,3,4,5,6",
            "trainer" => "required|string|max:50",
            "date_plan_implementation" => "required|date_format:d-m-Y",
            "date_verified" => "required|date_format:d-m-Y",
            "result_score" => "required|numeric|min:0|max:5",
            "notes_for_result" => "nullable|string"
        ],$messages);
        DB::beginTransaction();
        try {
            $data = $request->all();
            $tempData = [
                "tahun" => $data["tahun"],
                "periode" => $data["periode"],
                "learning_method" => $data["learning_method"],
                "trainer" => $data["trainer"],
                "date_plan_implementation" => date("Y-m-d", strtotime($data["date_plan_implementation"])),
                "date_verified" => date("Y-m-d", strtotime($data["date_verified"])),
                "result_score" => $data["result_score"],
                "notes_for_result" => $data["notes_for_result"]
            ];
            if(isset($data["id_taging_superman"])){
                TagingSupermanModel::where("id_taging_superman",$data["id_taging_superman"])
                ->update($tempData);
                $messages = "Success! Data berhasil diperbaharui";
            }else{
                $lastId = TagingSupermanModel::orderBy("id_taging_superman","desc")->first();
                if(isset($lastId)){
                    $lastNumber = (int)$lastId->no_taging;
                }else{
                    $lastNumber = 0;
                }
                $tempData["no_taging"] = str_pad($lastNumber+1,5,'0',STR_PAD_LEFT);
                $tempData["id_competency_superman"] = $data["id_competency_superman"];
                $tempData["id_verified_by"] = Auth::user()->id;
                TagingSupermanModel::insert($tempData);
                $messages = "Success! Data berhasil di Follow Up";
            }
            Superman::where("id_competencies_superman",$data["id_competency_superman"])
                            ->update([
                                "actual" => $data["result_score"],
                                "keterangan" => $data["notes_for_result"] // Tambahkan kolom "keterangan" ke sini
                            ]);
            DB::commit();
            return Response::json(['success' => $messages]);
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['errors' => $e->getMessage(),'message'=>'error'],402);
        }
    }

    public function detail(Request $request){
        $validator = Validator::make($request->all(),[
            "id" => "required|numeric"
        ]);

        if($validator->fails()){
            // dd($validator->errors());
        }else{
            $select = [
                "tagging_superman.no_taging as no_taging",
                "tagging_superman.tahun as tahun",
                "tagging_superman.periode as periode",
                "member.nama_pengguna as name",
                "cg.nama_cg as name_cg",
                "curriculum_superman.curriculum_group as curriculum_group",
                "curriculum_superman.curriculum_superman as training_module",
                "wt.actual as actual",
                "cd.target as target",
                // "tagging_superman.date_open as date_open",
                // "tagging_superman.due_date as due_date",
                "tagging_superman.date_plan_implementation as date_plan_implementation",
                DB::raw("(CASE WHEN tagging_superman.learning_method = '0' THEN 'Internal Training'
                                        WHEN tagging_superman.learning_method = '1' THEN 'External Training'
                                        WHEN tagging_superman.learning_method = '2' THEN 'In House Training'
                                        WHEN tagging_superman.learning_method = '3' THEN 'Learn From Expertise' 
                                        WHEN tagging_superman.learning_method = '4' THEN 'Learn From Book' 
                                        WHEN tagging_superman.learning_method = '5' THEN 'On the-Job Training' 
                                ELSE 'Sharing' END) as learning_method"),
                "tagging_superman.trainer as trainer",
                // "tagging_superman.notes_learning_implementation as notes_learning_implementation",
                // "tagging_superman.date_closed as date_closed",
                // DB::raw("TIME_FORMAT(tagging_superman.start,'%H:%i') as start"),
                // DB::raw("TIME_FORMAT(tagging_superman.finish,'%H:%i') as finish"),
                "tagging_superman.date_verified as date_verified",
                "verified.nama_pengguna as verified_by",
                "tagging_superman.result_score as result_score",
                "tagging_superman.notes_for_result as notes_for_result"
            ];
            $data = TagingSupermanModel::select($select)
                                ->join("users as verified",function ($join) use ($request){
                                    $join->on("verified.id","id_verified_by")
                                            ->where("id_taging_superman",$request->id);
                                })
                                ->join("competencies_superman as wt","wt.id_competencies_superman","tagging_superman.id_competency_superman")
                                ->join("users as member","member.id","wt.id_user")
                                ->join("competencies_dictionary_superman as cd","cd.id_dictionary_superman","wt.id_cstu")
                                ->join("curriculum_superman","curriculum_superman.id_curriculum_superman","cd.id_curriculum_superman")
                                ->join("cg","cg.id_cg","member.id_cg")
                                ->first();
            return view("pages.admin.superman.tagging.detail-taging-superman",compact("data"));
        }
    }

    public function exportTaggingList(Request $request)
    {
        $this->validate($request,[
            "category"=>"required|in:0,1,2",
            "all"=>"required|in:0,1"
        ]);
        $type = "";
        if($request->all == 0){
            $cg = CG::where("id_cg",Auth::user()->id_cg)->first();
            $type = "(".$cg->nama_cg.")";
        }
        $dateTime = date("d-m-Y H:i"); 
        switch ($request->category) {
            case '0':
                $fileName = "Tagging List ".$type." Semua (".$dateTime.").xlsx";
            break;
            case '1':
                $fileName = "Tagging List ".$type." Belum Finish (".$dateTime.").xlsx";
            break;
            case '2':
                $fileName = "Tagging List ".$type." Finish (".$dateTime.").xlsx";
            break;
        }
        return Excel::download(new TaggingSupermanExport($request->category,$request->all), $fileName);
        return redirect()->back();
    }

    public function taggingPrint(Request $request)
    {
        $this->validate($request,[
            "id"=>"required"
        ]);
        $select = [
            "tagging_superman.no_taging as no_taging",
            "tagging_superman.tahun as tahun",
            "tagging_superman.periode as periode",
            "member.nama_pengguna as name",
            "curriculum.curriculum_group as curriculum_group",
            "curriculum.training_module as training_module",
            "wt.actual as actual",
            "cd.target as target",
            // "tagging_superman.date_open as date_open",
            // "tagging_superman.due_date as due_date",
            "tagging_superman.date_plan_implementation as date_plan_implementation",
            DB::raw("(CASE WHEN tagging_superman.learning_method = '0' THEN 'Internal Training'
                            WHEN tagging_superman.learning_method = '1' THEN 'External Training'
                            WHEN tagging_superman.learning_method = '2' THEN 'In House Training'
                            WHEN tagging_superman.learning_method = '3' THEN 'Learn From Expertise' 
                            WHEN tagging_superman.learning_method = '4' THEN 'Learn From Book' 
                            WHEN tagging_superman.learning_method = '5' THEN 'On the-Job Training' 
                            ELSE 'Sharing' END) as learning_method"),
            "tagging_superman.trainer as trainer",
            // "tagging_superman.notes_learning_implementation as notes_learning_implementation",
            // "tagging_superman.date_closed as date_closed",
            // DB::raw("TIME_FORMAT(tagging_superman.start,'%H:%i') as start"),
            // DB::raw("TIME_FORMAT(tagging_superman.finish,'%H:%i') as finish"),
            "tagging_superman.date_verified as date_verified",
            "verified.nama_pengguna as verified_by",
            "tagging_superman.result_score as result_score",
            "tagging_superman.notes_for_result as notes_for_result"
        ];
        $data = TagingSupermanModel::select($select)
                            ->join("users as verified",function ($join) use ($request){
                                $join->on("verified.id","id_verified_by")
                                        ->where("id_taging_superman",$request->id);
                            })
                            ->join("competencies_superman as wt","wt.id_competencies_superman","tagging_superman.id_competencies_superman")
                            ->join("users as member","member.id","wt.id_user")
                            ->join("competencies_dictionary_superman as cd","cd.id_dictionary_superman","wt.id_directory")
                            ->join("curriculum_superman","curriculum.id_curriculum_superman","cd.id_curriculum_superman")
                            ->first();
        return view("pages.admin.taging-list.print-competency-tag",compact("data"));
    }
    public function deleteSupermanTagging()
    {
        $validator = Validator::make(request()->all(),[
            'id' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id');
        TagingSupermanModel::where('id_taging_superman',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Tagging berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
}

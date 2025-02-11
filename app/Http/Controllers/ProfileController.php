<?php

namespace App\Http\Controllers;

use App\User;
use App\WhiteTagModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $select = [
            "nama_pengguna","nik","email","gambar",DB::raw("DATE_FORMAT(tgl_masuk,'%d-%m-%y') AS tgl_masuk"),"jt.nama_job_title","divisi.nama_divisi","dprtm.nama_department","s_dprtm.nama_subdepartment","level.nama_level","nama_cg","role"
        ];
        $user = User::select($select)
                    ->leftJoin("role","role.id_role","peran_pengguna")
                    ->leftJoin("divisi","divisi.id_divisi","users.id_divisi")
                    ->leftJoin("job_title as jt","jt.id_job_title","users.id_job_title")
                    ->leftJoin("level","level.id_level","users.id_level")
                    ->leftJoin("department as dprtm","dprtm.id_department","users.id_department")
                    ->leftJoin("sub_department as s_dprtm","s_dprtm.id_subdepartment","users.id_sub_department")
                    ->leftJoin("cg","cg.id_cg","users.id_cg")
                    ->where("id",Auth::user()->id)
                    ->first();
        $counting = WhiteTagModel::select(DB::raw("COUNT(level) as cnt"),"level")
                        ->join("users",function ($join) use ($request){
                            $join->on("users.id","white_tag.id_user")
                            ->where([
                                ["white_tag.id_user",Auth::user()->id],
                                ["white_tag.actual",">=","cd.target"]
                            ]);
                        })
                        ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                        ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
                        ->groupBy("level")
                        ->get();
        $select_open = [
            "nama_pengguna","no_training_module",
            DB::raw("COUNT(*) as cnt", "(IF(actual < target,'Open','Close' )) as tagingStatus")
        ];  
        $data_open = WhiteTagModel::select($select_open)
                    ->join("users","users.id","white_tag.id_user")
                    ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                    ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                    ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
                    ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                    // ->whereRaw("white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0")
                    ->whereRaw("white_tag.actual < cd.target")
                    ->where("users.id", $request->id)
                    ->get();                   
        return view("pages.admin.profile.index",compact("user","counting", "data_open"));
    }
}

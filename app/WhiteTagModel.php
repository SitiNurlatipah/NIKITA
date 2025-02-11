<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CompetenciesDirectoryModel;
use Carbon\Carbon;

class WhiteTagModel extends Model
{
    protected $table = 'white_tag';
    protected $fillable = [
        'id_curriculum', 'id_user', 'start', 'actual', 'target', 'keterangan','id_white_tag'
    ];
    //primary key kalo diaktifin gabisa ngambil id_white_tag buat taging
    // protected $primaryKey = 'id_white_tag'; 
    public $timestamps = false;

    public function score($id_user,$level)
    {
        $currentYear = Carbon::now()->year;
        $totalactualnew = WhiteTagModel::select(DB::raw("(sum(white_tag.actual)) as jml_actual"),"level","actual")
                    ->join("users",function ($join) use ($id_user){
                        $join->on("users.id","white_tag.id_user")
                        ->where([
                            ["white_tag.id_user",$id_user],
                            // ["white_tag.actual",">=","cd.target"]
                        ]);
                    })
                    ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                    ->where('crclm.level',$level)
                    ->get();
                    // dd($totalactualnew);
        $target = User::select("id","id_job_title",DB::raw("(YEAR(NOW()) - YEAR(tgl_masuk)) AS tahun"))->where("id", $id_user)->first();
        $user = User::select("id", "id_job_title", DB::raw("(YEAR(NOW()) - YEAR(IFNULL(tgl_rotasi, tgl_masuk))) AS tahun"))
                ->where("id", $id_user)
                ->first();
        $between = ($user->tahun > 5) ? 5 : $user->tahun;
        $between2 = ($target->tahun > 5) ? 5 : $target->tahun;
        $totaltarget = CompetenciesDirectoryModel::select(
                        DB::raw("SUM(competencies_directory.target) as jml_target")
                    )
                    ->join("curriculum", function ($join) use ($user, $between, $between2) {
                        $join->on("curriculum.id_curriculum", "competencies_directory.id_curriculum")
                             ->whereRaw("competencies_directory.id_job_title = '".$user->id_job_title."'");
                    })
                    ->joinSub(function ($query) use ($user, $between, $between2) {
                        $query->select('id_curriculum', 'id_skill_category','curriculum_year')
                            ->from('curriculum');
                    }, 'sub', function ($join) use ($user, $between, $between2) {
                        $join->on('competencies_directory.id_curriculum', '=', 'sub.id_curriculum');
                    })
                    ->where(function ($query) use ($between, $between2, $currentYear) {
                        $query->where(function ($subquery) use ($currentYear){
                            $subquery->whereNotNull('sub.curriculum_year')
                                // ->whereRaw("competencies_directory.between_year = TIMESTAMPDIFF(YEAR, sub.curriculum_year, NOW())");
                                ->where('sub.id_skill_category', '>=', 1)
                                ->whereRaw("competencies_directory.between_year = 
                                COALESCE(
                                    CASE 
                                        WHEN $currentYear - (sub.curriculum_year-1) > 5 THEN 5
                                        ELSE $currentYear - (sub.curriculum_year-1)
                                    END,
                                    0
                                )");
                        })
                        ->orWhere(function ($subquery) use ($between) {
                            $subquery->where('sub.id_skill_category', '=', 1)
                                ->whereNull('sub.curriculum_year')
                                ->whereRaw("competencies_directory.between_year = '".$between."'");
                        })
                        ->orWhere(function ($subquery) use ($between2) {
                            $subquery->where('sub.id_skill_category', '<>', 1)
                                ->whereNull('sub.curriculum_year')
                                ->whereRaw("competencies_directory.between_year = '".$between2."'");
                        });
                    })
                    ->Join("white_tag", function ($join) use ($id_user) {
                        $join->on("white_tag.id_curriculum", "=", "curriculum.id_curriculum")
                            ->where("white_tag.id_user", $id_user);
                    })
                    ->where('curriculum.level',$level)
                    ->get();
        $target_total = $totaltarget[0]["jml_target"];
        $actualLevel = $totalactualnew[0]["jml_actual"];
        // dd($actualLevel);
        if ($target_total != 0) {
            if($totaltarget[0]['level'] == 'B'){
                $count = ($actualLevel/$target_total)*100;
            }elseif($totaltarget[0]['level'] == 'I'){
                $count = ($actualLevel/$target_total)*100;
            }else{
                $count = ($actualLevel/$target_total)*100;
            } 
        }else{
            $count = 0;
        }
        if($count >= 100){
            $count=100;
        }else{
            $count=$count;
        }
        return $count;
    }

    public function totalScore($id_user)
    {
        $levels = [
            'B',
            'I',
            'A'
        ];
        $data = array();
        $currentYear = Carbon::now()->year;
        foreach($levels as $lv => $key)
        {
            $target = User::select("id","id_job_title",DB::raw("(YEAR(NOW()) - YEAR(tgl_masuk)) AS tahun"))->where("id", $id_user)->first();
            $user = User::select("id", "id_job_title", DB::raw("(YEAR(NOW()) - YEAR(IFNULL(tgl_rotasi, tgl_masuk))) AS tahun"))
                    ->where("id", $id_user)
                    ->first();
            $between = ($user->tahun > 5) ? 5 : $user->tahun;
            $between2 = ($target->tahun > 5) ? 5 : $target->tahun;
            $wt = CompetenciesDirectoryModel::select(
                    DB::raw("SUM(IFNULL(white_tag.actual, 0)) as total_actual"),
                    DB::raw("SUM(competencies_directory.target) as total_target")
                )
                ->join("curriculum", function ($join) use ($user, $between, $between2) {
                    $join->on("curriculum.id_curriculum", "competencies_directory.id_curriculum")
                        ->whereRaw("competencies_directory.id_job_title = '".$user->id_job_title."'");
                })
                ->joinSub(function ($query) use ($user, $between, $between2) {
                    $query->select('id_curriculum', 'id_skill_category','curriculum_year')
                        ->from('curriculum');
                }, 'sub', function ($join) use ($user, $between, $between2) {
                    $join->on('competencies_directory.id_curriculum', '=', 'sub.id_curriculum');
                })
                ->where(function ($query) use ($between, $between2, $currentYear) {
                    $query->where(function ($subquery) use ($currentYear){
                        $subquery->whereNotNull('sub.curriculum_year')
                            // ->whereRaw("competencies_directory.between_year = TIMESTAMPDIFF(YEAR, sub.curriculum_year, NOW())");
                            ->where('sub.id_skill_category', '>=', 1)
                            ->whereRaw("competencies_directory.between_year = 
                            COALESCE(
                                CASE 
                                    WHEN $currentYear - (sub.curriculum_year-1) > 5 THEN 5
                                    ELSE $currentYear - (sub.curriculum_year-1)
                                END,
                                0
                            )");
                    })
                    ->orWhere(function ($subquery) use ($between) {
                        $subquery->where('sub.id_skill_category', '=', 1)
                            ->whereNull('sub.curriculum_year')
                            ->whereRaw("competencies_directory.between_year = '".$between."'");
                    })
                    ->orWhere(function ($subquery) use ($between2) {
                        $subquery->where('sub.id_skill_category', '<>', 1)
                            ->whereNull('sub.curriculum_year')
                            ->whereRaw("competencies_directory.between_year = '".$between2."'");
                    });
                })
                ->leftJoin("white_tag", function ($join) use ($id_user) {
                    $join->on("white_tag.id_curriculum", "=", "curriculum.id_curriculum")
                        ->where("white_tag.id_user", $id_user);
                })
                ->where('curriculum.level',$key)
                ->get();
           $jmlactual = WhiteTagModel::select(DB::raw("(sum(white_tag.actual)) as cnt"),"level","actual")
                        ->join("users",function ($join) use ($id_user){
                        $join->on("users.id","white_tag.id_user")
                            ->where([
                                ["white_tag.id_user",$id_user],
                                // ["white_tag.actual",">=","cd.target"]
                            ]);
                        })
                        ->join("curriculum as crclm","crclm.id_curriculum","white_tag.id_curriculum")
                        ->where('crclm.level',$key)
                        ->get();
            $target = $wt[0]["total_target"];
            $actual = $jmlactual[0]["cnt"];
            if ($target != 0) {
                $item = ($actual/$target)*100;
            }else{
                $item = 0;
            }
            array_push($data,$item);
        }
        
        $data2 = array_sum($data)/3;
        if($data2 >= 100){
            $data2=100;
        }else{
            $data2=$data2;
        }
        if($data2 >= 86.67)
        {
            // set is competent = 1
            $user = User::find($id_user);
            $user->is_competent = 1;
            $user->save();
        }else{
            // set is competent = 0
            $user = User::find($id_user);
            $user->is_competent = 0;
            $user->save();
        }
        
        return $data2;
    }
    public function championScore($id_user)
    {
        $user = User::select("id")
                ->where("id", $id_user)
                ->first();
        
            $wt = ChampionToUser::select(
                    DB::raw("SUM(IFNULL(white_tag.actual, 0)) as total_actual"),
                    DB::raw("SUM(curriculum_champion.target) as total_target")
                )
                ->join("curriculum_champion",function ($join) use ($user){
                    $join->on("curriculum_champion.id_curriculum_champion","curriculum_champion_to_user.id_curriculum_champion")
                        ->whereRaw("curriculum_champion_to_user.id_user = '".$user->id."'");
                })
                ->leftJoin("white_tag",function ($join) use ($user){
                    $join->on("white_tag.id_cctu","curriculum_champion_to_user.id_cctu")
                        ->where("white_tag.id_user",$user->id);
                })
                // ->where('curriculum_superman.id_skill_category',$key)
                ->get();
           $jmlactual = WhiteTagModel::select(DB::raw("sum(actual) as cnt"),DB::raw("sum(cc.target) as totaltarget"),"actual","target")
                                 ->join("users",function ($join) use ($id_user){
                                    $join->on("users.id","white_tag.id_user")
                                        ->where([
                                            ["white_tag.id_user",$id_user],
                                            ["white_tag.actual",">=","cc.target"]
                                        ]);
                                    })
                                    ->join("curriculum_champion_to_user as cctu","cctu.id_cctu","white_tag.id_cctu")
                                    ->join("curriculum_champion as cc","cc.id_curriculum_champion","cctu.id_curriculum_champion")
                                    ->get();
            $target = $wt[0]["total_target"];
            $actual = $jmlactual[0]["cnt"];
            if ($target != 0) {
                $item = ($actual/$target)*100;
            }else{
                $item = 0;
            }
            // array_push($data,$item);
        
        
        // $data2 = array_sum($data)/2;
        if($item >= 100){
            $item=100;
        }else{
            $item=$item;
        }
        if($item >= 86.67)
        {
            // set is competent champion = 1
            $user = User::find($id_user);
            $user->is_competent_champion = 1;
            $user->save();
        }else{
            // set is competent champion = 0
            $user = User::find($id_user);
            $user->is_competent_champion = 0;
            $user->save();
        }
        
        return $item;
    }


}

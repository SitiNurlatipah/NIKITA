<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CompetenciesDirectoryModel;


class WhiteTagModel extends Model
{
    protected $table = 'white_tag';
    protected $fillable = [
        'id_curriculum', 'id_user', 'id_training_module', 'start', 'actual', 'target', 'keterangan'
    ];
    public $timestamps = false;

    public function score($id_user,$level)
    {
        $totalactual = WhiteTagModel::select(DB::raw("sum(actual) as jml_actual"),"level","actual","target")
                    ->join("users",function ($join) use ($id_user){
                        $join->on("users.id","white_tag.id_user")
                        ->where([
                            ["white_tag.id_user",$id_user],
                            ["white_tag.actual",">=","cd.target"]
                        ]);
                    })
                    ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                    ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
                    ->where('crclm.level',$level)
                    ->get();
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
                        $query->select('id_curriculum', 'id_skill_category')
                              ->from('curriculum');
                    }, 'sub', function ($join) use ($user, $between, $between2) {
                        $join->on('competencies_directory.id_curriculum', '=', 'sub.id_curriculum');
                    })
                    ->where(function ($query) use ($between, $between2) {
                        $query->where('sub.id_skill_category', '=', 1)
                              ->whereRaw("competencies_directory.between_year = '".$between."'")
                              ->orWhere('sub.id_skill_category', '<>', 1)
                              ->whereRaw("competencies_directory.between_year = '".$between2."'");
                    })
                    ->leftJoin("white_tag", function ($join) use ($id_user) {
                        $join->on("white_tag.id_directory", "=", "competencies_directory.id_directory")
                            ->where("white_tag.id_user", $id_user);
                    })
                    ->where('curriculum.level',$level)
                    ->get();
        $target_total = $totaltarget[0]["jml_target"];
        $actual = $totalactual[0]["jml_actual"];
        if ($target_total != 0) {
            if($totaltarget[0]['level'] == 'B'){
                $count = ($actual/$target_total)*100;
            }elseif($totaltarget[0]['level'] == 'I'){
                $count = ($actual/$target_total)*100;
            }else{
                $count = ($actual/$target_total)*100;
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
                    $query->select('id_curriculum', 'id_skill_category')
                        ->from('curriculum');
                }, 'sub', function ($join) use ($user, $between, $between2) {
                    $join->on('competencies_directory.id_curriculum', '=', 'sub.id_curriculum');
                })
                ->where(function ($query) use ($between, $between2) {
                    $query->where('sub.id_skill_category', '=', 1)
                        ->whereRaw("competencies_directory.between_year = '".$between."'")
                        ->orWhere('sub.id_skill_category', '<>', 1)
                        ->whereRaw("competencies_directory.between_year = '".$between2."'");
                })
                ->leftJoin("white_tag", function ($join) use ($id_user) {
                    $join->on("white_tag.id_directory", "=", "competencies_directory.id_directory")
                        ->where("white_tag.id_user", $id_user);
                })
                ->where('curriculum.level',$key)
                ->get();
           $jmlactual = WhiteTagModel::select(DB::raw("sum(actual) as cnt"),DB::raw("sum(cd.target) as totaltarget"),"level","actual","target")
                                 ->join("users",function ($join) use ($id_user){
                                    $join->on("users.id","white_tag.id_user")
                                        ->where([
                                            ["white_tag.id_user",$id_user],
                                            ["white_tag.actual",">=","cd.target"]
                                        ]);
                                    })
                                 ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                                 ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
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


}

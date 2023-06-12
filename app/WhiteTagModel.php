<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhiteTagModel extends Model
{
    protected $table = 'white_tag';
    protected $fillable = [
        'id_curriculum', 'id_user', 'id_training_module', 'start', 'actual', 'target', 'keterangan'
    ];
    public $timestamps = false;

    public function score($id_user,$level)
    {
        $counting = WhiteTagModel::select(DB::raw("sum(actual) as cnt"),DB::raw("sum(cd.target) as totaltarget"),"level","actual","target")
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
        
        $jumlahtarget = CompetenciesDirectoryModel::select(DB::raw("sum(competencies_directory.target) as totaltarget"),"level","users.id_job_title")
                                ->join("curriculum as crclm", "crclm.id_curriculum", "=", "competencies_directory.id_curriculum")
                                ->join("white_tag", "white_tag.id_directory", "=", "competencies_directory.id_directory")
                                // ->join("job_title", "job_title.id_job_title", "=", "competencies_directory.id_job_title")
                                ->join("users", "users.id_job_title", "=", "competencies_directory.id_job_title")
                                ->where("crclm.level", "=", $level)
                                ->groupBy("competencies_directory.id_job_title", "users.id_job_title","crclm.level")
                                ->get();
        // dd($jumlahtarget);
        $cnt = $counting[0]["cnt"];
        $target_total = $counting[0]["totaltarget"];
        $actual = $counting[0]["cnt"];
        // dd($counting);
        if ($target_total != 0) {
            if($counting[0]['level'] == 'B'){
                $count = ($actual/$target_total)*100;
            }elseif($counting[0]['level'] == 'I'){
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
           $wt = WhiteTagModel::select(DB::raw("sum(actual) as cnt"),DB::raw("sum(cd.target) as totaltarget"),"level","actual","target")
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
            $target = $wt[0]["totaltarget"];
            $actual = $wt[0]["cnt"];
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

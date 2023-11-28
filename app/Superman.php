<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\CompDictionarySupermanModel;

class Superman extends Model
{
    protected $table = 'competencies_superman';
    
    protected $primaryKey = 'id_competencies_superman';
    public $timestamps = true;

    public function totalScore($id_user)
    {
        $user = User::select("id")
                ->where("id", $id_user)
                ->first();
        $skilId = [1,2];
        $data = array();
        foreach($skilId as $lv => $key)
        {
            $wt = CompDictionarySupermanModel::select(
                    DB::raw("SUM(IFNULL(competencies_superman.actual, 0)) as total_actual"),
                    DB::raw("SUM(competencies_dictionary_superman.target) as total_target")
                )
                ->join("curriculum_superman", function ($join) use ($user) {
                    $join->on("curriculum_superman.id_curriculum_superman", "competencies_dictionary_superman.id_curriculum_superman")
                        ->whereRaw("competencies_dictionary_superman.id_user = '".$user->id."'");
                })
                ->leftJoin("competencies_superman", function ($join) use ($id_user) {
                    $join->on("competencies_superman.id_cstu", "=", "competencies_dictionary_superman.id_dictionary_superman")
                        ->where("competencies_superman.id_user", $id_user);
                })
                ->where('curriculum_superman.id_skill_category',$key)
                ->get();
           $jmlactual = Superman::select(DB::raw("sum(actual) as cnt"),DB::raw("sum(cd.target) as totaltarget"),"actual","target")
                                 ->join("users",function ($join) use ($id_user){
                                    $join->on("users.id","competencies_superman.id_user")
                                        ->where([
                                            ["competencies_superman.id_user",$id_user],
                                            ["competencies_superman.actual",">=","cd.target"]
                                        ]);
                                    })
                                 ->join("competencies_dictionary_superman as cd","cd.id_dictionary_superman","competencies_superman.id_cstu")
                                 ->join("curriculum_superman as crclm","crclm.id_curriculum_superman","cd.id_curriculum_superman")
                                 ->where('crclm.id_skill_category',$key)
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
        
        $data2 = array_sum($data)/2;
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

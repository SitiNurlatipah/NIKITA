<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhiteTagModel extends Model
{
    protected $table = 'white_tag';
    protected $fillable = [
        'id_curriculum', 'id_user', 'id_training_module', 'start', 'actual', 'target'
    ];
    public $timestamps = false;

    public function score($id_user,$level)
    {
        $counting = WhiteTagModel::select(DB::raw("COUNT(*) as cnt"),"level")
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
        if($counting[0]['level'] == 'B'){
            $count = $counting[0]['cnt']/100*100;
        }elseif($counting[0]['level'] == 'I')
        {
            $count = $counting[0]['cnt']/85*100;
        }else{
            $count = $counting[0]['cnt']/75*100;
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
           $wt = WhiteTagModel::select(DB::raw("COUNT(*) as cnt"),"level")
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
            $item = $wt[0]['cnt'];
            array_push($data,$item);
        }
        $data2 = array_sum($data)/3;
        // if($data2 >= 81.37)
        // {
        //     // set is competent = 1
        //     $user = User::find($id_user);
        //     $user->is_competent = 1;
        //     $user->save();
        // }else{
        //     // set is competent = 0
        //     $user = User::find($id_user);
        //     $user->is_competent = 0;
        //     $user->save();
        // }
        return $data2;
    }


}

<?php

namespace App;

use App\Http\Controllers\SkillCategory;
use Illuminate\Database\Eloquent\Model;

class CompetencieGroup extends Model
{
    protected $guarded = ['id'];
    public function skill_category()
    {
        return $this->belongsTo(SkillCategoryModel::class,'id_skill_category','id_skill_category');
    }
}

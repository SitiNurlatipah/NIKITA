<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillCategoryModel extends Model
{
    protected $table = 'skill_category';
    protected $guarded = ['id'];

    public $timestamps  = false;
}

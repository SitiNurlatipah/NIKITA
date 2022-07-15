<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurriculumModel extends Model
{
    protected $table = 'curriculum';
    protected $fillable = [
        'id_curriculum', 'no_training_module', 'training_module', 'id_skill_category', 'level', 'training_module_group', 'training_module_desc', 'id_job_title'
    ];
    public $timestamps = true;
}

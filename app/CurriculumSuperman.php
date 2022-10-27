<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurriculumSuperman extends Model
{
    protected $table = 'curriculum_superman';
    protected $fillable = [
        'id_curriculum_superman', 'no_curriculum_superman', 'curriculum_superman', 'id_skill_category', 'curriculum_group', 'target', 'curriculum_desc', 'created_at', 'updated_at'
    ];
    public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurriculumToJob extends Model
{
    protected $table = 'curriculum_to_job';
    protected $fillable = [
        'id_curriculum', 'id_job_title'
    ];
    public $timestamps = false;
}

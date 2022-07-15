<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenciesDirectoryModel extends Model
{
    protected $table = 'competencies_directory';
    protected $fillable = [
        'id_directory', 'id_curriculum', 'id_job_title','between_year','target'
    ];
    public $timestamps = false;
}

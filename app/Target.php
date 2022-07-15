<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $guarded = ['id'];
    public function jobtitle()
    {
        return  $this->belongsTo(Jabatan::class,'id_job_title','id_job_title');
    }
}

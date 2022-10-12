<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagementSystem extends Model
{
    protected $guarded = ['id_system'];
    protected $table = 'management_system';
    // public function jobtitle()
    // {
    //     return  $this->belongsTo(Jabatan::class,'id_job_title','id_job_title');
    // }
}

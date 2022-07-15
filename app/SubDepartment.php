<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    protected $table = 'sub_department';
    protected $guarded = ['id'];

    public function department()
    {
        return $this->belongsTo(Department::class,'id_department','id_department');
    }
}

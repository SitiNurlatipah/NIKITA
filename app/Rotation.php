<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rotation extends Model
{
    protected $table = 'rotation_history';
    protected $fillable = [
        'id_rotation', 'id_user', 'cg_old', 'cg_new', 'job_title_old', 'job_title_new', 'date'
    ];

    public $timestamps = false;


}

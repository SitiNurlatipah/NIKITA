<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurriculumSupermanToUser extends Model
{
    protected $table = 'curriculum_superman_to_user';
    protected $fillable = [
        'id_cstu', 'id_curriculum_superman', 'id_user'
    ];
    public $timestamps = false;
}

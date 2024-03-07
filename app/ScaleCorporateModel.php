<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScaleCorporateModel extends Model
{
    protected $table = 'scale_competency_corporate';
    protected $fillable = [
        'id_scale_corporate', 'golongan', 'curriculum_corporate', 'scale_1', 'scale_2', 'scale_3', 'scale_4','scale_5'
    ];
}

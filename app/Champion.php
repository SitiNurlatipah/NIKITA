<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    protected $table = 'curriculum_champion';
    protected $fillable = [
        'id_curriculum_champion', 'no_curriculum_champion', 'curriculum_champion', 'id_skill_category', 'curriculum_group', 'target', 'curriculum_desc', 'created_at', 'updated_at'
    ];
    public $timestamps = true;
}

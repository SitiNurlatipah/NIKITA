<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumActivityLog extends Model
{
    protected $table = 'curriculum_log_activity';
    protected $fillable = [
        'id', 'user_id', 'curriculum_id', 'action'
    ];
    public $timestamps = true;

}

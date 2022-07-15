<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagingReason extends Model
{
    protected $table = 'taging_reason';
    protected $fillable = [
        'id_taging_reason', 'id_white_tag', 'year', 'period', 'date_open', 'learning_method', 'trainer', 'date_plan_implementation', 'notes_learning_implementation', 'date_closed','start','finish','duration','date_verified','id_verified_by','result_score','notes_for_result'
    ];
    public $timestamps = false;
}

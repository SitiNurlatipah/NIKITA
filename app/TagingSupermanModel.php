<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagingSupermanModel extends Model
{
    protected $table = 'tagging_superman';
    protected $fillable = [
        'id_taging_superman', 'id_competency_superman', 'no_taging', 'tahun', 'periode', 'trainer','date_verified','id_verified_by','result_score','notes_for_result'
    ];
    public $timestamps = true;
}

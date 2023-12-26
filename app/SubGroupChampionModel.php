<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGroupChampionModel extends Model
{
    protected $table = 'sub_group_champion';
    protected $fillable = [];
    protected $guarded = ['id_sub_group_champion'];
	protected $primaryKey = 'id_sub_group_champion';
}

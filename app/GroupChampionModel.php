<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChampionModel extends Model
{
    protected $table = 'group_champion';
    protected $fillable = [];
    protected $guarded = ['id_group_champion'];
	protected $primaryKey = 'id_group_champion';
}

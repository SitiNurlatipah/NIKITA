<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChampionToUser extends Model
{
    protected $table = 'curriculum_champion_to_user';
    protected $fillable = [
        'id_cctu', 'id_curriculum_champion', 'id_user'
    ];
    public $timestamps = false;
}

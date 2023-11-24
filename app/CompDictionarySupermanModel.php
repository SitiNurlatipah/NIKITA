<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompDictionarySupermanModel extends Model
{
    protected $table = 'competencies_dictionary_superman';
    protected $fillable = [
        'id_dictionary_superman', 'id_curriculum_superman', 'id_user','target'
    ];
    public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superman extends Model
{
    protected $table = 'competencies_superman';
    
    protected $primaryKey = 'id_competencies_superman';
    public $timestamps = true;
}

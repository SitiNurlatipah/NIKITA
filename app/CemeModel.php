<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CemeModel extends Model
{
    protected $table = 'ceme';
    protected $fillable  = [
        'id_ceme', 'id_user', 'on_the_job_training', 'temporary_back_up', 'full_back_up', 'main_back_up', 'result_multiskill', 'job_title_id', 'created_at', 'updated_at'
    ];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhiteTagHistory extends Model
{
    protected $table = 'white_tag_history';
    protected $fillable = [
        'id_wt_history', 'id_user', 'id_directory', 'id_curriculum', 'id_job_title', 'curriculum', 'nama_pengguna','start', 'actual', 'target', 'keterangan', 'nama_job_title'
    ];
}

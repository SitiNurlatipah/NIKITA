<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagementSystemToUser extends Model
{
    protected $table = 'management_system_to_user';
    protected $fillable = [
        'id_mstu', 'id_user', 'id_system', 'start', 'actual', 'keterangan'
    ];
    // public $timestamps = false;
}

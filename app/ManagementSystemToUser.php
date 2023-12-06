<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagementSystemToUser extends Model
{
    protected $table = 'management_system_to_user';
    protected $guarded = ['id_mstu'];
    // protected $fillable = [
    //     'id_mstu', 'id_user', 'id_system', 'start', 'actual', 'keterangan','no_sertifikat','no_surat_lisensi','masa_berlaku'
    // ];
    // public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'nik', 'password', 'nama_pengguna', 'peran_pengguna', 'email', 'tgl_masuk', 'id_job_title', 'id_divisi', 'id_cg', 'id_department', 'id_subdepartment', 'id_level', 'gambar'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jobTitles()
    {
        return $this->belongsToMany(JobTitleUsers::class,'job_title_users','id_job_title','user_id');
    }

    public function jobTitle()
    {
        return $this->belongsTo(Jabatan::class,'id_job_title','id_job_title');
    }
}

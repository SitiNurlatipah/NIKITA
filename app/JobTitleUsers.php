<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTitleUsers extends Model
{
    protected $table = 'job_title_users';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function jobTitle()
    {
        return $this->belongsTo(Jabatan::class,'job_title_id','id_job_title');
    }

    public function level()
    {
        switch($this->value)
        {
            case 1:
                return 'On The Job Trainning (OJT)';
                break;
            case 2:
                return 'Temporary Back Up';
                break;
            case 3:
              return 'Full Back Up';
                break;
            case 4:
                return  'Main Job';
                break;
            default:
                return 'Tidak Ada';
        }
    }
}

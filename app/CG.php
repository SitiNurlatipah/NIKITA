<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CG extends Model
{
    protected $table = 'cg';
    protected $fillable = [
        'id_cg', 'nama_cg', 'id_department', 'created_at', 'updated_at'
    ];
    public function department()
    {
        return $this->belongsTo(Department::class,'id_department','id_department');
    }
}

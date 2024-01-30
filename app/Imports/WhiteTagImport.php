<?php

namespace App\Imports;

use App\WhiteTagModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str; 

class WhiteTagImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new WhiteTagModel([
            'id_user' => $row[0],
            'id_curriculum' => $row[1],
            'start' => $row[2],
            'actual' => $row[3],
        ]);
    }
    
}

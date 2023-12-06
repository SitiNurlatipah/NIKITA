<?php

namespace App\Imports;

use App\ManagementSystem;
use Maatwebsite\Excel\Concerns\ToModel;

class ManagementSystemImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ManagementSystem([
            'nama_system' => $row[1],
            'description' => $row[2],
            'target' => $row[3],
        ]);
    }
}

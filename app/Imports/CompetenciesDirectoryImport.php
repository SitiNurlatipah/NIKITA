<?php

namespace App\Imports;

use App\CompetenciesDirectoryModel;
use Maatwebsite\Excel\Concerns\ToModel;

class CompetenciesDirectoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CompetenciesDirectoryModel([
            'id_curriculum' => $row[1],
            'id_job_title' => $row[2],
            'between_year' => $row[3],
            'target' => $row[4],
        ]);
    }
}

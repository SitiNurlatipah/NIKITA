<?php

namespace App\Imports;

use App\CurriculumSuperman;
use Maatwebsite\Excel\Concerns\ToModel;

class curriculumSupermanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CurriculumSuperman([
            'no_curriculum_superman' => $row[1],
            'id_skill_category' => $row[2],
            'curriculum_superman' => $row[3],
            'curriculum_group' => $row[4],
            'curriculum_desc' => $row[5],
        ]);
    }
}

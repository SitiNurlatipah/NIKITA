<?php

namespace App\Imports;

use App\ManagementSystemToUser;
use Maatwebsite\Excel\Concerns\ToModel;

class ManagementSystemToUserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ManagementSystemToUser([
            'id_user' => $row[1],
            'id_system' => $row[2],
            'start' => $row[3],
            'actual' => $row[4],
            'no_sertifikat' => $row[5],
            'no_surat_lisensi' => $row[6],
            'masa_berlaku' => $row[7],
            'keterangan' => $row[8],
        ]);
    }
}

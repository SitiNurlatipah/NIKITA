<?php

namespace App\Exports;

use App\WhiteTagModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class WhiteTagExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $select = [
            "nama_pengguna","no_training_module","skill_category","training_module","level","training_module_group","start","actual","target","compGroup.name as groupComp"
        ];
        $cgAuth = Auth::user()->id_cg;
        $cgExtraAuth = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp = Auth::user()->id_department;
        $data = WhiteTagModel::select($select)
                ->join("users","users.id","white_tag.id_user")
                ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
                // ->where("white_tag.actual",">=","cd.target")
                ->when(Auth::user()->id_level == 'LV-0003', function ($query) use ($dp) {
                    // LV-0003 conditions
                    return $query->where('users.id_department', $dp);
                })
                ->when(Auth::user()->id_level == 'LV-0004', function ($query) use ($cgExtraAuth, $cgtambah2, $cgtambah3, $cgtambah4, $cgtambah5) {
                    // LV-0004 conditions
                    return $query->whereIn('users.id_cg', [$cgExtraAuth, $cgtambah2, $cgtambah3, $cgtambah4, $cgtambah5]);
                })
                ->get();
        return $data;
    }

    
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]]
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Anggota',
            'No Competency',
            'Skill Category',
            'Competency',
            'Level',
            'Competency Group',
            'Start',
            'Actual',
            'Target'
        ];
    }

    public function map($softreserve): array
    {
        return [
            $softreserve->nama_pengguna,
            $softreserve->no_training_module,
            $softreserve->skill_category,
            $softreserve->training_module,
            $softreserve->level,
            $softreserve->groupComp,
            $softreserve->start,
            $softreserve->actual,
            $softreserve->target
        ];
    }

}

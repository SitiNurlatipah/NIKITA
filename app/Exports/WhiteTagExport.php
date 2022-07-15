<?php

namespace App\Exports;

use App\WhiteTagModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class WhiteTagExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $select = [
            "nama_pengguna","no_training_module","skill_category","training_module","level","training_module_group","white_tag.start as start","actual","target"
        ];
        $data = WhiteTagModel::select($select)
                ->join("users","users.id","white_tag.id_user")
                ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
                ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
                ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
                ->where("white_tag.actual",">=","cd.target")
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
            $softreserve->training_module_group,
            $softreserve->start,
            $softreserve->actual,
            $softreserve->target
        ];
    }

}

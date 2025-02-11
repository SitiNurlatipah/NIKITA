<?php

namespace App\Exports;
use App\WhiteTagModel;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class TaggingListExport implements FromCollection, WithStyles, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $category;
    protected $all;

    function __construct($category,$all) {
        $this->category = $category;
        $this->all = $all;
    }

    public function collection()
    {
        $select = [
            "tr.no_taging as noTaging","nama_pengguna as employee_name","nama_cg","nik","tr.date_verified",
            "skill_category","training_module","level","training_module_group","white_tag.actual as actual","compGroup.name as compgroup",
            "cd.target as target",DB::raw("(white_tag.actual - cd.target) as actualTarget"),DB::raw("(IF((white_tag.actual - cd.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        switch ($this->category) {
            case '0':
                $whereRaw = "(white_tag.actual < cd.target) OR (SELECT COUNT(*) FROM taging_reason where white_tag.id_white_tag = taging_reason.id_white_tag) > 0";
            break;
            case '1':
                $whereRaw = "(white_tag.actual < cd.target) AND (SELECT COUNT(*) FROM taging_reason where white_tag.id_white_tag = taging_reason.id_white_tag) <= 0";
            break;
            case '2':
                $whereRaw = "(white_tag.actual >= cd.target) AND (SELECT COUNT(*) FROM taging_reason where white_tag.id_white_tag = taging_reason.id_white_tag) > 0";
            break;
        }

        if($this->all == 0){
            $whereRaw .= " AND users.id_cg = '".Auth::user()->id_cg."'";
        }
        $data = WhiteTagModel::select($select)
                ->join("competencies_directory as cd",function ($join){
                    $join->on("cd.id_directory","white_tag.id_directory");
                })
                ->leftJoin("taging_reason as tr","tr.id_white_tag","white_tag.id_white_tag")
                ->join("users","users.id","white_tag.id_user")
                ->join("curriculum","curriculum.id_curriculum","cd.id_curriculum")
                ->join("competencie_groups as compGroup","compGroup.id","curriculum.training_module_group")
                ->join("skill_category as sc","sc.id_skill_category","curriculum.id_skill_category")
                ->join("cg","cg.id_cg","users.id_cg")
                ->whereRaw($whereRaw)
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
            'Date Verified',
            'No Tagging',
            'NIK',
            'Employee Name',
            'Circle Group',
            'Skill Category',
            'Competency',
            'Level',
            'Competency Group',
            'Actual',
            'Target',
            'Status',
            
        ];
    }

    public function map($softreserve): array
    {
        return [
            $softreserve->date_verified,
            $softreserve->noTaging,
            $softreserve->nik,
            $softreserve->employee_name,
            $softreserve->nama_cg,
            $softreserve->skill_category,
            $softreserve->training_module,
            $softreserve->level,
            $softreserve->compgroup,
            $softreserve->actual,
            $softreserve->target,
            $softreserve->tagingStatus,
            
        ];
    }
}

<?php

namespace App\Exports;
use App\Superman;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class TaggingSupermanExport implements FromCollection, WithStyles, WithHeadings, WithMapping, ShouldAutoSize
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
            "id_taging_superman","competencies_superman.id_competencies_superman","tr.no_taging as noTaging","nama_pengguna as employee_name",
            "skill_category","curriculum_superman.curriculum_superman as curriculum_name","nama_cg","nik", "tr.date_verified",
            "curriculum_group","competencies_superman.actual as actual","compGroup.name as compgroup",
            "cd.target as target",DB::raw("(competencies_superman.actual - cd.target) as actualTarget"),DB::raw("(IF((competencies_superman.actual - cd.target) < 0,'Follow Up','Finished' )) as tagingStatus")
        ];
        switch ($this->category) {
            case '0':
                $whereRaw = "(competencies_superman.actual < cd.target) OR (SELECT COUNT(*) FROM tagging_superman where competencies_superman.id_competencies_superman = tagging_superman.id_competency_superman) > 0";
            break;
            case '1':
                $whereRaw = "(competencies_superman.actual < cd.target) AND (SELECT COUNT(*) FROM tagging_superman where competencies_superman.id_competencies_superman = tagging_superman.id_competency_superman) <= 0";
            break;
            case '2':
                $whereRaw = "(competencies_superman.actual >= cd.target) AND (SELECT COUNT(*) FROM tagging_superman where competencies_superman.id_competencies_superman = tagging_superman.id_competency_superman) > 0";
            break;
        }

        if($this->all == 0){
            $whereRaw .= " AND users.id_cg = '".Auth::user()->id_cg."'";
        }
        $data = Superman::select($select)
                ->join("competencies_dictionary_superman as cd",function ($join){
                    $join->on("cd.id_dictionary_superman","competencies_superman.id_cstu");
                })
                ->leftJoin("tagging_superman as tr","tr.id_competency_superman","competencies_superman.id_competencies_superman")
                ->join("users","users.id","competencies_superman.id_user")
                ->join("curriculum_superman","curriculum_superman.id_curriculum_superman","cd.id_curriculum_superman")
                ->join("competencie_groups as compGroup","compGroup.id","curriculum_superman.curriculum_group")
                ->join("skill_category as sc","sc.id_skill_category","curriculum_superman.id_skill_category")
                ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
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
            $softreserve->curriculum_name,
            $softreserve->compgroup,
            $softreserve->actual,
            $softreserve->target,
            $softreserve->tagingStatus,
            
        ];
    }
}

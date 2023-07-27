<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;
use App\User;
use App\Divisi;
use App\Jabatan;
use App\CG;
use App\Level;
use App\SubDepartment;
use App\Department;
use App\Rotation;
use App\WhiteTagHistory;
use App\WhiteTagModel;
use Carbon\Carbon;

class MemberCG extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.member.index');
    }

    public function cgJson()
    {
        $cgtambah = Auth::user()->id_cgtambahan;
        $cgtambah2 = Auth::user()->id_cgtambahan_2;
        $cgtambah3 = Auth::user()->id_cgtambahan_3;
        $cgtambah4 = Auth::user()->id_cgtambahan_4;
        $cgtambah5 = Auth::user()->id_cgtambahan_5;
        $dp= Auth::user()->id_department;
        $id = Auth::user()->id;
        $role = Auth::user()->peran_pengguna;
        if (Auth::user()->peran_pengguna === '2') {
            $cgId = Auth::user()->id_cg;
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->where('users.id_cg', $cgId)
                ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
        } 
        else if (Auth::user()->id_level == 'LV-0003') {
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->where('users.id_department', $dp)
                ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
        } 
        else if (Auth::user()->id_level == 'LV-0004') {
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->where('id', $id)
                ->orWhere('users.id_cg', $cgtambah)
                ->orWhere('users.id_cg', $cgtambah2)
                ->orWhere('users.id_cg', $cgtambah3)
                ->orWhere('users.id_cg', $cgtambah4)
                ->orWhere('users.id_cg', $cgtambah5)
                ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
        } 
        else {
            $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
                ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
                ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
                ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            $btn = '<button class="btn btn-inverse-success btn-icon mr-1" data-toggle="modal" onclick="formEdit('.$row->id.')" data-target="#modal-edit"><i class="icon-file menu-icon"></i></button>';
            $btn = $btn . '<button data-id="' . $row->id . '" class="btn btn-inverse-danger btn-icon member-hapus mr-1" data-toggle="modal" data-target="#modal-hapus"><i class="icon-trash"></i></button>';
            $btn = $btn . '<button type="button" onclick="detail('.$row->id.')" class="btn btn-inverse-info btn-icon" data-toggle="modal" data-target="#modal-detail"><i class="ti-eye"></i></button>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getMember()
    {
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->orderBy('nama_pengguna', 'ASC')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
            return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            'base64' => 'nullable|string',
            'nik' => 'required',
            'password' => 'required',
            'peran_pengguna' => 'required|in:1,2,3',
            'tgl_masuk' => 'required',
            'nama_pengguna' => 'required',
            'email' => 'email|required',
            'divisi' => 'required',
            'job_title' => 'required',
            'level' => 'required',
            'department' => 'required',
            'sub_department' => 'required',
            'cg' => 'required'
        ]);


        DB::beginTransaction();
        try {
            $data = [
                'nik' => $request->nik,
                'password' => bcrypt($request->password),
                'peran_pengguna' => $request->peran_pengguna,
                'tgl_masuk' => date('Y-m-d', strtotime($request->tgl_masuk)),
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'id_divisi' => $request->divisi,
                'id_job_title' => $request->job_title,
                'id_level' => $request->level,
                'id_department' => $request->department,
                'id_sub_department' => $request->sub_department,
                'id_cg' => $request->cg,
                'id_cgtambahan_2' => $request->tambahancg2,
                'id_cgtambahan_3' => $request->tambahancg3,
                'id_cgtambahan_4' => $request->tambahancg4,
                'id_cgtambahan_5' => $request->tambahancg5,
                
            ];

            if (isset($request->base64)) {
                $filename = Str::random(15).'.png';
                $contents = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$request->base64));
                Storage::disk('public')->put($filename, $contents);
                $data['gambar'] = $filename;
            }
            $data = User::insert($data);
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
        return response()->json(['code' => 200, 'message' => 'Post successfully'], 200);
    }

    public function edit(Request $request)
    {
        $user = User::where("id", $request->id)->first();
        $divisi = Divisi::all();
        $jabatans = Jabatan::all();
        $levels = Level::all();
        $departments = Department::all();
        $subDepartments = SubDepartment::where("id_department",$user->id_department)->get();
        $cgMaster = CG::all();
        return view("pages.admin.member.form-edit", compact("user","divisi","jabatans","levels","departments","subDepartments","cgMaster"));
    }

    public function update(Request $request)
    {

        $request->validate([
            "id"=>"required",
            "base64" => "nullable|string",
            "nik" => "required",
            "peran_pengguna" => "required",
            "tgl_masuk" => "required",
            "nama_pengguna" => "required|string",
            "email" => "required",
            "divisi" => "required",
            "job_title" => "required",
            "level" => "required",
            "department" => "required",
            "sub_department" => "required",
            "cg" => "required"
        ]);
        $user = User::where("id", $request->id)->first();

        $data = [
            'nik' => $request->nik,
            'peran_pengguna' => $request->peran_pengguna,
            'tgl_masuk' => date('Y-m-d', strtotime($request->tgl_masuk)),
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'id_divisi' => $request->divisi,
            'id_job_title' => $request->job_title,
            'id_level' => $request->level,
            'id_department' => $request->department,
            'id_sub_department' => $request->sub_department,
            'id_cg' => $request->cg,
            'id_cgtambahan' => $request->tambahancg,
            'id_cgtambahan_2' => $request->tambahancg2,
            'id_cgtambahan_3' => $request->tambahancg3,
            'id_cgtambahan_4' => $request->tambahancg4,
            'id_cgtambahan_5' => $request->tambahancg5,
        ];
        if(isset($request->base64)){
            $url = "../storage/app/public/".$user->gambar;
            if(file_exists($url) && (isset($user->gambar)) && $user->gambar != ""){
                unlink($url);
            }
            $filename = Str::random(15).'.png';
            $contents = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$request->base64));
            Storage::disk('public')->put($filename, $contents);
            $data['gambar'] = $filename;
        }
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        User::where('id',$request->id)->update($data);
        return response()->json(['code' => 200, 'message' => 'Post Updated successfully'], 200);
    }

    public function deleteMember($id)
    {
        $user = User::find($id);
        $url = "../storage/app/public/".$user->gambar;
        if(file_exists($url) && isset($user->gambar)){
            unlink($url);
        }
        User::where('id', $id)->delete();
        return redirect()->route('EmployeeMember')->with(['success' => 'Curriculum Deleted successfully']);
    }

    public function detail(Request $request)
    {
        $this->validate($request,[
            "id"=>"required|numeric"
        ]);
        $select = [
            "nama_pengguna","nik","email","gambar",DB::raw("DATE_FORMAT(tgl_masuk,'%d-%m-%y') AS tgl_masuk"),"jt.nama_job_title","divisi.nama_divisi","dprtm.nama_department","s_dprtm.nama_subdepartment","level.nama_level","nama_cg","role", "is_system_management", "is_champion", "is_superman", "is_competent"
        ];
        $user = User::select($select)
                    ->leftJoin("role","role.id_role","peran_pengguna")
                    ->leftJoin("divisi","divisi.id_divisi","users.id_divisi")
                    ->leftJoin("job_title as jt","jt.id_job_title","users.id_job_title")
                    ->leftJoin("level","level.id_level","users.id_level")
                    ->leftJoin("department as dprtm","dprtm.id_department","users.id_department")
                    ->leftJoin("sub_department as s_dprtm","s_dprtm.id_subdepartment","users.id_sub_department")
                    ->leftJoin("cg","cg.id_cg","users.id_cg")
                    ->leftJoin("management_system_to_user as mstu","mstu.id_user","users.id")
                    ->where("id",$request->id)
                    ->first();

        $counting = WhiteTagModel::select(DB::raw("COUNT(*) as cnt"),"level")
                                ->join("competencies_directory as cd","cd.id_directory","white_tag.id_directory")
                                ->join("users",function ($join) use ($request){
                                    $join->on("users.id","white_tag.id_user")
                                ->whereRaw("white_tag.id_user = '".$request->id."' AND white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0");
                                    // ->where([
                                    //     ["white_tag.id_user",$request->id],
                                    //     ["white_tag.actual",">=","cd.target"],

                                    // ]);
                                })
                                ->join("curriculum as crclm","crclm.id_curriculum","cd.id_curriculum")
                                ->groupBy("level")
                                ->get();
            $select_open = [
            "nama_pengguna","no_training_module",
            DB::raw("COUNT(*) as cnt", "(IF(actual < target,'Open','Close' )) as tagingStatus")
        ];
        $data_open = WhiteTagModel::select($select_open)
            ->join("users","users.id","white_tag.id_user")
            ->join("competencies_directory AS cd","cd.id_directory","white_tag.id_directory")
            ->join("curriculum AS crclm","crclm.id_curriculum","cd.id_curriculum")
            ->join("competencie_groups as compGroup","compGroup.id","crclm.training_module_group")
            ->join("skill_category AS sc","sc.id_skill_category","crclm.id_skill_category")
            // ->whereRaw("white_tag.actual >= cd.target AND white_tag.actual > 0 AND white_tag.start >= 0")
            ->whereRaw("white_tag.actual < cd.target")
            ->where("users.id", $request->id)
            ->get();


        return view('pages.admin.member.detail',compact('user','counting', 'data_open'));
    }

    public function memberRotation(Request $request){
        $messages = [
            'required' => ':attribute wajib diisi !',
        ];

        $this->validate($request,[
            "user_rotation" => "required",
            "jabatan_rotation" => "required",
            "cg_rotation" => "required",
        ]);

        $id_user = $request->user_rotation;
        $id_job_title = $request->jabatan_rotation;
        $id_cg = $request->cg_rotation;

        try {
        DB::beginTransaction();

        // id_cg old form users
        $data_user = DB::table('users')->find($id_user);

        //insert data to history
        $data_rotate = [
            'id_user' => $id_user,
            'job_title_old' => $data_user->id_job_title,
            'job_title_new' => $id_job_title,
            'cg_old' => $data_user->id_cg,
            'cg_new' => $id_cg,
            'date' => Carbon::now(),
        ];
        $rotation = Rotation::create($data_rotate);
        $rotation->save();

        //get data white tag
        $data_whitetag =  DB::table('white_tag')
                            ->leftJoin('competencies_directory', 'white_tag.id_directory', '=' ,'competencies_directory.id_directory' )
                            ->leftJoin('users', 'white_tag.id_user', '=' ,'users.id')
                            ->leftJoin('cg', 'users.id_cg', '=' ,'cg.id_cg')
                            ->leftJoin('curriculum', 'competencies_directory.id_curriculum', '=' ,'curriculum.id_curriculum')
                            ->leftJoin('job_title', 'competencies_directory.id_job_title', '=' ,'job_title.id_job_title')
                            ->where('white_tag.id_user', $id_user)
                            ->select('white_tag.id_user', 'white_tag.id_directory', 'curriculum.id_curriculum', 'curriculum.training_module', 'users.nama_pengguna', 'white_tag.start', 'white_tag.actual', 'competencies_directory.target', 'white_tag.keterangan', 'job_title.id_job_title', 'job_title.nama_job_title')
                            ->get();
                            //insert data into white tag history
                            foreach ($data_whitetag as $history) {
                                $history = WhiteTagHistory::create(
                                    [
                                        'id_user' => $history->id_user,
                                        'id_directory' => $history->id_directory,
                                        'id_curriculum' => $history->id_curriculum,
                                        'id_job_title' => $history->id_job_title,
                                        'curriculum' => $history->training_module,
                                        'nama_pengguna' => $history->nama_pengguna,
                                        'start' => $history->start,
                                        'actual' => $history->actual,
                                        'target' => $history->target,
                                        'keterangan' => $history->keterangan,
                                        'nama_job_title' => $history->nama_job_title,
                                    ]
                                );
                                $history->save();
                            }
        // delete data table white tag
        $deleteWT = WhiteTagModel::where('id_user', $id_user);
        $deleteWT->delete();
        // Update data user
        $data = [
            'id_job_title' => $id_job_title,
            'id_cg' => $id_cg,
        ];
        User::where('id',$id_user)->update($data);


        DB::commit();
            return response()->json(['code' => 200, 'message' => 'Rotation successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage(),'message'=> $messages],402);

        }
    }

    public function getDivisi()
    {
        $provinsi = Divisi::all();
        return response()->json([
            'data' => $provinsi,
            'status' => 200,
            'success' => true,
        ]);
    }

    public function getLevel()
    {
        $provinsi = Level::all();
        return response()->json([
            'data' => $provinsi,
            'status' => 200,
            'success' => true,
        ]);
    }

    public function getJabatan()
    {
        $provinsi = Jabatan::all();
        return response()->json([
            'data' => $provinsi,
            'status' => 200,
            'success' => true,
        ]);
    }

    public function getDepartment()
    {
        $provinsi = Department::all();
        return response()->json([
            'data' => $provinsi,
            'status' => 200,
            'success' => true,
        ]);
    }

    public function getSubDepartment(Request $request)
    {
        if(isset($request->id_department)){
            $provinsi = SubDepartment::where("id_department",$request->id_department)->get();
        }else{
            $provinsi = SubDepartment::all();
        }
        return response()->json([
            'data' => $provinsi,
            'status' => 200,
            'success' => true,
        ]);
    }

    public function getLigaCG()
    {
        $provinsi = CG::all();
        return response()->json([
            'data' => $provinsi,
            'status' => 200,
            'success' => true,
        ]);
    }
}

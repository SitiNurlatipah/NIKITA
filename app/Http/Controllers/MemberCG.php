<?php

namespace App\Http\Controllers;

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
use App\WhiteTagModel;
class MemberCG extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.member.index');
    }

    public function cgJson()
    {
        $data = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')
            ->leftJoin('job_title as jt', 'users.id_job_title', '=', 'jt.id_job_title')
            ->leftJoin('cg as cg', 'users.id_cg', '=', 'cg.id_cg')
            ->get(['users.*', 'dp.nama_department', 'jt.nama_job_title']);
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

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            'base64' => 'nullable|string',
            'nik' => 'required|numeric',
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
                'password' => $request->password,
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
        return redirect()->route('Member')->with(['success' => 'Curriculum Deleted successfully']);
    }

    public function detail(Request $request)
    {
        $this->validate($request,[
            "id"=>"required|numeric"
        ]);
        $select = [
            "nama_pengguna","nik","email","gambar",DB::raw("DATE_FORMAT(tgl_masuk,'%d-%m-%y') AS tgl_masuk"),"jt.nama_job_title","divisi.nama_divisi","dprtm.nama_department","s_dprtm.nama_subdepartment","level.nama_level","nama_cg","role"
        ];
        $user = User::select($select)
                    ->leftJoin("role","role.id_role","peran_pengguna")
                    ->leftJoin("divisi","divisi.id_divisi","users.id_divisi")
                    ->leftJoin("job_title as jt","jt.id_job_title","users.id_job_title")
                    ->leftJoin("level","level.id_level","users.id_level")
                    ->leftJoin("department as dprtm","dprtm.id_department","users.id_department")
                    ->leftJoin("sub_department as s_dprtm","s_dprtm.id_subdepartment","users.id_sub_department")
                    ->leftJoin("cg","cg.id_cg","users.id_cg")
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

        return view('pages.admin.member.detail',compact('user','counting'));
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

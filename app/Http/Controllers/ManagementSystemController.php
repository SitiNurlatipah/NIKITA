<?php

namespace App\Http\Controllers;

use App\ManagementSystem;
use App\ManagementSystemToUser;
use App\User;
use App\CurriculumModel;
use App\WhiteTagModel;
use Validator;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Imports\ManagementSystemImport;
use App\Imports\ManagementSystemToUserImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ManagementSystemController extends Controller
{
    public function indexMaster()
    {
        $system = ManagementSystem::get();
        return view('pages.admin.system.index-master',compact('system'));
    }
    public function systemJson(){
        $system=ManagementSystem::get();
        return Datatables::of($system)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $buttons = '<button data-id="' . $item->id_system . '" data-nama_system="' . $item->nama_system . '" data-description="' . $item->description . '" data-target="' . $item->target . '"  
                class="btn btn-inverse-success btn-icon delete-button mr-1 mr-1 btnEdit"><i
                class="icon-file menu-icon"></i></button>';
                $buttons .= '<button data-id="' . $item->id_system . '" class="btn btn-inverse-danger btn-icon mr-1 btnHapus"><i class="icon-trash"></i></button>';
                return $buttons;
            }) 
            ->editColumn('target', function ($row) {
                switch($row->target){
                    case 0:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/0.png').'"></div>';
                    break;
                    case 1:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/1.png').'"></div>';
                    break;
                    case 2:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/2.png').'"></div>';
                    break;
                    case 3:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/3.png').'"></div>';
                    break;
                    case 4:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/4.png').'"></div>';
                    break;
                    case 5:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img class="img-thumbnail mx-auto" src="'.asset('assets/images/point/5.png').'"></div>';
                    break;
    
                }
                return $icon;
            })
              
            ->addIndexColumn()
            ->rawColumns(['action','target'])
            ->make(true);
    }
    public function storeMaster()
    {
        $validator = Validator::make(request()->all(),[
            'nama_system' => ['required'],
            'description' => ['required']
        ]);

        if($validator->fails())
        {
            $response = [
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'data' => NULL
            ];
            return response()->json($response);
        }

        $id = request('id');
        if($id)
        {
            $data = ManagementSystem::where('id_system',$id)->update([
                'nama_system' => request('nama_system'),
                'description' => request('description'),
                'target' => request('target')
            ]);
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Target berhasil diupdate.',
                'data' => $data
            ];

        }else{
            $data = ManagementSystem::create([
                'nama_system' => request('nama_system'),
                'description' => request('description'),
                'target' => request('target')
            ]);

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Target berhasil ditambahkan.',
                'data' => $data
            ];
        }

        return response()->json($response);
    }

    public function destroyMaster()
    {
        $validator = Validator::make(request()->all(),[
            'id' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id');
        ManagementSystem::where('id_system',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Target berhasil dihapus.',
            'data' => NULL
        ];
        return response()->json($response);
    }

    public function importSertifikasi(Request $request){
        try {
            Excel::import(new ManagementSystemImport, $request->file('file'));
            return response()->json([
                'status' => 'success',
                'message' => 'Sukses import data'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal import data: ' . $e->getMessage()
            ]);
        }
    }

    public function index()
    {
        $items = ManagementSystemToUser::
        leftJoin('management_system as ms', 'management_system_to_user.id_system', '=', 'ms.id_system')
        ->leftJoin('users', 'management_system_to_user.id_user', '=', 'users.id')
        ->get(['management_system_to_user.*', 'users.nama_pengguna', 'ms.nama_system', 'ms.id_system', 'ms.target' , 'users.id', 'ms.description']);
        $user=User::get(['id','nama_pengguna']);
        $module=ManagementSystem::get(['id_system','nama_system']);
        return view('pages.admin.system.index',compact('items','user','module'));
    }
    public function systemUserJson(){
        $data = ManagementSystemToUser::
        leftJoin('management_system as ms', 'management_system_to_user.id_system', '=', 'ms.id_system')
        ->leftJoin('users', 'management_system_to_user.id_user', '=', 'users.id')
        ->get(['management_system_to_user.*', 'users.nama_pengguna', 'ms.nama_system', 'ms.id_system', 'ms.target' , 'users.id', 'ms.description']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $buttons = '<button data-id="' . $item->id_mstu . '" data-nama="' . $item->id . '" data-system="' . $item->id_system . '" data-target="' . $item->target . '" data-sertif="' . $item->no_sertifikat . '" data-start="' . $item->start . '" data-actual="' . $item->actual . '" data-surat="' . $item->no_surat_lisensi . '" data-masa-sertif="' . $item->masa_berlaku_sertif . '" data-masa-lisensi="' . $item->masa_berlaku_lisensi . '" data-keterangan="' . $item->keterangan . '" 
                class="btn btn-inverse-success btn-icon delete-button mr-1 mr-1 btnEdit"><i
                class="icon-file menu-icon"></i></button>';
                $buttons .= '<button data-id="' . $item->id_mstu . '" class="btn btn-inverse-danger btn-icon mr-1 btnHapus"><i class="icon-trash"></i></button>';
                return $buttons;
            })   
            ->editColumn('start', function ($row) {
                switch($row->start){
                    case 0:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img class="img-thumbnail mx-auto tooltip-info" src="'.asset('assets/images/point/0.png').'"></div>';
                    break;
                    case 1:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img src="'.asset('assets/images/point/1.png').'"></div>';
                    break;
                    case 2:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img src="'.asset('assets/images/point/2.png').'"></div>';
                    break;
                    case 3:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img src="'.asset('assets/images/point/3.png').'"></div>';
                    break;
                    case 4:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img src="'.asset('assets/images/point/4.png').'"></div>';
                    break;
                    case 5:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->start.'" class="mx-auto"><img src="'.asset('assets/images/point/5.png').'"></div>';
                    break;
    
                }
                return $icon;
            })
            ->editColumn('actual', function ($row) {
                switch($row->actual){
                    case 0:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img src="'.asset('assets/images/point/0.png').'"></div>';
                    break;
                    case 1:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img src="'.asset('assets/images/point/1.png').'"></div>';
                    break;
                    case 2:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img src="'.asset('assets/images/point/2.png').'"></div>';
                    break;
                    case 3:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img src="'.asset('assets/images/point/3.png').'"></div>';
                    break;
                    case 4:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img src="'.asset('assets/images/point/4.png').'"></div>';
                    break;
                    case 5:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->actual.'" class="mx-auto"><img src="'.asset('assets/images/point/5.png').'"></div>';
                    break;
    
                }
                return $icon;
            })
            ->editColumn('target', function ($row) {
                switch($row->target){
                    case 0:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img src="'.asset('assets/images/point/0.png').'"></div>';
                    break;
                    case 1:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img src="'.asset('assets/images/point/1.png').'"></div>';
                    break;
                    case 2:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img src="'.asset('assets/images/point/2.png').'"></div>';
                    break;
                    case 3:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img src="'.asset('assets/images/point/3.png').'"></div>';
                    break;
                    case 4:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img src="'.asset('assets/images/point/4.png').'"></div>';
                    break;
                    case 5:
                        $icon = '<div style="width:50px;heigth:50px" title="'.$row->target.'" class="mx-auto"><img src="'.asset('assets/images/point/5.png').'"></div>';
                    break;
                }
                return $icon;
            })         
            ->addIndexColumn()
            ->rawColumns(['action','start','actual','target'])
            ->make(true);
    }
    public function store(Request $request)
    {
        // dd(request()->all());
        $validator = Validator::make(request()->all(),[
            'user' => ['required'],
            'system' => ['required'],
            'start' => ['required'],   
            'actual' => ['required'],   
            'keterangan' => ['nullable'],   
            'masa_berlaku_sertif' => ['nullable'],   
            'masa_berlaku_lisensi' => ['nullable'],   
        ]);

        if($validator->fails())
        {
            $response = [
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'data' => NULL
            ];
            return response()->json($response);
        }

        $id = request('id');

        if($id)
        {
            $data = ManagementSystemToUser::where('id_mstu',$id)->update([
                'id_user' => request('user'),
                'id_system' => request('system'),
                'start' => request('start'),
                'actual' => request('actual'),
                'keterangan' => request('keterangan'),
                'masa_berlaku_sertif' => request('masa_berlaku_sertif'),
                'masa_berlaku_lisensi' => request('masa_berlaku_lisensi'),
                'no_surat_lisensi' => request('no_surat_lisensi'),
                'no_sertifikat' => request('no_sertifikat'),
            ]);
            $id_user =  request('user');
            $start =  request('start');
            $actual =  request('actual');
            $insert = [];
            for ($i = 0; $i < count($request->id_curriculum); $i++) {
                $insert[$i] = [
                    'id_user' => $id_user,
                    'id_curriculum' => $request->id_curriculum[$i],
                    'actual' => $actual,
                    'start' => $start,
                    "id_white_tag"=> $this->random_string(5,5,false).time(),
                ];
            }

            if (count($insert) > 0) {
                foreach ($insert as $data) {
                    DB::table('white_tag')->updateOrInsert(
                        ['id_user' => $id_user, 'id_curriculum' => $data['id_curriculum']],
                        ['id_white_tag' => $data['id_white_tag'], 'start' => $data['start'], 'actual' => $data['actual']]
                    );
                }
            }
        $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Enroll system berhasil diupdate.',
                'data' => $data
            ];
        }else{
            $data = ManagementSystemToUser::create([
                'id_user' => request('user'),
                'id_system' => request('system'),
                'start' => request('start'),
                'actual' => request('actual'),
                'keterangan' => request('keterangan'),
                'masa_berlaku_sertif' => request('masa_berlaku_sertif'),
                'masa_berlaku_lisensi' => request('masa_berlaku_lisensi'),
                'no_surat_lisensi' => request('no_surat_lisensi'),
                'no_sertifikat' => request('no_sertifikat'),
            ]);
            $data = User::where('id',request('user'))->update([
                'is_system_management' => 1,
            ]);
            $id_user =  $request->user;
            $start =  $request->start;
            $actual =  $request->actual;
            $insert = [];
            for ($i = 0; $i < count($request->id_curriculum); $i++) {
                $insert[$i] = [
                    'id_user' => $id_user,
                    'id_curriculum' => $request->id_curriculum[$i],
                    'actual' => $actual,
                    'start' => $start,
                    "id_white_tag"=> $this->random_string(5,5,false).time(),
                ];
            }

            if (count($insert) > 0) {
                foreach ($insert as $data) {
                    DB::table('white_tag')->updateOrInsert(
                        ['id_user' => $id_user, 'id_curriculum' => $data['id_curriculum']],
                        ['id_white_tag' => $data['id_white_tag'], 'start' => $data['start'], 'actual' => $data['actual']]
                    );
                }
            }
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Enroll system berhasil ditambahkan.',
                'data' => $data
            ];
        }

        return response()->json($response);
    }

    public function destroy()
    {
        $validator = Validator::make(request()->all(),[
            'id_mstu' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id_mstu');
        ManagementSystemToUser::where('id_mstu',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Sertifikasi berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

    }
    
    public function importSertifikasiMember(Request $request)
    {
        try {
            Excel::import(new ManagementSystemToUserImport, $request->file('file'));
            return response()->json([
                'status' => 'success',
                'message' => 'Sukses import data'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal import data: ' . $e->getMessage()
            ]);
        }
    }

    public function getSystem()
    {
        $system = ManagementSystem::all();
        return response()->json([
            'data' => $system,
            'status' => 200,
            'success' => true,
        ]);
    }

    public function getTarget(Request $request)
    {
        $id = $request->id;
        $items = ManagementSystem::where('id_system',$id)->get('target');
        return response()->json($items);
    }
    public function getMember()
    {
        $users = User::leftJoin('department as dp', 'users.id_department', '=', 'dp.id_department')->get(['nama_pengguna','nama_department','id']);
        return response()->json([
            'data' => $users,
            'status' => 200,
            'success' => true,
        ]);
    }
    public function getCurriculum()
    {
        $curriculum = CurriculumModel::get(['training_module','id_curriculum']);
        return response()->json([
            'data' => $curriculum,
            'status' => 200,
            'success' => true,
        ]);
    }
}

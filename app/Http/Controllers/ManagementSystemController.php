<?php

namespace App\Http\Controllers;

use App\ManagementSystem;
use App\ManagementSystemToUser;
use App\Target;
use Validator;
use Illuminate\Http\Request;

class ManagementSystemController extends Controller
{
    public function indexMaster()
    {
        $system = ManagementSystem::get();
        return view('pages.admin.system.index-master',compact('system'));
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
                'description' => request('description')
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
                'description' => request('description')
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


    public function index()
    {
        $items = ManagementSystemToUser::
        leftJoin('management_system as ms', 'management_system_to_user.id_system', '=', 'ms.id_system')
        ->leftJoin('users', 'management_system_to_user.id_user', '=', 'users.id')
        ->get(['users.nama_pengguna', 'ms.nama_system']);

        return view('pages.admin.system.index',compact('items'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(),[
            'user' => ['required'],
            'system' => ['required']
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
            ]);
            $response = [
                 'code' => 200,
                 'status' => 'success',
                 'message' => 'Target berhasil diupdate.',
                 'data' => $data
             ];

        }else{
            $data = ManagementSystemToUser::create([
                'id_user' => request('user'),
                'id_system' => request('system'),
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

    public function destroy()
    {
        $validator = Validator::make(request()->all(),[
            'id_mstu' => ['required']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $id = request('id');
        Target::where('id_mstu',$id)->delete();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Target berhasil dihapus.',
            'data' => NULL
        ];

        return response()->json($response);

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
}

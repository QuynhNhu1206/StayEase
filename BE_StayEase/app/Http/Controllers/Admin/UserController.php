<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $users = User::findOrFail($userId);
        return response()->json([
            'status'=>'success',
            'data'=> $users
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        //$id_user = Auth::id();
        $users = User::findOrFail($id);

        $data = $request->all();
        $file = $request->avatar;

        if(!empty($file)){
            $data['avatar'] = $file->getClientOriginalName();
        }

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        }else{
            $data['password'] = $users->password;
        }

        $dirPath = public_path('upload/user/avatar/' . $id);
                if (!file_exists($dirPath)) {
                    mkdir($dirPath, 0777, true);
                }
        if ($users->update($data)) {
            if(!empty($file)){
                $file->move($dirPath.'/', $file->getClientOriginalName());
            }
            return response()->json([
                'status'=>'success',
                'message'=>'Cập nhật thông tin thành công',
                'data'=> $data
            ], 201);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa user thành công',
                'data' => User::all()

            ], 200);
        }
    }
}

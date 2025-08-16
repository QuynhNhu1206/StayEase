<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
 /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
         $data = [
            'username' => $request->input('username'),
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'ngay_sinh'=>$request->input('ngay_sinh'),
            'que_quan'  => $request->input('que_quan'),
            'so_dien_thoai'    => $request->input('so_dien_thoai'),
            'level'    => 1,
            'password' => bcrypt($request->input('password')),
            'gioi_tinh'=>$request->input('gioi_tinh'),
            'cccd'=>$request->input('cccd'),
        ];


        if (User::create($data)) {
            return response()->json([
                'status'=>'success',
                'message'=>'Đăng ký tài khoản thành công',
                'data' => $data
            ]);
        }
    }


}

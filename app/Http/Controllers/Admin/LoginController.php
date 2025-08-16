<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
     /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    public function store(LoginRequest $request)
{
    $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $credentials = [
        $loginField => $request->login,
        'password' => $request->password
    ];

    $remember = $request->remember_me ? true : false;

    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();


        if ($user->level != 1) {
            Auth::logout();
            return response()->json([
                'status' => 'error',
                'message' => 'Tài khoản không có quyền đăng nhập'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng nhập thành công',
            'data' => $user
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Email/Username hoặc mật khẩu không chính xác'
    ], 401);
}

}

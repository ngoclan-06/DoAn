<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthServices;

class LoginController extends Controller
{
    protected $authServices;
    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function viewLogin()
    {
        return view('auth.login');
    }
    public function login(LoginRequest $request)
    {
        $email_address = $request->email_address;
        $password = $request->password;
        $remember = $request->has('remember');
        $user = $this->authServices->login($email_address, $password, $remember);
        // $isAdmin = $this->authServices->isAdmin(Auth::user());
        // dd($user);
        // if ($user->deleted_at != NULL) {
            if ($user) {
                if ($this->authServices->isAdmin($user)) {
                    return redirect()->route('home');
                } else {
                    return redirect()->back()->with([
                        'Forbidden' => 'Bạn không có quyền truy cập trang này.'
                    ]);
                }
            } else {
                return redirect()->back()->with([
                    'Unauthorized' => 'Email hoặc mật khẩu không đúng.'
                ]);
            }
        // }else{
        //     return redirect()->back()->with([
        //         'error' => 'Tài khoản của bạn đã bị vô hiệu hóa! Vui lòng liên hệ đến SĐT: 0978084301.'
        //     ]);
        // }
    }

    public function logout()
    {
        $this->authServices->logout();

        return redirect()->route('view-login');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthServices;

class RegisterAdminController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthServices();
    }
    public function viewRegister()
    {
        return view('auth.register_admin');
    }

    public function registerAdmin(RegisterRequest $request)
    {
        $user = $this->authService->register($request);
        if ($user) {
            return redirect()->route('view-login')->with('success', 'Bạn đã đăng ký tài khoản thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra vui lòng thử lại!');
        }
    }
}

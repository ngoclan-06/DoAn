<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAdminRequest;
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

    public function registerAdmin(RegisterAdminRequest $request)
    {
        $user = $this->authService->registerAdmin($request);
        if ($user) {
            return redirect()->route('view-login')->with('success', 'Bạn đã đăng ký tài khoản thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra vui lòng thử lại!');
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\AuthServices;

class ChangePassword extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthServices();
    }
    public function viewChangePassword()
    {
        return view('backend.layouts.changePassword');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');

        $result = $this->authService->changePassword($currentPassword, $newPassword);

        if ($result) {
            return redirect()->route('home')->with('success', 'Thay đổi mật khẩu thành công.');
        } else {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }
    }
}

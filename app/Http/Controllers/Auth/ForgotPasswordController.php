<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthServices;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function ViewForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }
   
    public function sendResetLinkEmail(Request $request, AuthServices $AuthServices)
    {
        // $this->validateEmail($request);
        $sent = $AuthServices->sendResetLinkEmail($request->email_address);

        if ($sent) {
            return back()->with('status', 'Chúng tôi đã gửi email liên kết đặt lại mật khẩu của bạn!');
        } else {
            return back()->withErrors(['email' => 'Chúng tôi không thể tìm thấy người dùng có địa chỉ email đó.']);
        }
    }
}

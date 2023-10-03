<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\password_resets;
use App\Models\User;
use App\Services\AuthServices;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $reset = password_resets::where('token', $request->token)
            ->where('email_address', $request->email_address)
            ->first();

        if (!$reset) {
            return back()->with('error', 'Đã xảy ra lỗi. Địa chỉ email chưa chính xác.');
        }

        $user = User::where('email_address', $request->email_address)->first();

        if (!$user) {
            return back()->with('error', 'Đã xảy ra lỗi. Địa chỉ email chưa chính xác.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $reset->delete();

        if ($user->role == 1 || $user->role == 2) {
            return redirect()->route('view-login')->with('success', 'Bạn đã thay đổi mật khẩu thành công.');
        } else {
            return redirect()->route('user.view-login')->with('success', 'Bạn đã thay đổi mật khẩu thành công.');
        }
    }
}

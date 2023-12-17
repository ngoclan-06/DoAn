<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\Wishlist;
use App\Models\categories;
use App\Services\FrontendServices;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class LoginFeController extends Controller
{
    protected $frontendServices;

    public function __construct(FrontendServices $frontendServices)
    {
        $this->frontendServices = $frontendServices;
    }

    public function viewLogin()
    {
        $carts = cart::get();
        $wishlists = Wishlist::get();
        $category = categories::where('status', 1)->get();
        return view('frontend.pages.login', compact('category', 'carts', 'wishlists'));
    }

    public function login(LoginRequest $request)
    {
        $email_address = $request->email_address;
        $password = $request->password;
        $remember = $request->has('remember');
        $user = $this->frontendServices->login($email_address, $password, $remember);

        if ($user) {
            // Sử dụng Auth::user() thay vì Auth()->user()
            if (Auth::user()->role == 0) {
                return redirect()->route('home-user');
            } else {
                return redirect()->back()->with('error', 'Tài khoản không thể truy cập vào trang web này!');
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Email hoặc mật khẩu không đúng.'
            ]);
        }
    }
    public function logout()
    {
        $this->frontendServices->logout();
        return redirect()->route('user.view-login');
    }
    public function viewRegister()
    {
        $carts = cart::get();
        $wishlists = Wishlist::get();
        $category = categories::where('status', 1)->get();
        return view('frontend.pages.register', compact('category', 'carts', 'wishlists'));
    }
    public function register(RegisterRequest $registerRequest)
    {
        $user = $this->frontendServices->register($registerRequest);
        if ($user) {
            return redirect()->route('user.view-login')->with('success', 'Bạn đã đăng ký tài khoản thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra vui lòng thử lại!');
        }
    }
}

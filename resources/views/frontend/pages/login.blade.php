{{-- @extends('frontend.layouts.master') --}}

{{-- @section('title', 'HaVyBakery || Login Page') --}}

{{-- @section('main-content') --}}
    <!-- Breadcrumbs -->
    {{-- <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home-user') }}">Trang chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Đăng nhập</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Breadcrumbs -->

    @include('frontend.layouts.head')	
    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Đăng nhập</h2>
                        <p>Vui lòng đăng ký để thanh toán nhanh hơn</p>
                        <!-- Form -->
                        <form class="form" method="post" action="{{ route('user.login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email<span>*</span></label>
                                        <input type="email" name="email_address" placeholder=""
                                            value="{{ old('email_address') }}">
                                        @error('email_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mật khẩu<span>*</span></label>
                                        <input type="password" name="password" placeholder=""
                                            value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Đăng nhập</button>
                                        <a href="{{ route('user.view-register') }}" class="btn">Đăng ký</a>
                                        HOẶC
                                        <a href="{{ route('google.login') }}" class="btn btn-google" style="background-color: #ea4335; color:#fff;"><i class="ti-google"></i></a>

                                    </div>
                                    <div class="checkbox">
                                        <label class="checkbox-inline" for="2"><input name="remember" id="2"
                                                type="checkbox">Nhớ tài khoản</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="lost-pass" href="{{ route('password.request') }}">
                                            Bạn quên mật khẩu?
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->
{{-- @endsection --}}
@push('styles')
    <style>
        .shop.login .form .btn {
            margin-right: 0;
        }

        .btn-facebook {
            background: #39579A;
        }

        .btn-facebook:hover {
            background: #073088 !important;
        }

        .btn-github {
            background: #444444;
            color: white;
        }

        .btn-github:hover {
            background: black !important;
        }

        .btn-google {
            background: #ea4335;
            color: white;
        }

        .btn-google:hover {
            background: rgb(243, 26, 26) !important;
        }
    </style>
@endpush

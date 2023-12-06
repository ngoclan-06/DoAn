@extends('frontend.layouts.master')

@section('title','E-SHOP || Register Page')

@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home-user')}}">Trang chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Đăng ký</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
            
    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row"> 
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Đăng ký</h2>
                        <p>Vui lòng đăng ký để thanh toán nhanh hơn</p>
                        <!-- Form -->
                        <form class="form" method="post" action="{{route('user.register')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>tên khách hàng:<span>*</span></label>
                                        <input type="text" name="name" placeholder="Enter your name" value="{{old('name')}}">
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Địa chỉ:<span>*</span></label>
                                        <input type="text" name="address" placeholder="Enter your email" value="{{old('address')}}">
                                        @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Số điện thoại:<span>*</span></label>
                                        <input type="text" name="phone" placeholder="Enter your email" value="{{old('phone')}}">
                                        @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email:<span>*</span></label>
                                        <input type="text" name="email_address" placeholder="Enter your email" value="{{old('email_address')}}">
                                        @error('email_address')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mật khẩu:<span>*</span></label>
                                        <input type="password" name="password" placeholder="Enter your password"  value="{{old('password')}}">
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nhập lại mật khẩu:<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="Enter your password confirmation" value="{{old('password_confirmation')}}">
                                        @error('password_confirmation')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Đăng ký</button>
                                        <a href="{{route('user.view-login')}}" class="btn">Đăng nhập</a>
                                        HOẶC
                                        {{-- <a href="" class="btn btn-facebook"><i class="ti-facebook"></i></a> --}}
                                        {{-- <a href="" class="btn btn-github"><i class="ti-github"></i></a> --}}
                                        <a href="{{ route('google.login') }}" class="btn btn-google"><i class="ti-google"></i></a>
                                    </div>
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
@endsection

@push('styles')
<style>
    .shop.login .form .btn{
        margin-right:0;
    }
    .btn-facebook{
        background:#39579A;
    }
    .btn-facebook:hover{
        background:#073088 !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:white;
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
</style>
@endpush
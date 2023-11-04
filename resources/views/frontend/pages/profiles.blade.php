@extends('frontend.layouts.master')

@section('title', 'HaVyBakery || Profiles')
@section('main-content')
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bread-inner">
                            <ul class="bread-list">
                                <li><a href="index1.html">Trang chủ<i class="ti-arrow-right"></i></a></li>
                                <li class="active"><a href="blog-single.html">Thông tin cá nhân</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="image">
                            @if ($profile->image != null)
                                <img class="card-img-top img-fluid roundend-circle mt-4"
                                    style="border-radius:50%;height:200px;width:200px;margin-left: 150px;"
                                    src="{{ asset('image/user/' . $profile->image) }}" alt="profile picture">
                            @else
                                <img class="card-img-top img-fluid roundend-circle mt-4"
                                    style="border-radius:50%;height:200px;width:200px;margin-left: 150px;"
                                    src="{{ asset('backend/img/avatar.png') }}" alt="profile picture">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <form class="border px-4 pt-2 pb-3" method="POST"
                        action="{{ route('user.update.profile', $profile->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputTitle" class="col-form-label">Name</label>
                            <input id="inputTitle" type="text" name="name" placeholder="Enter name"
                                value="{{ $profile->name }}" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="col-form-label">Email</label>
                            <input id="inputEmail" disabled type="email" name="email_address" placeholder="Enter email"
                                value="{{ $profile->email_address }}" class="form-control">
                            @error('email_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="col-form-label">Phone Number</label>
                            <input id="inputEmail" type="text" name="phone" placeholder="Enter phone"
                                value="{{ $profile->phone }}" class="form-control">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="col-form-label">Address</label>
                            <input id="inputEmail" type="text" name="address" placeholder="Enter email"
                                value="{{ $profile->address }}" class="form-control">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputImage" class="col-form-label">Image<span class="text-danger"></span></label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <input type="file" name="image" />
                                </span>
                            </div>
                            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <a style="color: white" href="{{ route('home-user') }}" class="btn btn-warning btn-sm">Cancle</a>
                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

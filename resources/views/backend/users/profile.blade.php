@extends('backend.layouts.master')

@section('title', 'Admin Profile')

@section('main-content')

    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h4 class=" font-weight-bold">Profile</h4>
            <ul class="breadcrumbs">
                <li><a href="{{ route('home') }}" style="color:#999">Dashboard</a></li>
                <li><a href="" class="active text-primary">Profile Page</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="image">
                            @if ($profile->image != null)
                                <img class="card-img-top img-fluid roundend-circle mt-4"
                                    style="border-radius:50%;height:80px;width:80px;margin:auto;"
                                    src="{{ asset('image/user/' . $profile->image) }}" alt="profile picture">
                            @else
                                <img class="card-img-top img-fluid roundend-circle mt-4"
                                    style="border-radius:50%;height:80px;width:80px;margin:auto;"
                                    src="{{ asset('backend/img/avatar.png') }}" alt="profile picture">
                            @endif
                        </div>
                        <div class="card-body mt-4 ml-2">
                            <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{ $profile->name }}</small>
                            </h5>
                            <p class="card-text text-left"><small><i class="fas fa-envelope"></i>
                                    {{ $profile->email_address }}</small></p>
                            <p class="card-text text-left"><small class="text-muted"><i class="fas fa-hammer"></i>
                                    @if ($profile->role == 1)
                                        Employee
                                    @elseif($profile->role == 2)
                                        Super Admin
                                    @endif
                                </small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <form class="border px-4 pt-2 pb-3" method="POST"
                        action="{{ route('admin.update.profile', $profile->id) }}" enctype="multipart/form-data">
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
                        <div class="form-group">
                            <label for="role" class="col-form-label">Role</label>
                            <select disabled name="role" class="form-control">
                                <option value="">-----Select Role-----</option>
                                <option value="admin" {{ $profile->role == '1' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $profile->role == '2' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="reset" class="btn btn-warning btn-sm">Reset</button>
                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    .breadcrumbs {
        list-style: none;
    }

    .breadcrumbs li {
        float: left;
        margin-right: 10px;
    }

    .breadcrumbs li a:hover {
        text-decoration: none;
    }

    .breadcrumbs li .active {
        color: red;
    }

    .breadcrumbs li+li:before {
        content: "/\00a0";
    }

    .image {
        background: url('{{ asset('backend/img/background.jpg') }}');
        height: 150px;
        background-position: center;
        background-attachment: cover;
        position: relative;
    }

    .image img {
        position: absolute;
        top: 55%;
        left: 35%;
        margin-top: 30%;
    }

    i {
        font-size: 14px;
        padding-right: 8px;
    }
</style>

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush

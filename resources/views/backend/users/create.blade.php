@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">THÊM TÀI KHOẢN NGƯỜI DÙNG</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tên</label>
                    <input id="inputTitle" type="text" name="name" placeholder="Nhập tên" value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-form-label">Email</label>
                    <input id="inputEmail" type="text" name="email_address" value="{{ old('email_address') }}" placeholder="Nhập email"
                        class="form-control">
                    @error('email_address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="inputPassword" class="col-form-label">Mật khẩu</label>
                    <input id="inputPassword" type="password" name="password" value="{{ Hash::make('12345678') }}" placeholder="Enter password"
                        class="form-control" disabled>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <label for="address" class="col-form-label">Địa chỉ</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="Nhập địa chỉ" class="form-control">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="col-form-label">Số điện thoại</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại" class="form-control">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Ảnh</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <input type="file" name="image" disabled />
                        </span>
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="role" class="col-form-label">Quyền</label>
                    <select name="role" class="form-control">
                        <option value="">-----Chọn quyền-----</option>
                        <option>Nhân viên</option>
                        <option>Khách hàng</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Tạo lại</button>
                    <button class="btn btn-success" type="submit">Tạo người dùng</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush

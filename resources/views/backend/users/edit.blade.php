@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">SỬA TÀI KHOẢN NGƯỜI DÙNG</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tên</label>
                    <input id="inputTitle" type="text" name="name" placeholder="Enter name"
                        value="{{ $user->name }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-form-label">Địa chỉ</label>
                    <input id="inputEmail" type="text" name="address" placeholder="Enter email"
                        value="{{ $user->address }}" class="form-control">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <input type="file" name="image" disabled>
                            <img src="{{ asset('image/user/' . $user->image) }}" alt="Ảnh sản phẩm" width="100px" height="100px">
                        </span>
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhone" class="col-form-label">Số điện thoại</label>
                    <input id="inputPhone" type="text" name="phone" placeholder="Enter phone"
                        value="{{ $user->phone }}" class="form-control">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @php
                    $roles = DB::table('users')
                        ->select('role')
                        ->where('id', $user->id)
                        ->get();
                @endphp
                <div class="form-group">
                    <label for="role" class="col-form-label">Quyền</label>
                    <select name="role" class="form-control">
                        <option value="">-----Chọn quyền-----</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->role }}" {{ $role->role == '1' ? 'selected' : '' }}>Nhân viên
                            </option>
                            <option value="{{ $role->role }}" {{ $role->role == '0' ? 'selected' : '' }}>Khách hàng
                            </option>
                            <option value="{{ $role->role }}" {{ $role->role == '2' ? 'selected' : '' }}>Quản lý
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Cập nhật</button>
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

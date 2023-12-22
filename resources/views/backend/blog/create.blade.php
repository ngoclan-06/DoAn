@extends('backend.layouts.master')

@section('title', 'E-SHOP || Blog Create')

@section('main-content')

    <div class="card">
        <h5 class="card-header">TẠO TIN TỨC</h5>
        <div class="card-body">
            <form method="post" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tiêu đề<span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="name" placeholder="Nhập tiêu đề"
                        value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputDesc" class="col-form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputImage" class="col-form-label">Ảnh<span class="text-danger">*</span></label>
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
                    <label for="status" class="col-form-label">Trạng thái<span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Tạo</button>
                    <button type="reset" class="btn btn-warning">Tạo lại</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush


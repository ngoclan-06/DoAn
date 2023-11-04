@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">SỬA THỂ LOẠI BÁNH</h5>
        <div class="card-body">
            <form method="post" action="{{ route('subcategory.update', $subcategory->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tên<span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="name" placeholder="Nhập tên"
                        value="{{ $subcategory->name }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="inputImage" class="col-form-label">Ảnh</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <input type="file" name="image" />
                            <img src="{{ asset('image/subcategory/' . $subcategory->image) }}" alt="Ảnh sản phẩm"
                                width="100px" height="100px">
                        </span>
                    </div>

                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="categories_id" class="col-form-label">Loại bánh<span
                            class="text-danger">*</span></label>
                    <select name="categories_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ $category->id == $subcategory->categories_id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Trạng thái<span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option {{ $subcategory->status == '1' ? 'selected' : '' }}>Active</option>
                        <option {{ $subcategory->status == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
    <script>
        $('#is_parent').change(function() {
            var is_checked = $('#is_parent').prop('checked');
            // alert(is_checked);
            if (is_checked) {
                $('#parent_cat_div').addClass('d-none');
                $('#parent_cat_div').val('');
            } else {
                $('#parent_cat_div').removeClass('d-none');
            }
        })
    </script>
@endpush

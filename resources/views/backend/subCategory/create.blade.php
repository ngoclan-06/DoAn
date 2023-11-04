@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">THÊM THỂ LOẠI BÁNH</h5>
        <div class="card-body">
            <form method="post" action="{{ route('subcategory.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputname" class="col-form-label">Tên<span class="text-danger">*</span></label>
                    <input id="inputname" type="text" name="name" placeholder="Nhập tên" value="{{ old('name') }}"
                        class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="inputImage" class="col-form-label">Ảnh</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <input type="file" name="image" />
                        </span>
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="parent_category" class="col-form-label">Loại bánh<span
                            class="text-danger">*</span></label>
                    <select name="parent_category" class="form-control">
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_category')
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
                    <button type="reset" class="btn btn-warning">Tạo lại</button>
                    <button class="btn btn-success" type="submit">Tạo</button>
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
                height: 120
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

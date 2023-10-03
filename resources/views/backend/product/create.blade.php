@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">TẠO SẢN PHẨM</h5>
        <div class="card-body">
            <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tên sản phẩm<span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="name" placeholder="Nhập tên sản phẩm"
                        value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="parent_category" class="col-form-label">Thể loại bánh'SCate'<span
                            class="text-danger">*</span></label>
                    <select name="sub_categories_id" class="form-control">
                        @foreach ($subcategories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('sub_categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Giá<span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Nhập giá"
                        value="{{ old('price') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_manufacture" class="col-form-label">Ngày sản xuất <span
                            class="text-danger">*</span></label>
                    <input id="date_of_manufacture" type="date" name="date_of_manufacture" placeholder="Nhập ngày sản xuất"
                        value="{{ old('date_of_manufacture') }}" class="form-control">
                    @error('date_of_manufacture')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="expiry" class="col-form-label">Ngày hết hạn<span class="text-danger">*</span></label>
                    <input id="expiry" type="date" name="expiry" placeholder="Nhập ngày hết hạn"
                        value="{{ old('expiry') }}" class="form-control">
                    @error('expiry')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hot" class="col-form-label">Hot </label>
                    <input style="height: 20px; width: 20px; margin-left: 10px" type="checkbox" name="hot">
                </div>

                <div class="form-group">
                    <label for="stock">Số lượng<span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="quantity" min="0" placeholder="Nhập số lượng"
                        value="{{ old('quantity') }}" class="form-control">
                    @error('quantity')
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
                        <option>Còn bán</option>
                        <option>Không còn bán</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Tạo lại</button>
                    <button class="btn btn-success" type="submit">Tạo sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();
    </script>

    <script>
        $('#cat_id').change(function() {
            var cat_id = $(this).val();
            // alert(cat_id);
            if (cat_id != null) {
                // Ajax call
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;
                            // alert(data);
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title) {
                                    html_option += "<option value='" + id + "'>" + title +
                                        "</option>"
                                });
                            } else {}
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            } else {}
        })
    </script>
@endpush

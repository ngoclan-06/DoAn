@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">SỬA SẢN PHẨM</h5>
        <div class="card-body">
            <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tên sản phẩm<span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="name" placeholder="Nhập tên sản phẩm"
                        value="{{ $product->name }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sub_categories_id" class="col-form-label">Thể loại bánh'SCate'<span
                            class="text-danger">*</span></label>
                    <select name="sub_categories_id" class="form-control">
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}"
                                {{ $subcategory->id == $product->sub_categories_id ? 'selected' : '' }}>
                                {{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                    @error('sub_categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hot" class="col-form-label">Hot </label>
                    <input style="height: 20px; width: 20px; margin-left: 10px" type="checkbox" name="hot">
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Giá<span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Nhập giá"
                        value="{{ $product->price }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_manufacture" class="col-form-label">Ngày sản xuất<span
                            class="text-danger">*</span></label>
                    <input id="date_of_manufacture" type="date" name="date_of_manufacture"
                        placeholder="Enter date_of_manufacture" value="{{ $product->date_of_manufacture }}"
                        class="form-control">
                    @error('date_of_manufacture')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expiry" class="col-form-label">Ngày hết hạn<span class="text-danger">*</span></label>
                    <input id="expiry" type="date" name="expiry" placeholder="Nhập ngày hết hạn"
                        value="{{ $product->expiry }}" class="form-control">
                    @error('expiry')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock">Số lượng<span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="quantity" min="0" placeholder="Nhập số lượng"
                        value="{{ $product->quantity }}" class="form-control">
                    @error('quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                        <label for="inputImage" class="col-form-label">Ảnh<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <input type="file" name="image" />
                                <img src="{{ asset('image/product/' . $product->image) }}" alt="Ảnh sản phẩm"
                                    width="100px" height="100px">
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
                            <option {{ $product->status == '1' ? 'selected' : '' }}>Còn bán</option>
                            <option {{ $product->status == '0' ? 'selected' : '' }}>Không còn bán</option>
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
                height: 150
            });
        });
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail Description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>

    <script>
        var child_cat_id = '{{ $product->child_cat_id }}';
        // alert(child_cat_id);
        $('#cat_id').change(function() {
            var cat_id = $(this).val();

            if (cat_id != null) {
                // ajax call
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response);
                        }
                        var html_option = "<option value=''>--Select any one--</option>";
                        if (response.status) {
                            var data = response.data;
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title) {
                                    html_option += "<option value='" + id + "' " + (
                                            child_cat_id == id ? 'selected ' : '') + ">" +
                                        title + "</option>";
                                });
                            } else {
                                console.log('no response data');
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);

                    }
                });
            } else {

            }

        });
        if (child_cat_id != null) {
            $('#cat_id').change();
        }
    </script>
@endpush

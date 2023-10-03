@extends('backend.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left"><a href="{{ route('products') }}">DANH SÁCH SẢN PHẨM</a></h6>
            <br>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i>Thêm sản phẩm</a>
            <a href="{{ route('products.expired') }}" class="btn btn-primary btn-sm float-left" data-toggle="tooltip"
                data-placement="bottom" title="Add User"></i> Danh sách sản phẩm hết hạn</a>
            <a style="margin-left: 10px" href="{{ route('products.outofstock') }}" class="btn btn-primary btn-sm float-left"
                data-toggle="tooltip" data-placement="bottom" title="Add User"></i> Danh sách sản phẩm hết hàng</a>
        </div>
        <div class="card-body">
            <div class="float-right" style="margin-bottom: 15px">
                <form action="{{ route('products.search') }}" method="POST">
                    @csrf
                    <input type="search" name="search">
                    <button>Tìm kiếm</button>
                </form>
            </div>
            <div class="table-responsive">
                @if (count($products) > 0)
                    <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center;">
                                {{-- <th></th> --}}
                                <th>STT</th>
                                <th>Tiêu đề</th>
                                <th>Loại bánh</th>
                                <th>Giá bánh</th>
                                <th style="width: 100px">Ảnh</th>
                                <th>Ngày sản xuât</th>
                                <th>Ngày hết hạn</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Lựa chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr style="text-align: center;">
                                    {{-- <td><input type="checkbox" name="selected[]" value="{{ $product->id }}"></td> --}}
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sub_categories->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('image/product/' . $product->image) }}"
                                                class="img-fluid zoom" style="max-width:80px; width: 100px; height:50px;"
                                                alt="{{ $product->image }}">
                                        @else
                                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}"
                                                class="img-fluid zoom" style="max-width:20%" alt="avatar.png">
                                        @endif
                                    </td>
                                    <td>{{ $product->date_of_manufacture }}</td>
                                    <td>{{ $product->expiry }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @if ($product->status == 1)
                                            <span class="badge badge-success">Còn bán</span>
                                        @else
                                            <span class="badge badge-warning">Không còn bán</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('products.delete', [$product->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" id="dltBtn"
                                                data-id={{ $product->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"
                                                onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này không?')"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $products->links('pagination::bootstrap-4') }}</span>
                @else
                    <h6 class="text-center">Không tìm thấy sản phẩm!!! Vui lòng tạo Sản phẩm</h6>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(5);
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#product-dataTable').DataTable({
            "scrollX": false "columnDefs": [{
                "orderable": false,
                "targets": [10, 11, 12]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
                console.log("clickcksdf");
            })
        })
    </script>
@endpush

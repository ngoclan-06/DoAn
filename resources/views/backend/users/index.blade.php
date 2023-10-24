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
            <h6 class="m-0 font-weight-bold text-primary float-left"><a href="{{ route('users') }}">DANH SÁCH TÀI KHOẢN NGƯỜI DÙNG</a></h6>
            <br>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Thêm tài khoản người dùng</a>
            <a href="{{ route('users.listDelete') }}" class="btn btn-primary btn-sm float-left" data-toggle="tooltip"
                data-placement="bottom" title="Add User"> Danh sách tài khoản đã xóa</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($users))
                    <table class="table table-bordered" id="user-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Ảnh</th>
                                <th>Ngày vào</th>
                                <th>Quyền</th>
                                {{-- <th>Status</th> --}}
                                <th>Lựa chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr style="text-align: center">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email_address }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @if ($user->image != null)
                                            <img src="{{ asset('image/user/' . $user->image) }}"
                                                class="img-fluid rounded-circle"
                                                style="max-width:50px; width:50px !important; height:50px !important;"
                                                alt="{{ $user->image }}">
                                        @else
                                            <img src="{{ asset('backend/img/avatar.png') }}"
                                                class="img-fluid rounded-circle" style="max-width:50px" alt="avatar.png">
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at ? $user->created_at->diffForHumans() : '' }}</td>
                                    <td>
                                        @if ($user->role == 1)
                                            Nhân viên
                                        @else
                                            Khách hàng
                                        @endif
                                    </td>
                                    @if ($user->deleted_at == null)
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-primary btn-sm float-left mr-1"
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                            <form method="POST" action="{{ route('users.delete', $user->id) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn"
                                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                    data-placement="bottom" title="Delete"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa không ?')"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    @else
                                        <td>
                                            <form method="POST" action="{{ route('users.forcedelete', $user->id) }}">
                                                @csrf
                                                @method('delete')
                                                {{-- <button class="btn btn-danger btn-sm dltBtn"
                                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                    data-placement="bottom" title="Delete"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa không ?')"><i
                                                        class="fas fa-trash-alt"></i></button> --}}
                                            </form>
                                            <form action="{{ route('users.restore', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button onclick="return confirm('Bạn chắc chắn muốn khôi phục không ?')" type="submit"><i class="fa-solid fa-trash-undo"></i></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $users->links('pagination::bootstrap-4') }}</span>
                @else
                    <h6 class="text-center">Chưa có người dùng nào!!! Vui lòng tạo người dùng!</h6>
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
        $('#user-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [6, 7]
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
            $('.dltBtn').click(function(e) {
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
            })
        })
    </script>
@endpush

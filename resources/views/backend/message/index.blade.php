@extends('backend.layouts.master')
@section('main-content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <h5 class="card-header">Tin nhắn</h5>
        {{-- @include('backend.messages.master-message') --}}
        @include('backend.message.message')
        <div class="container">
    {{-- <h2>Chat với {{ $messages->user->name }}</h2>

    <div class="chat-box">
        <!-- Hiển thị tất cả tin nhắn, sắp xếp theo thời gian -->
        @foreach ($allMessages as $message)
            <div class="message">
                {{ $message->message }}
            </div>
        @endforeach
    </div>

    <!-- Form gửi tin nhắn -->
    <form action="{{ route('message.sendMessage') }}" method="post">
        @csrf
        <input type="hidden" name="userId" value="{{ $messages->user->id }}">
        <textarea name="message" placeholder="Nhập tin nhắn"></textarea>
        <button type="submit">Gửi</button>
    </form>
</div> --}}

        
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
            transform: scale(3.2);
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#message-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [4]
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

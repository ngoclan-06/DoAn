@extends('frontend.layouts.master')
@section('title', 'Chi tiết đơn hàng')
@section('main-content')
    <div class="card">
        <a href="{{route('historyOrder')}}" 
            class="btn" style="width: 9%; height: 50px; color:#fff; margin-top:5px; margin-left:1350px;">QUAY LẠI</a>
        <div class="card-body">
            @if ($order)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Tổng cộng</th>
                            <th>Trạng thái</th>
                            {{-- <th>Lựa chọn</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $order->fullname }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ number_format($order->total, 0) }}đ</td>
                            <td>
                                @if ($order->status == 'new')
                                    <span class="badge badge-primary">{{ $order->status }}</span>
                                @elseif($order->status == 'process')
                                    <span class="badge badge-warning">{{ $order->status }}</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge badge-success">{{ $order->status }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $order->status }}</span>
                                @endif
                            </td>
                            {{-- <td>
                                <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary btn-sm float-left mr-1"
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                    data-placement="bottom"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm dltBtn" data-id={{ $order->id }}
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td> --}}

                        </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            <div class="col-lg-6 col-lx-4">
                                <div class="order-info">
                                    <h4 class="text-center pb-4">THÔNG TIN ĐẶT HÀNG</h4>
                                    <table class="table">
                                        <tr>
                                            <td>Order Date</td>
                                            <td> : {{ $order->created_at->format('D d M, Y') }} at
                                                {{ $order->created_at->format('g : i a') }} </td>
                                        </tr>
                                        <tr>
                                            <td>Trạng thái đơn hàng</td>
                                            <td> : {{ $order->status }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phương thhức thanh toán</td>
                                            <td> : @if ($order->payment->payment_method == 'cod')
                                                    Thanh toán khi giao hàng!
                                                @else
                                                    Paypal
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trạng thái thanh toán</td>
                                            <td> : {{ $order->payment->payment_status }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-lx-4">
                                <div class="shipping-info">
                                    <h4 class="text-center pb-4">THÔNG TIN SẢN PHẨM</h4>
                                    @foreach ($orderDetails as $item)
                                        <table class="table">
                                            <tr>
                                                <td>Ảnh</td>
                                                <td> : <img width="100px" src="{{ asset('image/product/'. $item->products?->image) }}" ></td>
                                            </tr>
                                            <tr>
                                                <td>Tên</td>
                                                <td> : {{ $item->products?->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Số lượng</td>
                                                <td> : {{ $item->quantity }}</td>
                                            </tr>
                                            <tr>
                                                <td>Giá</td>
                                                <td> : {{ number_format($item->price) }}đ</td>
                                            </tr>                                        
                                        </table>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection
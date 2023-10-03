@extends('frontend.layouts.master')
@section('title', 'Cart Page')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ 'home-user' }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Order</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        @if (count($orderDetails))
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Shopping Summery -->
                        <table class="table shopping-summery">
                            <thead>
                                <tr class="main-hading">
                                    <th>PRODUCT</th>
                                    <th>NAME</th>
                                    <th class="text-center">UNIT PRICE</th>
                                    <th class="text-center">QUANTITY</th>
                                </tr>
                            </thead>
                            <tbody id="cart_item_list">
                                <form action="" method="POST">
                                    @csrf
                                    @foreach ($orders as $item)
                                        @if (count($orderDetails) > 0)
                                            @foreach ($item->order_detail as $orderd)
                                                <tr style="text-align: center">
                                                    <td class="image" data-title="No"><img
                                                            src="{{ asset('image/product/' . $orderd->products->image) }}"
                                                            alt=""></td>
                                                    <td class="product-des" data-title="Description">
                                                        <p class="product-name"><a
                                                                href="{{ route('product-detail', $orderd->products->id) }}"
                                                                target="_blank">{{ $orderd->products->name }}</a>
                                                        </p>
                                                    </td>
                                                    <td class="qty" data-title="Qty">
                                                        <p>{{ number_format($orderd->price, 0) }}đ</p>
                                                    </td>
                                                    <td class="qty" data-title="Qty">
                                                        <p>{{ $orderd->quantity }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        @if ($item->status == 'new')
                                            <td colspan="2" class="action" data-title="Remove"><a
                                                    href="{{ route('order.cancle', $item->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')"><b style="font-size: 25px">Cancle</b></a>
                                            </td>
                                        @else
                                            <td colspan="2" class="action" data-title="Remove"><a
                                                    style="pointer-events: none;" href="#"><b style="font-size: 25px">Cancle</b></a>
                                            </td>
                                        @endif
                                        <td class="qty" data-title="Qty" style="font-size: 25px">
                                            @if ($orderd->order->status == 'new')
                                                <span class="badge badge-primary">{{ $orderd->order->status }}</span>
                                            @elseif($orderd->order->status == 'process')
                                                <span class="badge badge-warning">{{ $orderd->order->status }}</span>
                                            @elseif($orderd->order->status == 'delivered')
                                                <span class="badge badge-success">{{ $orderd->order->status }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $orderd->order->status }}</span>
                                            @endif
                                        </td>
                                        <td style="float: right; font-size: 25px"><b>Total: {{ number_format($item->total) }}đ</b></td>
                                    @endforeach
                                </form>
                            </tbody>
                        </table>
                        <!--/ End Shopping Summery -->
                    </div>
                </div>
            </div>
        @else
            <span style="margin-left: 280px; font-size: 20px">No products found in order!!! Please add Product to order.
                <a href="{{ route('product-grids') }}" class="btn">shopping</a>
            </span>
        @endif
    </div>
    <!--/ End Shopping Cart -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Sucure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->

    <!-- Start Shop Newsletter  -->
    @include('frontend.layouts.newsletter')
    <!-- End Shop Newsletter -->

@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>
    <script>
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
            });

        });
    </script>
@endpush

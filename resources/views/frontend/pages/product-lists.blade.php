@extends('frontend.layouts.master')

@section('title', 'HaVyBakery || PRODUCT PAGE')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home-user') }}">Trang chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Danh sách sản phẩm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    <form action="{{ route('shop.filter') }}" method="POST">
        @csrf
        <!-- Product Style 1 -->
        <section class="product-area shop-sidebar shop-list shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Loại bánh</h3>
                                <ul class="categor-list">
                                    <li>
                                        @foreach ($category as $cat)
                                    		<li><a  href="{{route('product-category',$cat->id)}}">{{ $cat->name }}</a></li>
                                    			<ul style="margin-left: 15px">
                                       				 @foreach ($cat->subCategories as $subCategory)
                                            			<li><a href="{{route('product-sub-category',$subCategory->id)}}">{{ $subCategory->name }}</a></li>
                                        			@endforeach
                                    			</ul>
                                   		@endforeach
                                    </li>
                                </ul>
                            </div>
                            <!--/ End Single Widget -->
                            <!-- Shop By Price -->
                            <div class="single-widget range">
                                <h3 class="title">Tìm kiếm theo giá</h3>
                                <div class="price-filter">
                                    <div class="price-filter-inner">
                                        @php
                                            $max = DB::table('products')->max('price');
                                        @endphp
                                        <div id="slider-range" data-min="0" data-max="{{ $max }}"></div>
                                        <div class="product_filter">
                                            <button type="submit" class="filter_button">Tìm kiếm</button>
                                            <div class="label-input">
                                                <span>Phạm vi:</span>
                                                <input style="" type="text" id="amount" readonly />
                                                <input type="hidden" name="price_range" id="price_range"
                                                    value="@if (!empty($_GET['price'])) {{ $_GET['price'] }} @endif" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Shop By Price -->
                            <!-- Single Widget -->
                            <div class="single-widget recent-post">
                                <h3 class="title">Bài đăng gần đây</h3>
                                @foreach ($recent_products as $product)
                                    <div class="single-post first">
                                        <div class="image">
                                            <img src="{{ asset('image/product/' . $product->image) }}"
                                                alt="{{ $product->image }}">
                                        </div>
                                        <div class="content">
                                            <h5><a
                                                    href="{{ route('product-detail', $product->id) }}">{{ $product->name }}</a>
                                            </h5>
                                            <p class="price"><span
                                                    class="text-muted">{{ number_format($product->price, 0) }}đ</span>
                                        </div>
                                    </div>
                                    <!-- End Single Post -->
                                @endforeach
                            </div>
                            <!--/ End Single Widget -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Hiển thị:</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Mặc định</option>
                                                <option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
                                                <option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
                                                <option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
                                                <option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sắp xếp:</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Mặc định</option>
                                                <option value="name" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='name') selected @endif>Tên</option>
                                                <option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Giá</option>             
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <ul class="view-mode">
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href="{{route('product-lists')}}"><i class="fa fa-th-list"></i></a></li>
                                    </ul> --}}
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        <div class="row">
                            {{-- {{$products}} --}}
                            @if(count($products)>0)
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{ route('product-detail', $product->id) }}">
                                                    <img src="{{ asset('image/product/' . $product->image) }}" style="height:250px;width:250px;"
                                                        alt="{{ $product->image }}">
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        {{-- <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                            title="Quick View" href="#"><i
                                                                class=" ti-eye"></i><span>Quick Shop</span></a> --}}
                                                        <a title="Wishlist" href="{{ route('add-to-wishlist', $product->id) }}" class="wishlist"
                                                            data-id="{{ $product->id }}"><i
                                                                class=" ti-heart "></i><span>Thêm vào danh sách yêu thích</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Thêm vào giỏ hàng" href="{{ route('add-to-cart', $product->id) }}">Thêm vào giỏ hàng</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{route('product-detail',$product->id)}}">{{$product->name}}</a></h3>
                                                <span style="padding-left:4%;">{{number_format($product->price,0)}}đ</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                    <h4 class="text-warning" style="margin:100px auto;">Không có sản phẩm nào.</h4>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex"></div>
                            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!--/ End Product Style 1  -->
    </form>
    <!-- Modal -->
    @if ($products)
        @foreach ($products as $product)
            <div class="modal fade" id="{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            <img src="{{ asset('image/product/' . $product->image) }}"
                                                alt="{{ $product->image }}">
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{ $product->name }}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                {{-- <div class="quickview-ratting">
                                                    @php
                                                        $rate = DB::table('product_reviews')
                                                            ->where('product_id', $product->id)
                                                            ->avg('rate');
                                                        $rate_count = DB::table('product_reviews')
                                                            ->where('product_id', $product->id)
                                                            ->count();
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($rate >= $i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{ $rate_count }} customer review)</a> --}}
                                            </div>
                                            <div class="quickview-stock">
                                                @if ($product->quantity > 0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{ $product->quantity }} in
                                                        quantity</span>
                                                @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i>
                                                        {{ $product->quantity }} out quantity</span>
                                                @endif
                                            </div>
                                        </div>
                                        <h3><small><samp
                                                    class="text-muted">{{ number_format($product->price, 0) }}đ</samp></small>
                                        </h3>
                                        <form action="" method="POST">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{ $product->id }}">
                                                    <input type="text" name="quant[1]" class="input-number"
                                                        data-min="1" data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Thêm vào giỏ hàng</button>
                                                <a href="" class="btn min"><i class="ti-heart"></i></a>
                                                {{-- @if ($productDetail->quantity > 0)
                                                <a title="Thêm vào giỏ hàng" class="btn" href="{{ route('add-to-cart', $productDetail->id) }}">Thêm vào giỏ hàng</a>
                                                @else
                                                <a style="pointer-events: none;" title="Thêm vào giỏ hàng" class="btn" href="{{ route('add-to-cart', $productDetail->id) }}">Thêm vào giỏ hàng</a>
                                                @endif
                                                <a href="" class="btn min"><i class="ti-heart"></i></a> --}}
                                                {{-- <a title="Thêm vào giỏ hàng" href="{{ route('add-to-cart', $product->id) }}">Thêm vào giỏ hàng</a> --}}
                                            </div>
                                        </form>
                                        {{-- <div class="default-social">
                                            <!-- ShareThis BEGIN -->
                                            <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection
@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }

        .filter_button {
            /* height:20px; */
            text-align: center;
            background: #F7941D;
            padding: 8px 16px;
            margin-top: 10px;
            color: white;
        }
    </style>
@endpush
@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            /*----------------------------------------------------*/
            /*  Jquery Ui slider js
            /*----------------------------------------------------*/
            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;
                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function(event, ui) {
                        $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }
            if ($("#amount").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                    "  -  " + m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
@endpush

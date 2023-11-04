@extends('frontend.layouts.master')
@section('title', 'HaVyBakery || HOME PAGE')
@section('main-content')
    <!-- Slider Area -->
    @if (count($banners) > 0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <li data-target="#Gslider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}">
                    </li>
                @endforeach

            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="first-slide" src="{{ asset('image/banner/' . $banner->image) }}" alt="First slide">
                        <div class="carousel-caption d-none d-md-block text-left">
                            <h1 class="wow fadeInDown">{{ $banner->title }}</h1>
                            <p>{!! html_entity_decode($banner->description) !!}</p>
                            <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{ route('product-grids') }}"
                                role="button">Shop Now<i class="far fa-arrow-alt-circle-right"></i></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </section>
    @endif

    <!--/ End Slider Area -->

    <!-- Start Small Banner  -->
    <section class="small-banner section">
        <div class="container-fluid">
            <div class="row">
                @php
                    $category_lists = DB::table('categories')
                        ->where('status', '1')
                        ->limit(3)
                        ->get();
                @endphp
                @if ($category_lists)
                    @foreach ($category_lists as $cat)
                        {{-- @if ($cat->is_parent == 1) --}}
                        <!-- Single Banner  -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-banner">
                                @if ($cat->image)
                                    <img src="{{ asset('image/category/' . $cat->image) }}" alt="{{ $cat->image }}"
                                        style="width: 500px; height: 300px">
                                @else
                                    <img src="https://via.placeholder.com/600x370" alt="#">
                                @endif
                                <div class="content">
                                    <h3>{{ $cat->name }}</h3>
                                    <a href="{{ route('product-category', $cat->id) }}">Discover Now</a>
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                        <!-- /End Single Banner  -->
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- End Small Banner -->

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Mặt hàng thịnh hàng</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @php
                                    $subcategories = DB::table('sub_categories')
                                        ->where('status', '1')
                                        ->limit(3)
                                        ->get();
                                @endphp
                                @if ($subcategories)
                                    <button class="btn" style="background:black"data-filter="*">
                                        Sản phẩm
                                    </button>
                                    @foreach ($subcategories as $cat)
                                        <button class="btn"
                                            style="background:none;color:black;"data-filter=".{{ $cat->id }}">
                                            {{ $cat->name }}
                                        </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        <div class="tab-content isotope-grid" id="myTabContent">
                            <!-- Start Single Tab -->
                            @if ($products)
                                @foreach ($products as $product)
                                    <div
                                        class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->sub_categories_id }}">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <input name="productid_hidden" type="hidden"
                                                    value="{{ $product->id }}" />
                                                <img class="default-img"
                                                    src="{{ asset('image/product/' . $product->image) }}"
                                                    alt="{{ $product->image }}" style="width: 255px; height: 200px">
                                                @if ($product->quantity <= 0)
                                                    <span class="out-of-stock">Sale out</span>
                                                @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                            title="Quick View" href="#"><i
                                                                class=" ti-eye"></i><span>Quick Shop</span></a>
                                                        <a title="Wishlist"
                                                            href="{{ route('add-to-wishlist', $product->id) }}"><i
                                                                class=" ti-heart "></i><span>Thêm vào danh sách yêu thích</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        @if ($product->quantity > 0)
                                                            <a title="Add to cart"
                                                                href="{{ route('add-to-cart', $product->id) }}">Thêm vào giỏ hàng</a>
                                                        @else
                                                            <a style="pointer-events: none;" title="Add to cart"
                                                                href="{{ route('add-to-cart', $product->id) }}">Thêm vào giỏ hàng</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a
                                                        href="{{ route('product-detail', $product->id) }}">{{ $product->name }}</a>
                                                </h3>
                                                <div class="product-price">
                                                    <span
                                                        style="padding-left:4%;">{{ number_format($product->price, 0) }}đ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!--/ End Single Tab -->
                            @endif
                            <!--/ End Single Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Most Popular -->
    <div class="product-area most-popular section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Mục nổi bật</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach ($hotProducts as $product)
                            @if ($product->hot == 1)
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{ route('product-detail', $product->id) }}">
                                            <img class="default-img"
                                                src="{{ asset('image/product/' . $product->image) }}" alt=""
                                                style="width: 255px; height: 200px">
                                            <img class="hover-img" src="{{ asset('image/product/' . $product->image) }}"
                                                alt="">
                                            {{-- <span class="out-of-stock">Hot</span> --}}
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                    title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick
                                                        Shop</span></a>
                                                <a title="Wishlist"
                                                    href="{{ route('add-to-wishlist', $product->id) }}"><i
                                                        class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a href="{{ route('add-to-cart', $product->id) }}">Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a
                                                href="{{ route('product-detail', $product->id) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="product-price">
                                            <span>{{ number_format($product->price, 0) }}đ</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Product -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Most Popular Area -->

    <!-- Start Shop Home List  -->
    <section class="shop-home-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-section-title">
                                <h1>Mục mới nhất</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $product_lists = DB::table('products')
                                ->inRandomOrder()
                                ->where('status', '1')
                                ->whereNull('deleted_at')
                                ->orderBy('id', 'DESC')
                                ->limit(6)
                                ->get();
                        @endphp
                        @foreach ($product_lists as $product)
                            <div class="col-md-4">
                                <!-- Start Single List  -->
                                <div class="single-list">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="list-image overlay">
                                                <img src="{{ asset('image/product/' . $product->image) }}"
                                                    alt="{{ $product->image }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 no-padding">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="{{ route('product-detail', $product->id) }}">{{ $product->name }}</a>
                                                </h4>
                                                <p class="price with-discount">{{ number_format($product->price, 0) }}đ
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single List  -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Home List  -->

    <!-- Start Shop Blog  -->
    <section class="shop-blog section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Tin tức từ cửa hàng</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($blogs)
                    @foreach ($blogs as $blog)
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Start Single Blog  -->
                            <div class="shop-single-blog">
                                <img src="{{ asset('image/blog/' . $blog->image) }}" alt="{{ $blog->image }}"
                                    style="height: 353px;">
                                <div class="content">
                                    <p class="date">{{ $blog->created_at->format('d M , Y. D') }}</p>
                                    <a href="{{ route('blog.detail', $blog->id) }}"
                                        class="title">{{ $blog->name }}</a>
                                    <a href="{{ route('blog.detail', $blog->id) }}" class="more-btn">Continue Reading</a>
                                </div>
                            </div>
                            <!-- End Single Blog  -->
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- End Shop Blog  -->

    <!-- Start Shop Services Area -->
    {{-- <section class="shop-services section home">
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
    </section> --}}
    <!-- End Shop Services Area -->
    @include('frontend.layouts.newsletter')
@endsection

@push('styles')
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons'
        async='async'></script>
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons'
        async='async'></script>
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
            background: #000000;
            color: black;
        }

        #Gslider .carousel-inner {
            height: 550px;
        }

        #Gslider .carousel-inner img {
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
            bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
            font-size: 50px;
            font-weight: bold;
            line-height: 100%;
            color: #F7941D;
        }

        #Gslider .carousel-inner .carousel-caption p {
            font-size: 18px;
            color: black;
            margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
            bottom: 70px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        /*==================================================================
                    [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function() {
            $filter.on('click', 'button', function() {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({
                    filter: filterValue
                });
            });

        });

        // init Isotope
        $(window).on('load', function() {
            var $grid = $topeContainer.each(function() {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine: 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function() {
            $(this).on('click', function() {
                for (var i = 0; i < isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
        function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el
                .exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el
                .msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
@endpush

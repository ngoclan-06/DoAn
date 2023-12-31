@extends('frontend.layouts.master')

@section('title', 'HaVyBakery || About Us')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Trang chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">Giới thiệu</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- About Us -->
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="about-content">

                        <h3>Chào mừng bạn đến với <span>HaVyBakery</span></h3>
                        <p>
                            Xin chào quý khách, chúng tôi là một cửa hàng Hà Vy Bakery chuyên cung cấp các loại bánh, bánh mì,
                            bánh ngọt và các sản phẩm liên quan đến ẩm thực. Với hơn 10 năm kinh nghiệm trong lĩnh vực sản
                            xuất bánh, chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng, đảm bảo vệ sinh
                            an toàn thực phẩm và đặc biệt là vị ngon đậm đà, tươi mới mỗi ngày. Chúng tôi luôn đề cao tinh
                            thần sáng tạo và năng động trong sản xuất, cùng với đội ngũ nhân viên tận tâm và chuyên nghiệp,
                            chúng tôi hy vọng sẽ mang lại cho quý khách những trải nghiệm tuyệt vời nhất khi đến với cửa
                            hàng Bakery của chúng tôi.
                        </p>
                        <div class="button">
                            <a href="{{ route('blog.list') }}" class="btn">Đến tin tức</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-img overlay">
                        <img src="{{ asset('image/image.PNG') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.newsletter')
@endsection

<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>TIN</h4>
                        <p> Đăng ký nhận bản tin của chúng tôi và nhận mã giảm giá cho lần mua hàng đầu tiên của bạn</p>
                        <form action="{{ route('mail.sendCoupon') }}" method="post" class="newsletter-inner">
                            @csrf
                            <input name="email" placeholder="Địa chỉ email của bạn" required="" type="email">
                            <button class="btn" type="submit">Đăng ký</button>
                        </form>
                    </div>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->

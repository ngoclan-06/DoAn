<div id="myMap">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1215.8010851354031!2d105.40230166619125!3d21.41675274424668!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313493543a013d51%3A0x2358ee15561af259!2sH%C3%A0%20Vy%20Bakery!5e0!3m2!1svi!2s!4v1692121509831!5m2!1svi!2s" 
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<!-- Start Footer Area -->
<footer class="footer">
    <!-- Footer Top -->
    <div class="footer-top section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-2 col-10">
                    <!-- Single Widget -->
                    <div class="single-footer about">
                        <div class="logo">
                            <a href="{{ route('home-user') }}"><h1 style="color:white">HaVyBakery</h1></a>
                        </div>

                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-6 col-md-2 col-10">
                    <!-- Single Widget -->
                    <div class="single-footer links">
                        <h4>Thông tin liên hệ</h4>
                            <div class="single-head">
                                <div class="single-info">
                                    <i class="fa fa-phone" style="color:#fff;"> <h4 class="title" style="float:right; margin-left:15px;">Liên hệ: 0978084301</h4> </i>
                                </div>
                                <div class="single-info">
                                    <i class="fa fa-envelope-open" style="color:#fff;"><h4 class="title" style="float:right; margin-left:15px;">Email: <a href="mailto:info@yourwebsite.com" style="text-transform: lowercase;">hangoclan1710@gmail.com</a></h4></i>
                                </div>
                                <div class="single-info">
                                    <i class="fa fa-location-arrow" style="color:#fff;"><h4 class="title" style="float:right; margin-left:15px;">Địa chỉ: Thị trấn Tam Sơn - Sông Lô -Vĩnh Phúc</h4></i>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- /End Footer Area -->

<!-- Jquery -->
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<!-- Color JS -->
<script src="{{ asset('frontend/js/colors.js') }}"></script>
<!-- Slicknav JS -->
<script src="{{ asset('frontend/js/slicknav.min.js') }}"></script>
<!-- Owl Carousel JS -->
<script src="{{ asset('frontend/js/owl-carousel.js') }}"></script>
<!-- Magnific Popup JS -->
<script src="{{ asset('frontend/js/magnific-popup.js') }}"></script>
<!-- Waypoints JS -->
<script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
<!-- Countdown JS -->
<script src="{{ asset('frontend/js/finalcountdown.min.js') }}"></script>
<!-- Nice Select JS -->
<script src="{{ asset('frontend/js/nicesellect.js') }}"></script>
<!-- Flex Slider JS -->
<script src="{{ asset('frontend/js/flex-slider.js') }}"></script>
<!-- ScrollUp JS -->
<script src="{{ asset('frontend/js/scrollup.js') }}"></script>
<!-- Onepage Nav JS -->
<script src="{{ asset('frontend/js/onepage-nav.min.js') }}"></script>
{{-- Isotope --}}
<script src="{{ asset('frontend/js/isotope/isotope.pkgd.min.js') }}"></script>
<!-- Easing JS -->
<script src="{{ asset('frontend/js/easing.js') }}"></script>

<!-- Active JS -->
<script src="{{ asset('frontend/js/active.js') }}"></script>


@stack('scripts')
<script>
    setTimeout(function() {
        $('.alert').slideUp();
    }, 1000);
    $(function() {
        // ------------------------------------------------------- //
        // Multi Level dropdowns
        // ------------------------------------------------------ //
        $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
            event.preventDefault();
            event.stopPropagation();

            $(this).siblings().toggleClass("show");


            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });

        });
    });
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6579c66d70c9f2407f7f7839/1hhhqu7j3';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->

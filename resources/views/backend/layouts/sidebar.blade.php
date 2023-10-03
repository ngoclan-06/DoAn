<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(180deg,#0a2685 10%,#040c21 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        @if (auth()->user()->role == 1)
            <div class="sidebar-brand-text mx-3">Nhân viên</div>
        @else
            <div class="sidebar-brand-text mx-3">Quản lý</div>
        @endif
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Trang chủ</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-image"></i>
            <span>Banners</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Lựa chọn:</h6>
                <a class="collapse-item" href="{{ route('banner') }}">Banners</a>
                <a class="collapse-item" href="{{ route('banner.create') }}">Add Banners</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Shop
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse"
            aria-expanded="true" aria-controls="shippingCollapse">
            <i class="fas fa-fw fa-folder"></i>
            <span>Tin tức</span>
        </a>
        <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Lựa chọn:</h6>
                <a class="collapse-item" href="{{ route('blog') }}">Danh sách tin tức</a>
                <a class="collapse-item" href="{{ route('blog.create') }}">Thêm tin tức</a>
            </div>
        </div>
    </li>
    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse"
            aria-expanded="true" aria-controls="categoryCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Loại bánh</span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Lựa chọn:</h6>
                <a class="collapse-item" href="{{ route('category') }}">Danh sách loại bánh</a>
                <a class="collapse-item" href="{{ route('category.create') }}">Thêm loại bánh</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse"
            aria-expanded="true" aria-controls="brandCollapse">
            <i class="fas fa-table"></i>
            <span>Danh mục bánh</span>
        </a>
        <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Lựa chọn:</h6>
                <a class="collapse-item" href="{{ route('subcategory') }}">Danh sách bánh</a>
                <a class="collapse-item" href="{{ route('subcategory.create') }}">Thêm bánh</a>
            </div>
        </div>
    </li>
    {{-- Products --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse"
            aria-expanded="true" aria-controls="productCollapse">
            <i class="fas fa-cubes"></i>
            <span>Sản phẩm</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Lựa chọn:</h6>
                <a class="collapse-item" href="{{ route('products') }}">Danh sách sản phẩm</a>
                <a class="collapse-item" href="{{ route('products.create') }}">Thêm sản phẩm</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('message.index') }}">
            <i class="fas fa-comments"></i>
            <span>Tin nhắn</span>
        </a>
    </li>

    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('order.index') }}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Đơn hàng</span>
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.review') }}">
            <i class="fas fa-comments"></i>
            <span>Đánh giá</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Posts
    </div>
    <!-- Comments -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('comment.index') }}">
            <i class="fas fa-comments fa-chart-area"></i>
            <span>Bình luận</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('coupon.index') }}">
            <i class="fas fa-table"></i>
            <span>Mã giảm giá</span></a>
    </li>
    <!-- Users -->
    @if (Auth()->user()->role == 2)
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Heading -->
        <div class="sidebar-heading">
            General Settings
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users') }}">
                <i class="fas fa-users"></i>
                <span>Người dùng</span></a>
        </li>
    @endif
    <!-- General settings -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

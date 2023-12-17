@extends('frontend.layouts.master')

@section('title','HaVyBakery || Blog Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Tin tức</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Blog Single -->
    <section class="blog-single shop-blog grid section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        @foreach($blogs as $blog)
                        {{-- {{$post}} --}}
                            <div class="col-lg-6 col-md-6 col-12">
                                <!-- Start Single Blog  -->
                                <div class="shop-single-blog">
                                <img src="{{ asset('image/blog/'. $blog->image) }}" alt="{{ $blog->image }}" style="height: 250px">
                                    <div class="content">
                                        <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i> {{$blog->created_at->format('d M, Y. D')}}
                                            <span class="float-right">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                 {{$blog->user->name ?? 'Anonymous'}}
                                            </span>
                                        </p>
                                        <a href="{{route('blog.detail',$blog->id)}}" class="title">{{$blog->name}}</a>
                                        <a href="{{route('blog.detail',$blog->id)}}" class="more-btn">Đọc tin tức</a>
                                    </div>
                                </div>
                                <!-- End Single Blog  -->
                            </div>
                        @endforeach
                        <div class="col-12">
                            <!-- Pagination -->
                            {{-- {{$posts->appends($_GET)->links()}} --}}
                            <!--/ End Pagination -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget search">
                            <form class="form" method="GET" action="">
                                <input type="text" placeholder="Tìm kiếm name="search">
                                <button class="button" type="sumbit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Single Widget -->
                     
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">Tin tức gần đây</h3>
                            @foreach($recent_blogs as $blog)
                                <!-- Single Post -->
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{ asset('image/blog/'. $blog->image) }}" alt="">
                                    </div>
                                    <div class="content">
                                        <h5><a href="#">{{$blog->name}}</a></h5>
                                        <ul class="comment">
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i>{{$blog->created_at->format('d M, y')}}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                {{$blog->user->name ?? 'Anonymous'}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Post -->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blog Single -->
@endsection
@push('styles')
    <style>
        .pagination{
            display:inline-flex;
        }
    </style>

@endpush

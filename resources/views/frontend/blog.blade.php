@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">24h công nghệ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">24h công nghệ</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($posts as $post)
                        <li class="clearfix">
                            <a href="{{route('detail_blog',$post->id)}}" title="" class="thumb fl-left">
                                <img src="{{asset('images')}}/{{$post->thumbnail}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{route('detail_blog',$post->id)}}" title="" class="title">{{$post->title}}</a>
                                <span class="create-date">{{$post->created_at->format('d/m/Y')}}</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        {{$posts->links()}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($products as $item)
                        <li class="clearfix">
                            <a href="{{route('detail_product',[$item->slug,$item->id])}}" title="" class="thumb fl-left">
                                <img src="{{asset('images')}}/{{$item->thumbnail}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{route('detail_product',[$item->slug,$item->id])}}" title="" class="product-name">{{$item->name}}</a>
                                <div class="price">
                                    <span class="new">{{number_format($item->price,0,',','.')}}đ</span>
                                    {{-- <span class="old">7.190.000đ</span> --}}
                                </div>
                                <a href="{{route('buy_now',[$item->slug])}}" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="?page=detail_blog_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

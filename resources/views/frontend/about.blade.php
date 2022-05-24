@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="clearfix detail-blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">{{$about->name}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Doanh nghiệp EU tìm kiếm cơ hội hợp tác đầu tư công nghệ xanh tại Việt Nam</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">{{$about->created_at->format('d/m/Y')}}</span>
                    <div class="detail">
                        {!! $about->content !!}
                    </div>
                </div>
            </div>
            <div class="section" id="social-wp">
                <div class="section-detail">
                    <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    <div class="g-plusone-wp">
                        <div class="g-plusone" data-size="medium"></div>
                    </div>
                    <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm mới nhất</h3>
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
                    <a href="?page=detail_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

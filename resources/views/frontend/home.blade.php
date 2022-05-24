@extends('layouts.home')
@section('content')
    <div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    @foreach ($slides as $slide)
                    <div class="item" id="item">
                        <img src="{{asset('images')}}/{{$slide->thumbnail}}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="{{asset('images/icon-1.png')}}">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('images/icon-2.png')}}">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('images/icon-3.png')}}">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('images/icon-4.png')}}">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('images/icon-5.png')}}">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm mới nhất</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($new_products as $new_product)
                        <li>
                            <a href="{{route('detail_product',[$new_product->slug])}}" title="" class="thumb">
                                <img src="{{asset('images')}}/{{$new_product->thumbnail}}">
                            </a>
                            <a href="{{route('detail_product',[$new_product->slug])}}" title="" class="product-name">{{Str::of($new_product->name)->limit(18)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($new_product->price,0,',','.')}}đ</span>
                                {{-- <span class="old">6.190.000đ</span> --}}
                            </div>
                            <div class="action d-flex justify-content-around">
                                <a href="{{route('add.cart',['slug' => $new_product->slug])}}" data-url="{{route('add.cart',['slug' => $new_product->slug])}}" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                                <a href="{{route('buy_now',[$new_product->slug])}}" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Điện thoại</h3>
                </div>

                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($mobilePhones as $item)
                        <li>
                            <a href="{{route('detail_product',$item->slug)}}" title="" class="thumb">
                                <img src="{{asset('images')}}/{{$item->thumbnail}}">
                            </a>
                            <a href="{{route('detail_product',[$item->slug])}}" title="" class="product-name">{{Str::of($item->name)->limit(20)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($item->price,0,',','.')}}đ</span>
                                {{-- <span class="old">8.990.000đđ</span> --}}
                            </div>
                            <div class="action d-flex justify-content-around">
                                <a href="{{route('add.cart',$item->slug)}}" data-url="{{route('add.cart',['slug' => $item->slug])}}" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                                <a href="{{route('buy_now',$item->slug)}}" title="Mua ngay" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @if (count($laptops)>0)
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Laptop</h3>
                </div>
                <div class="section-detail">

                    <ul class="list-item clearfix">
                        @foreach ($laptops as $laptop)
                        <li>
                            <a href="{{route('detail_product',[$laptop->slug])}}" title="" class="thumb">
                                <img src="{{asset('images')}}/{{$laptop->thumbnail}}">
                            </a>
                            <a href="{{route('detail_product',[$laptop->slug])}}" title="" class="product-name">{{Str::of($laptop->name)->limit(35)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($laptop->price,0,',','.')}}đ</span>
                                {{-- <span class="old">8.690.000đ</span> --}}
                            </div>
                            <div class="action d-flex justify-content-around">
                                <a href="{{route('add.cart',['slug' => $laptop->slug])}}" title="Thêm giỏ hàng" data-url="{{route('add.cart',['slug' => $laptop->slug])}}" class="add-cart">Thêm giỏ hàng</a>
                                <a href="{{route('buy_now',[$laptop->slug])}}" title="Mua ngay" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        {{-- Sidebar --}}
        <div class="sidebar fl-left">
            <div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
                    @foreach ($product_cats as $product_cat)
                    @if ($product_cat->parent_id == 0)
                        <li>
                            {{-- <a href="{{route('product_cat',[$product_cat->slug,$product_cat->id])}}" title="">{{$product_cat->name}}</a> --}}
                            <a href="{{route('product_cat',[$product_cat->slug])}}" title="">{{$product_cat->name}}</a>
                            @foreach ($brands as $k)
                            @if ($k->cat_id == $product_cat->id)
                            <ul class="sub-menu">
                            @foreach ($brands as $v)
                            @if ($v->cat_id == $product_cat->id)
                            <li>
                                <a href="{{route('brand',[$product_cat->slug,$v->slug])}}" title="">{{$v->name}}</a>
                            </li>
                            @endif
                            @endforeach
                            </ul>
                            @endif
                            @endforeach
                        </li>
                    @endif
                    @endforeach
                </ul>
                </div>
            </div>
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($new_products as $value)
                        <li class="clearfix">
                            <a href="{{route('detail_product',[$value->slug])}}" title="" class="thumb fl-left">
                                <img src="{{asset('images')}}/{{$value->thumbnail}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{route('detail_product',[$value->slug])}}" title="" class="product-name">{{Str::of($value->name)->limit(10)}}</a>
                                <div class="price">
                                    <span class="new">{{number_format($value->price,0,',','.')}}đ</span>
                                    {{-- <span class="old">7.190.000đ</span> --}}
                                </div>
                                <a href="{{route('buy_now',[$value->slug])}}" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="" title="" class="thumb">
                        <img src="{{asset('images/banner.png')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('menu-respon')
<div id="menu-respon">
    <a href="{{url('/')}}" title="" class="logo">VSHOP</a>
    <div id="menu-respon-wp">
        <ul id="main-menu-respon">
            @foreach ($product_cats as $product_cat)
                    @if ($product_cat->parent_id == 0)
                        <li>
                            {{-- <a href="{{route('product_cat',[$product_cat->slug,$product_cat->id])}}" title="">{{$product_cat->name}}</a> --}}
                            <a href="{{route('product_cat',[$product_cat->slug])}}" title="">{{$product_cat->name}}</a>
                            @foreach ($brands as $k)
                            @if ($k->cat_id == $product_cat->id)
                            <ul class="sub-menu">
                            <li>
                                <a href="{{route('brand',[$product_cat->slug,$k->slug])}}" title="">{{$k->name}}</a>
                            </li>
                            </ul>
                            @endif
                            @endforeach
                        </li>
                    @endif
            @endforeach
        </ul>
    </div>
</div>
@endsection

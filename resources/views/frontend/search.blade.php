@extends('layouts.home')
@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Tìm kiếm</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">

                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">Tìm kiếm sản phẩm: {{ $keyword }}</h3>
                    </div>

                    @if (count($products) > 0)
                        <div class="section-head clearfix">
                            <div class="filter-wp fl-right">
                                @if ($keyword == '')
                                    <p class="desc">Tìm thấy {{ $total->count() }} sản phẩm</p>
                                @else
                                    <p class="desc">Tìm thấy {{ count($products) }} sản phẩm</p>
                                @endif

                            </div>
                        </div>
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                @foreach ($products as $item)
                                    <li>
                                        <a href="{{ route('detail_product', [$item->slug]) }}" title=""
                                            class="thumb">
                                            <img src="{{ asset('images') }}/{{ $item->thumbnail }}">
                                        </a>
                                        <a href="{{ route('detail_product', [$item->slug]) }}" title=""
                                            class="product-name">{{ Str::of($item->name)->limit(20) }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                                            {{-- <span class="old">20.900.000đ</span> --}}
                                        </div>
                                        <div class="action clearfix">
                                            <a href="{{ route('add.cart', $item->slug) }}"
                                                data-url="{{ route('add.cart', $item->slug) }}" title="Thêm giỏ hàng"
                                                class="add-cart fl-left">Thêm giỏ hàng</a>
                                            <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="filter-wp">
                            <p class="text-center">Không tìm thấy sản phẩm nào</p>
                        </div>
                    @endif

                </div>
                <div class="section" id="paging-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            {{ $products->links() }}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        <ul class="list-item">
                            @foreach ($cats as $product_cat)
                                @if ($product_cat->parent_id == 0)
                                    <li>
                                        <a href="{{ route('product_cat', [$product_cat->slug]) }}"
                                            title="">{{ $product_cat->name }}</a>
                                        @foreach ($list_brand as $k)
                                            @if ($k->cat_id == $product_cat->id)
                                                <ul class="sub-menu">
                                                    @foreach ($list_brand as $v)
                                                        @if ($v->cat_id == $product_cat->id)
                                                            <li>
                                                                <a href="{{ route('brand', [$product_cat->slug, $v->slug]) }}"
                                                                    title="">{{ $v->name }}</a>
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
                {{-- <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <li class="clearfix">
                            <a href="?page=detail_product" title="" class="thumb fl-left">
                                <img src="public/images/img-pro-13.png" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="?page=detail_product" title="" class="product-name">Laptop Asus A540UP I5</a>
                                <div class="price">
                                    <span class="new">5.190.000đ</span>
                                    <span class="old">7.190.000đ</span>
                                </div>
                                <a href="" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        <li class="clearfix">
                            <a href="?page=detail_product" title="" class="thumb fl-left">
                                <img src="public/images/img-pro-11.png" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="?page=detail_product" title="" class="product-name">Iphone X Plus</a>
                                <div class="price">
                                    <span class="new">15.190.000đ</span>
                                    <span class="old">17.190.000đ</span>
                                </div>
                                <a href="" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        <li class="clearfix">
                            <a href="?page=detail_product" title="" class="thumb fl-left">
                                <img src="public/images/img-pro-12.png" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="?page=detail_product" title="" class="product-name">Iphone X Plus</a>
                                <div class="price">
                                    <span class="new">15.190.000đ</span>
                                    <span class="old">17.190.000đ</span>
                                </div>
                                <a href="" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="" title="" class="thumb">
                            <img src="{{ asset('images/banner.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('menu-respon')
    <div id="menu-respon">
        <a href="{{ url('/') }}" title="" class="logo">VSHOP</a>
        <div id="menu-respon-wp">
            <ul id="main-menu-respon">
                @foreach ($cats as $product_cat)
                    @if ($product_cat->parent_id == 0)
                        <li>
                            <a href="{{ route('product_cat', [$product_cat->slug]) }}"
                                title="">{{ $product_cat->name }}</a>
                            @foreach ($list_brand as $k)
                                @if ($k->cat_id == $product_cat->id)
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('brand', [$product_cat->slug, $k->slug]) }}"
                                                title="">{{ $k->name }}</a>
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

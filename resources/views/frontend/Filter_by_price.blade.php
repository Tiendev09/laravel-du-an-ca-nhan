@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                {{-- @foreach ($product_cats as $v)
                 @endforeach --}}
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">{{$product_cats->name}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">
                        @if ($act == 0)
                            {{$product_cats->name}} trên 5 triệu
                        @endif
                        @if ($act == 1)
                            {{$product_cats->name}} từ 5 triệu - 10 triệu
                        @endif
                        @if ($act == 2)
                            {{$product_cats->name}} từ 10 triệu - 15 triệu
                        @endif
                        @if ($act == 3)
                            {{$product_cats->name}} từ 15 triệu - 20 triệu
                        @endif
                        @if ($act == 4)
                            {{$product_cats->name}} trên 20 triệu
                        @endif
                    </h3>
                    @if ($products->count()>0)
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiện có {{$products->count()}} sản phẩm</p>
                    </div>
                    @else
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiện chưa có sản phẩm</p>
                    </div>
                    @endif

                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($products as $item)
                        <li>
                            <a href="{{route('detail_product',[$item->slug])}}" title="" class="thumb">
                                <img src="{{asset('images')}}/{{$item->thumbnail}}">
                            </a>
                            <a href="{{route('detail_product',[$item->slug])}}" title="" class="product-name">{{Str::of($item->name)->limit(20)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($item->price,0,',','.')}}đ</span>
                                {{-- <span class="old">20.900.000đ</span> --}}
                            </div>
                            <div class="action clearfix">
                                <a href="{{route('add.cart',$item->slug)}}" data-url="{{route('add.cart',$item->slug)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{$products->links()}}
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
                            <a href="{{route('product_cat',[$product_cat->slug])}}" title="">{{$product_cat->name}}</a>
                            {{-- <a href="{{route('product_cat',[$product_cat->slug])}}" title="">{{$product_cat->name}}</a> --}}
                            @foreach ($list_brand as $k)
                            @if ($k->cat_id == $product_cat->id)
                            <ul class="sub-menu">
                            @foreach ($list_brand as $v)
                            @if ($v->cat_id == $product_cat->id)
                            <li>
                                <a href="{{route('brand',[$product_cat->slug,$v->slug])}}" title="">{{$v->name}}</a>
                                {{-- <a href="{{route('brand',[$v->slug])}}" title="">{{$v->name}}</a> --}}
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
                        @foreach ($product as $item)
                        <li class="clearfix">
                            <a href="{{route('detail_product',[$item->slug])}}" title="" class="thumb fl-left">
                                <img src="{{asset('images')}}/{{$item->thumbnail}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{route('detail_product',[$item->slug])}}" title="" class="product-name">{{Str::of($item->name)->limit(20)}}</a>
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
            <div class="section" id="filter-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <form action="{{route('product.action.price',$product_cats->slug)}}">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" value="0" checked id="price500" name="r-price">
                                    </td>
                                    <td><label for="price500">Dưới 5000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value="1" id="price1000" name="r-price"></td>
                                    <td><label for="price1000">5000.000đ - 10.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value="2" id="price5000" name="r-price"></td>
                                    <td><label for="price5000">10.000.000đ - 15.000.000đ</label></td>

                                </tr>
                                <tr>
                                    <td><input type="radio" value="3" id="price10000" name="r-price"></td>
                                    <td><label for="price10000">15.000.000đ - 20.000.000đ</label></td>
                                </tr>
                                <tr>
                                    <td><input type="radio" value="4" id="price100000" name="r-price"></td>
                                    <td><label for="price100000">Trên 20.000.000đ</label></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit"  class="btn btn-sm btn-success">Lọc sản phẩm</button>
                    </form>
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


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
                    <h3 class="section-title fl-left">{{$product_cats->name}}</h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiện có {{count($product_cats->products)}} sản phẩm</p>
                        <div class="form-filter">
                            <form action="{{route('product.action',$product_cats->slug)}}">
                                <select name="act">
                                    <option value="0">Sắp xếp</option>
                                    <option value="1">Từ A-Z</option>
                                    <option value="2">Từ Z-A</option>
                                    <option value="3">Giá cao xuống thấp</option>
                                    <option value="4">Giá thấp lên cao</option>
                                </select>
                                <button type="submit">Lọc</button>
                            </form>
                        </div>
                        @if($act == 1)
                            <p>Tên sản phẩm từ A-Z</p>
                        @endif
                        @if($act == 2)
                            <p>Tên sản phẩm từ Z-A</p>
                        @endif
                        @if($act == 3)
                            <p>Giá sản phẩm từ cao xuống thấp</p>
                        @endif
                        @if($act == 4)
                            <p>Giá sản phẩm từ thấp đến cao</p>
                        @endif
                    </div>
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
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        {{$products->links()}}
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
                                <a href="{{route('detail_product',[$item->slug])}}" title="" class="product-name">{{Str::of($item->thumbnail)->limit(20)}}</a>
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
                    <form method="POST" action="">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>Dưới 500.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>500.000đ - 1.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>1.000.000đ - 5.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>5.000.000đ - 10.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-price"></td>
                                    <td>Trên 10.000.000đ</td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Hãng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Acer</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Apple</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Hp</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Lenovo</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Samsung</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="r-brand"></td>
                                    <td>Toshiba</td>
                                </tr>
                            </tbody>
                        </table> --}}
                        <button type="submit"  class="btn btn-sm btn-success">Lọc sản phẩm</button>
                    </form>
                </div>
            </div>
            {{-- <div class="section mt-4" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Thương hiệu</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
                    @foreach ($list_brand as $brand)
                    @if ($brand->cat_id == $cat->id)
                    <li>
                        <a href="{{route('brand',[$brand->cat_id,$brand->id])}}" title="">{{$brand->name}}</a>
                    </li>
                    @endif
                    @endforeach
                </ul>
                </div>
            </div> --}}
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


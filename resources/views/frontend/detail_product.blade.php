@extends('layouts.home')
@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    {{-- @foreach ($detail_product as $k)
                @endforeach --}}
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ route('product_cat', [$detail_product->productCat->slug]) }}"
                                title="">{{ $detail_product->productCat->name }}</a>
                        </li>
                        <li>
                            <a href="">{{ $detail_product->name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <div class="thumb-wp fl-left">
                            <a href="" title="" id="main-thumb">
                                {{-- https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg --}}
                                {{-- https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg --}}
                                <img id="zoom" src="{{ asset('images') }}/{{ $detail_product->thumbnail }}"
                                    data-zoom-image="{{ asset('images') }}/{{ $detail_product->thumbnail }}" />
                            </a>
                            <div id="list-thumb">
                                @foreach ($detail_product->img as $k)
                                    <a href="" data-image="{{ asset('images') }}/{{ $k->img_url }}"
                                        data-zoom-image="{{ asset('images') }}/{{ $k->img_url }}">
                                        <img id="zoom" src="{{ asset('images') }}/{{ $k->img_url }}" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="thumb-respon-wp fl-left">
                            {{-- public/images/img-pro-01.png --}}
                            <img src="{{ asset('images') }}/{{ $detail_product->thumbnail }}" alt="">
                        </div>
                        <form action="{{ route('cart.add', [$detail_product->slug]) }}">
                            <div class="info fl-right">
                                <h3 class="product-name">{{ $detail_product->name }}</h3>
                                <div class="desc">
                                    <p>Bộ vi xử lý :Intel Core i505200U 2.2 GHz (3MB L3)</p>
                                    <p>Cache upto 2.7 GHz</p>
                                    <p>Bộ nhớ RAM :4 GB (DDR3 Bus 1600 MHz)</p>
                                    <p>Đồ họa :Intel HD Graphics</p>
                                    <p>Ổ đĩa cứng :500 GB (HDD)</p>
                                </div>
                                <div class="num-product">
                                    <span class="title">Tình trạng: </span>
                                    @if ($k->status == 0)
                                        <span class="status">Còn hàng</span>
                                    @endif
                                    @if ($k->status == 1)
                                        <span class="status">Hết hàng</span>
                                    @endif
                                    @if ($k->status == 2)
                                        <span class="status">Đang về hàng</span>
                                    @endif
                                </div>
                                <p class="price">Giá: {{ number_format($detail_product->price, 0, ',', '.') }}đ</p>
                                <div id="num-order-wp">
                                    <label for="">Số lượng:</label>
                                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                    <input type="text" name="qty" value="1" id="num-order">
                                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                </div>
                                <input type="submit" style="border: none; outline: none;"
                                    class="btn btn-primary add-to-cart" value="Thêm giỏ hàng">
                                {{-- <a href="" type="submit" title="Thêm giỏ hàng" class="btn btn-primary add-to-cart">Thêm giỏ hàng</a> --}}
                            </div>
                        </form>
                    </div>
                </div>
                @if ($detail_product->content != '')
                    <div class="section" id="post-product-wp">
                        <div class="section-head">
                            <h3 class="section-title">Mô tả sản phẩm</h3>
                        </div>
                        <div class="section-detail">
                            {!! $detail_product->content !!}
                            {{-- <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p>
                    <p>Máy tính xách tay HP Probook 440 G2 là dòng máy tính xách tay thích hợp cho doanh nghiệp và những người làm văn phòng. Do đó, ngoài cấu hình tốt, thiết kế bền bỉ, máy tính xách tay HP Probook 440 G2 còn có khả năng bảo mật toàn diện giúp bạn luôn yên tâm về dữ liệu của mình.</p> --}}
                            <div class="accor">
                                <p class="text-white acc">Thu gọn nội dung</p>
                            </div>
                        </div>
                        <div class="accordion">
                            <p class="text-white">Xem thêm nội dung</p>
                        </div>
                    </div>

                @else
                    <div class="section-head mb-4 mt-4">
                        <h3 class="section-title">Hiện chưa có thông tin về sản phẩm</h3>
                    </div>
                @endif

                <div class="section" id="same-category-wp">
                    <div class="section-head">
                        <h3 class="section-title">Cùng chuyên mục</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($same_category as $value)
                                <li>
                                    <a href="" title="" class="thumb">
                                        <img src="{{ asset('images') }}/{{ $value['thumbnail'] }}">
                                    </a>
                                    <a href="{{ route('detail_product', [$value->slug, $value->id]) }}" title=""
                                        class="product-name">{{ Str::of($value->name)->limit(20) }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($value->price, 0, ',', '.') }}đ</span>
                                        {{-- <span class="old">20.900.000đ</span> --}}
                                    </div>
                                    <div class="action d-flex justify-content-around">
                                        <a href="{{ route('add.cart', ['slug' => $value->slug]) }}" title="Thêm giỏ hàng"
                                            data-url="{{ route('add.cart', ['slug' => $value->slug]) }}"
                                            class="add-cart">Thêm giỏ hàng</a>
                                        <a href="{{ route('buy_now', [$value->slug]) }}" title="" class="buy-now">Mua
                                            ngay</a>
                                    </div>
                                </li>
                            @endforeach
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
                                        {{-- <a href="{{route('product_cat',[$product_cat->slug,$product_cat->id])}}" title="">{{$product_cat->name}}</a> --}}
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
    <script>
        $(document).ready(function() {
            $('.accordion').click(function() {
                $(this).parent('.section').addClass('active');
                $(this).css('display', 'none');
            });
            $('.accor').click(function() {
                $('#post-product-wp').removeClass('active');
                $('.accordion').css('display', 'block');
            });
        });
    </script>
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

@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="checkout-page">
    @if (session('danger'))
        <p class="alert alert-warning">{{session('danger')}}</p>
    @endif
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @foreach ($content as $item)
    @endforeach
    <form action="{{route('store_buy_now',$item->slug)}}" method="post">
        @csrf
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin khách hàng</h1>
            </div>
            <div class="section-detail">
                        <div class="form-group">
                            <label for="fullname" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" id="fullname">
                            @error('fullname')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input class="form-control" type="text" value="{{ old('address') }}" name="address" id="address">
                            @error('address')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input class="form-control" required type="text" pattern="[0-9]{10,11}" value="{{ old('phone') }}" name="phone" id="phone">
                            @error('phone_number')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="note" class="form-label">Ghi chú (Không bắt buộc)</label>
                            <textarea class="form-group" name="note" id="note" rows="5" style="width:100%"></textarea>
                        </div>

            </div>
        </div>
        <div class="section" id="order-review-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin đơn hàng</h1>
            </div>
            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <td>Sản phẩm</td>
                            <td>Tổng</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($content as $item)
                        <tr class="cart-item">
                            <td class="product-name">{{Str::of($item->name)->limit(30)}}<strong class="product-quantity">x 1</strong></td>
                            <td class="product-total">{{number_format($item->price,0,',','.')}}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="order-total">
                            <td>Tổng đơn hàng:</td>
                            <td><strong class="total-price">{{number_format($item->price,0,',','.')}}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div id="payment-checkout-wp">
                    <ul id="payment_methods">
                        <li>
                            <input type="radio" id="direct-payment" name="payment_method" value="0">
                            <label for="direct-payment">Thanh toán tại cửa hàng</label>
                        </li>
                        <li>
                            {{-- payment-home --}}
                            <input type="radio" checked id="payment-home" name="payment_method" value="1">
                            <label for="payment-home">Thanh toán tại nhà</label>
                        </li>
                    </ul>
                </div>
                <div class="place-order-wp clearfix">
                    <button type="submit" class="btn btn-primary">Đặt hàng</button>
                </div>
            </div>
        </div>
    </div>
</form>
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

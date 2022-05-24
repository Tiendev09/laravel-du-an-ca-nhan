@extends('layouts.home')
@section('content')

<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="Trang chủ">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{url('/cart/show')}}" title="Giỏ hàng">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        @if (session('status'))
            <p class="alert alert-success">{{session('status')}}</p>
        @endif
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                {{-- {{route('cart.ajax')}}" method="POST" --}}
                <form method="POST" style="min-height: 300px;">
                    @csrf
                @if (Cart::count()>0)
                <table class="table">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td colspan="2">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                        @foreach (Cart::content() as $item)
                        @php
                            $t++;
                        @endphp
                        <tr>
                            <td>{{$t}}</td>
                            <td>
                                <a href="" title="" class="thumb">
                                    <img src="{{asset('images')}}/{{$item->options->thumbnail}}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="{{route('detail_product',$item->options->slug)}}" title="" class="name-product">{{Str::of($item->name)->limit(30)}}</a>
                            </td>
                            <td class="price">{{number_format($item->price,0,',','.')}}đ</td>
                            <td>
                                {{-- onchange="update_cart(this.value,'{{$item->rowId}}');" --}}
                                <input type="number" data-id="{{$item->id}}" onchange="update_cart(this.value,'{{$item->rowId}}');" name="qty[{{$item->rowId}}]" min="1" value="{{$item->qty}}" class="num-order">
                            </td>
                            <td id="sub-total-{{$item->id}}">{{number_format($item->subtotal)}}đ</td>
                            <td>
                                <a href="{{route('cart.delete',$item->rowId)}}" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');" title="" class="del-product"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá: <span>{{number_format(Cart::total(),0,',','.')}}đ</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        {{-- <input type="submit" title="" value="Cập nhật giỏ hàng" id="update-cart"> --}}
                                        <a href="{{url('/checkout')}}" title="" id="checkout-cart">Thanh toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <a href="{{url('/')}}" title="" id="buy-more">Mua tiếp</a><br/>
                <a href="{{url('/cart/destroy')}}" onclick="return confirm('Bạn có thực sự muốn xóa toàn bộ sản phẩm có trong giỏ hàng ?');" title="" id="delete-cart">Xóa giỏ hàng</a>
            </div>
        </div>
    </form>
        @else
        <p>Không có sản phẩm nào trong giỏ hàng</p>
        <a href="{{url('/')}}" title="" id="buy-more">Mua sản phẩm</a><br/>
        @endif

    </div>
</div>
<script>
    function update_cart(qty,rowId){
        var _token = $("input[name='_token']").val();
        $.post(
            "{{route('cart.ajax')}}",
            {qty:qty,rowId:rowId,_token:_token},
            function(){
                location.reload();
            }
        );
    }
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


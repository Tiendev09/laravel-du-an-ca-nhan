@extends('layouts.home')
@section('content')
<div id="main-content-wp" class="checkout-page">

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
    <div id="wrapper" class="wp-inner clearfix">
    <h3 class="text-center text-uppercase text-success">Cảm ơn quý khách đã mua hàng tại Ismart</h3><br>
        <p class="text-center ">Chúng tôi sẽ liên lạc với bạn trong khoảng 5 phút tới để xác nhận đơn hàng</p>
        <br>
        <div class="row">
            <div class="col-md-12 text-center">
                <h3 class="text-success mb-2">Thông tin khách hàng</h3>
                <p class="text-center"><strong>Họ và tên: </strong>{{$data['info']['fullname']}}</p>
                <p class="text-center"><strong>Email: </strong>{{$data['info']['email']}}</p>
                <p class="text-center"><strong>Địa chỉ: </strong>{{$data['info']['address']}}</p>
                <p class="text-center"><strong>Số điện thoại: </strong>{{$data['info']['phone_number']}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><br>
                <h3 class="text-center text-success mb-2">Thông tin đơn hàng</h3>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Thành tiền</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($content as $item)
                        <tr>
                            <td scope="row">{{Str::of($item->name)->limit(30)}}</td>
                            <td>1</td>
                            <td>{{number_format($item->price,0,',','.')}}đ</td>
                            <td>{{number_format($item->price,0,',','.')}}đ</td>
                          </tr>
                        @endforeach
                        @foreach ($content as $item)
                        <tr>
                            <td colspan="4" style="font-size:20px;"><span class="font-weight-bold text-danger ">Tổng tiền thanh toán: </span>{{number_format($item->price,0,',','.')}}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

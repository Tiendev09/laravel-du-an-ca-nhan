@extends('layouts.admin')
@section('content')
<h2 class="text-center pt-2">Thông tin đơn hàng</h2>
<p class="pl-3"><span class="font-weight-bold">Mã đơn hàng:</span> {{$detail_order->code}}</p>
<p class="pl-3"><span class="font-weight-bold">Tên khách hàng:</span> {{$detail_order->fullname}}</p>
<p class="pl-3"><span class="font-weight-bold">Email:</span> {{$detail_order->email}}</p>
<p class="pl-3"><span class="font-weight-bold">Địa chỉ:</span> {{$detail_order->address}}</p>
<p class="pl-3"><span class="font-weight-bold">Số điện thoại:</span> {{$detail_order->phone_number}}</p>
<p class="pl-3"><span class="font-weight-bold">Tổng số tiền:</span> {{number_format($detail_order->total,0,',','.')}}đ</p>
@if ($detail_order->pay == 1)
<p class="pl-3"><span class="font-weight-bold">Hình thức thanh toán: </span>Thanh toán tại nhà</p>
@endif
@if ($detail_order->pay == 0)
<p class="pl-3"><span class="font-weight-bold">Hình thức thanh toán: </span>Thanh toán qua thẻ tín dụng</p>
@endif
<div class="form-action form-inline p-3">
    <form action="{{route('admin.order.update',$detail_order->id)}}" method="POST">
        @csrf
<select class="form-control mr-1" name="act">
    <option value="0">Đang xử lý</option>
    <option value="1">Thành công</option>
    <option value="2">Đang vận chuyển</option>
    <option value="3">Hủy</option>
</select>
<input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
</form>
</div>
<div class="table-responsive-sm">
    <h2 class="text-center">Sản phẩm đã mua</h2>
    <table class="table table-hover table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Sản phẩm</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Đơn giá</th>
            <th scope="col">Thành tiền</th>
          </tr>
        </thead>
        <tbody>
            @php
                $t=0;
            @endphp
            @foreach ($detail as $item)
            @php
                $t++;
            @endphp
            <tr>
                <th scope="row">{{$t}}</th>
                <td>{{Str::of($item->products->name)->limit(40)}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{number_format($item->products->price,0,',','.')}}đ</td>
                <td>{{number_format($item->quantity * $item->products->price,0,',','.')}}đ</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="5">
                    <p class="text-danger">Tổng giá trị:{{number_format($item->orders->total,0,',','.')}}đ</p>
                </th>
            </tr>
        </tbody>
      </table>
  </div>
@endsection

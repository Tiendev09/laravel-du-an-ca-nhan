@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    @if (session('status'))
        <p class="alert alert-success">{{session('status')}}</p>
    @endif
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[0]}}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[1]}}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG VẬN CHUYỂN</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[2]}}</h5>
                    <p class="card-text">Đơn hàng đang được vận chuyển</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($total,0,',','.')}}đ</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[3]}}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-header">BÀI VIẾT</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[4]}}</h5>
                    <p class="card-text">Số bài viết có trong hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">SỐ LƯỢNG SẢN PHẨM</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[5]}}</h5>
                    <p class="card-text">Số sản phẩm có trong hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                <div class="card-header">THÀNH VIÊN</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[6]}}</h5>
                    <p class="card-text">Số lượng thành viên</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        @can('detail-order')
                        <th scope="col">Chi tiết</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @php
                        $t=0;
                    @endphp
                    @foreach ($orders as $item)
                    @php
                        $t++;
                    @endphp
                    <tr>
                        <th scope="row">{{$t}}</th>
                        <td>{{$item->code}}</td>
                        <td>
                            {{$item->fullname}}
                        </td>
                        <td>{{$item->phone_number}}</td>
                        <td>{{number_format($item->total,0,',','.')}}đ</td>
                        @if ($item->status == '0')
                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                        @endif
                        @if ($item->status == '1')
                        <td><span class="badge badge-success">Thành công</span></td>
                        @endif
                        @if ($item->status == '2')
                        <td><span class="badge badge-primary">Đang vận chuyển</span></td>
                        @endif
                        @if ($item->status == '3')
                        <td><span class="badge badge-dark">Hủy</span></td>
                        @endif
                        <td>{{$item->created_at}}</td>
                        @can('detail-order')
                        <td>
                            <a href="{{route('admin.order.detail',$item->id)}}" class="btn btn-info btn-sm rounded-0 text-white" type="button" title="Chi tiết">Chi tiết</a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$orders->links()}}
        </div>
    </div>
</div>
@endsection

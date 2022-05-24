@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
        <p class="alert alert-success">{{session('status')}}</p>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="text" name="keyword" class="form-control form-search mr-1" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'Processing'])}}" class="text-primary">Đang xử lý<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'Success'])}}" class="text-primary">Thành công<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'Shipped'])}}" class="text-primary">Đang vận chuyển<span class="text-muted">({{$count[2]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'Cancel'])}}" class="text-primary">Hủy<span class="text-muted">({{$count[3]}})</span></a>
            </div>
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="">
                    <option>Chọn</option>
                    <option>Tác vụ 1</option>
                    <option>Tác vụ 2</option>
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Mã hóa đơn</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th>Chi tiết</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                @if ($orders->total()>0)
                <tbody>
                    @php
                        $t=0;
                    @endphp
                    @foreach ($orders as $item)
                    @php
                        $t++;
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>{{$t}}</td>
                        <td>{{$item->code}}</td>
                        <td>
                            {{$item->fullname}}
                        </td>
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
                        <td><a href="{{route('admin.order.detail',$item->id)}}">Chi tiết</a></td>
                        <td>
                            <a href="{{route('admin.order.delete',$item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                <p>Không có bản ghi nào</p>
                @endif
            </table>
            {{$orders->links()}}
        </div>
    </div>
</div>
@endsection

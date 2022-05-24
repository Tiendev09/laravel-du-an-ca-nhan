@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
        <p class="alert alert-success">{{session('status')}}</p>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="text" name="keyword" value="{{request()->input('keyword')}}" class="form-control form-search mr-1" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                @can('product-cat-list')
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary pr-1">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary pr-1">Đã xóa gần đây<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'stocking'])}}" class="text-primary pr-1">Còn hàng<span class="text-muted">({{$count[2]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'out_of_stock'])}}" class="text-primary pr-1">Hết hàng<span class="text-muted">({{$count[3]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'comming_soon'])}}" class="text-primary">Đang về hàng<span class="text-muted">({{$count[4]}})</span></a>
                @endcan
            </div>
            <div class="form-action form-inline py-3">
                <form action="{{url('admin/product/action')}}" method="POST">
                    @csrf
                <select class="form-control mr-1" name="act" id="">
                    @foreach ($list_act as $k=>$v)
                    <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <td><input type="checkbox" id="selectall"></td>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products->total()>0)
                    @php
                    $t=0;
                @endphp
                @foreach ($products as $product)
                @php
                    $t++;
                @endphp
                <tr>
                    <td>
                        <td><input type="checkbox" name="list_check[]" value="{{$product->id}}" class="select"></td>
                    </td>
                    <td>{{$t}}</td>
                    <td id="w-10"><img src="{{asset('images')}}/{{($product->thumbnail)}}" alt=""></td>
                    <td><a href="#">{{Str::of($product->name)->limit(30)}}</a></td>
                    <td>{{number_format($product->price,0,'','.')}}đ</td>
                    <td>{{$product->productCat->name}}</td>
                    <td>{{$product->created_at}}</td>
                    @if ($product->status == 0)
                    <td><span class="badge badge-success">Còn hàng</span></td>
                    @endif
                    @if ($product->status==1)
                    <td><span class="badge badge-dark">Hết hàng</span></td>
                    @endif
                    @if ($product->status==2)
                    <td><span class="badge badge-warning">Đang về hàng</span></td>
                    @endif
                    @if ($status == ''||$status == 'active' ||$status == 'stocking' ||$status == 'out_of_stock' ||$status == 'comming_soon')
                    <td>
                        @can('product-edit')
                        <a href="{{route('admin.product.edit',$product->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        @endcan
                        @can('product-delete')
                        <a href="{{route('admin.product.delete',$product->id)}}" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        @endcan
                    </td>
                    @endif
                    @if ($status == 'trash')
                    <td>
                        <a href="{{route('admin.product.restore',$product->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Restore"><i class="fas fa-history"></i></a>
                        @can('product-delete')
                        <a href="{{route('admin.product.force_delete',$product->id)}}" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        @endcan
                    </td>
                    @endif
                </tr>
                @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="bg-white text-dark">
                                Không tìm thấy bản ghi nào
                            </td>
                        </tr>
                    @endif

                </tbody>
                {{-- {!! $product ->content !!} --}}
            </table>
        </form>
            {{$products->links()}}
        </div>
    </div>
</div>
@endsection

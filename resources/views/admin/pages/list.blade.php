@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
        <p class="alert alert-success">{{session('status')}}</p>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="text" name="keyword" class="form-control form-search mr-1" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary pr-1">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Đã xóa gần đây<span class="text-muted">({{$count[1]}})</span></a>
                {{-- <a href="" class="text-primary">Trạng thái 3<span class="text-muted">(20)</span></a> --}}
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        {{-- <th scope="col">
                            <input name="checkall" id="selectall" type="checkbox">
                        </th> --}}
                        <th scope="col">#</th>
                        <th scope="col">Tên trang</th>
                        <th>Người tạo</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($pages->total()>0)
                        @php
                            $t=0;
                        @endphp
                        @foreach ($pages as $page)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                {{-- <td><input type="checkbox" name="list_check[]" value="" class="select"></td> --}}
                                <td scope="row">{{$t}}</td>
                                <td><a href="{{route('admin.page.detail',$page->id)}}">{{$page->name}}</a></td>
                                @if (!isset($page->user->name))
                                <td>Người tạo không còn tồn tại</td>
                                @else
                                <td>{{$page->user['name']}}</td>
                                @endif
                                <td>{{$page->created_at}}</td>
                                @if ($status == ''||$status == 'active')
                                <td><a href="{{route('admin.page.edit',$page->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('admin.page.delete',$page->id)}}" onclick="return confirm('Bạn có thực sự muốn xóa ?');" class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                                @endif
                                @if ($status == 'trash')
                                <td><a href="{{route('admin.page.restore',$page->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Restore"><i class="fa fa-history"></i></a>
                                    <a href="{{route('admin.page.force_delete',$page->id)}}" onclick="return confirm('Bạn có thực sự muốn xóa ?');" class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6"><p>Không có dữ liệu</p></td>
                        </tr>
                    @endif
                </tbody>
                {{$pages->links()}}
            </table>
        </div>
    </div>
</div>
@endsection

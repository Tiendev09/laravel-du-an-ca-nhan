@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
        <p class="alert alert-success">{{session('status')}}</p>
    @endif
    @if (session('danger'))
        <p class="alert alert-danger">{{session('danger')}}</p>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            Danh sách bài viết
        </div>
        <div class="card-body">
            <div class="card-body">
                <div class="analytic">
                    @can('list-post')
                    <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary pr-2">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                    <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary pr-2">Đã xóa gần đây<span class="text-muted">({{$count[1]}})</span></a>
                    <a href="{{request()->fullUrlWithQuery(['status'=>'public'])}}" class="text-primary pr-2">Công khai<span class="text-muted">({{$count[3]}})</span></a>
                    <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}" class="text-primary pr-2">Chờ duyệt<span class="text-muted">({{$count[2]}})</span></a>
                    @endcan
                </div>
            <div class="form-action form-inline py-3">
                <form action="{{url('admin/post/action')}}">
                <select class="form-control mr-1" name="act">
                    @foreach ($list_act as $k=>$v)
                    <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>

            <table class="table table-striped">

                <thead>
                    <tr>
                        <td><input type="checkbox" id="selectall"></td>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Danh mục</th>
                        {{-- <th scope="col">Người tạo</th> --}}
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($posts->total()>0)
                    @php
                        $t=0;
                    @endphp
                    @foreach ($posts as $post)
                        @php
                            $t++;
                        @endphp
                        <tr>
                            <td><input type="checkbox" name="list_check[]" value="{{$post->id}}" class="select"></td>
                            <th scope="row">{{$t}}</th>
                            <td>{{Str::of($post->title)->limit(40)}}</td>
                            <td>{{$post->cat->name}}</td>
                            {{-- Không được để user nào bị xóa tạm thời --}}
                            {{-- <td>{{$post->user->name}}</td> --}}
                            <td>{{$post->created_at}}</td>
                            <td>
                                @if ($status == 'trash')
                                <a href="{{route('admin.post.restore',$post->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Restore"><i class="fas fa-history"></i></a>
                                @can('delete-post')
                                <a href="{{route('admin.post.force_delete',$post->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" onclick="return confirm('Bạn có thực sự muốn xóa ?')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endcan
                                @else
                                @can('edit-post')
                                <a href="{{route('admin.post.edit',$post->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete-post')
                                <a href="{{route('admin.post.delete',$post->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button" onclick="return confirm('Bạn có thực sự muốn xóa ?')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endcan
                                @endif
                            </td>
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
            </table>
        </div>
        {{$posts->links()}}
    </div>
</div>

@endsection

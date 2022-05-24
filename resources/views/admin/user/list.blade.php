@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
            <p class="alert alert-success">{{session('status')}}</p>
        @endif
        @if (session('danger'))
            <p class="alert alert-danger">{{session('danger')}}</p>
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5>Danh sách người dùng</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="text" class="form-control form-search mr-1" name="keyword" value="{{request()->input('keyword')}}" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                @can('user-list')
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary pr-2">Kích hoạt<span class="text-muted">{{$count[0]}}</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary pr-2">Vô hiệu hóa<span class="text-muted">{{$count[1]}}</span></a>
                @endcan
            </div>
            <div class="form-action form-inline py-3">
            <form action="{{url('admin/user/action')}}">
                <select class="form-control mr-1" name="act">
                    @foreach ($list_act as $k => $v)
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
                        <th scope="col">Họ tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Quyền</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users->total()>0)
                    @php
                    $t=0;
                @endphp
                @foreach ($users as $user)
                @php
                    $t++;
                @endphp
                <tr>
                    <td>
                        <input type="checkbox" name="list_check[]" value="{{$user->id}}" class="select">
                    </td>
                    <td scope="row">{{$t}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @foreach ($user->roles as $item)
                        <span class="badge badge-success">
                            {{$item->name}}
                        </span>
                        @endforeach
                    </td>
                    <td>{{$user->created_at}}</td>
                    @if ($status == 'trash')
                    <td>
                    <a href="{{route('admin.user.restore',$user->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Restore"><i class="fa fa-history"></i></a>
                    @can('user-delete')
                    <a href="{{route('forceDelete',$user->id)}}" onclick="return confirm('Bạn có muốn xóa thành viên này ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                    @endcan
                </td>
                @else
                <td>
                    @can('user-edit')
                    <a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                    @endcan
                    @if (Auth::id()!=$user->id)
                    @can('grand-permission-user')
                    <a href="{{route('admin.user.permission',$user->id)}}" class="btn btn-primary btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Cấp quyền">Cấp quyền</a>
                    @endcan
                    @can('user-delete')
                    <a href="{{route('delete_user',$user->id)}}" onclick="return confirm('Bạn có muốn xóa thành viên này ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                    @endcan
                    @endif
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
            </table>
            {{$users->links()}}
        </form>
        </div>

    </div>
</div>

@endsection

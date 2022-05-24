@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <style>
        #w-50{
            width: 50%;
        }
    </style>
    <div class="card">
        @if (session('status'))
            <p class="alert alert-success">{{session('status')}}</p>
        @endif
        @if (session('danger'))
            <p class="alert alert-danger">{{session('danger')}}</p>
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5>Danh sách quyền</h5>
        </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên vai trò</th>
                        <th scope="col">Mô tả vai trò</th>
                        <th scope="col">Các quyền</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                @if ($roles->count()>0)
                <tbody>
                    @php
                        $t=0;
                    @endphp
                    @foreach ($roles as $role)
                    @php
                        $t++;
                    @endphp
                    <tr>
                        <td scope="row">{{$t}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->desc}}</td>
                        <td id="w-50">
                            @foreach ($role->permissions as $permission)
                            <span class="badge badge-success">
                                {{$permission->name}}
                            </span>
                            @endforeach
                        </td>
                        <td>
                            @can('edit-role')
                            <a href="{{route('admin.role.edit',$role->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            @endcan
                            {{-- @can('delete-role')
                            <a href="{{route('admin.role.delete',$role->id)}}" onclick="return confirm('Bạn có muốn xóa thành viên này ?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            @endcan --}}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    @else
                        <tr>
                            <td colspan="8" class="bg-white text-dark">
                                Không tìm thấy bản ghi nào
                            </td>
                        </tr>
                @endif
            </table>
            {{$roles->links()}}
        </form>
        </div>
    </div>
</div>

@endsection

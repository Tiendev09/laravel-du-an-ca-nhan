@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
        <p class="alert alert-success">{{session('status')}}</p>
    @endif
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm quyền
                </div>
                <div class="card-body">
                    <form action="{{url('admin/permission/store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên quyền</label>
                            <input class="form-control" type="text" name="name" id="name">
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="desc">Mô tả</label>
                            <input class="form-control" type="text" name="desc" id="desc">
                        </div>
                        <div class="form-group">
                            <label for="">Thuộc quyền</label>
                            <select class="form-control" name="category">
                                <option value="0">Chọn quyền cha</option>
                                {{-- {!! $permissions !!} --}}
                                @foreach ($permissionParent as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách quyền
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên quyền</th>
                                <th scope="col">Mô tả</th>
                                {{-- <th scope="col">Tác vụ</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {!! $showCatTable !!} --}}
                            @php
                                $t=0;
                            @endphp
                            @foreach ($showCatTable as $value)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td scope="col">{{$t}}</td>
                                    <td scope="col">{{str_repeat('--',$value->level).$value->name}}</td>
                                    <td scope="col">{{$value->desc}}</td>
                                    {{-- <td scope="col">
                                        <a href="" onclick="return confirm('Bạn có thực sự muốn xóa?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td> --}}
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{-- {{$link->links()}} --}}
                    {{-- {{$link->links()}} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

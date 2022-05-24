@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
        <p class="alert alert-success">{{session('status')}}</p>
    @endif
    @if (session('danger'))
        <p class="alert alert-danger">{{session('danger')}}</p>
    @endif
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm thương hiệu
                </div>
                <form action="{{url('admin/product/brand/add')}}" method="POST">
                    <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label for="p_name">Tên Thương hiệu</label>
                                <input class="form-control" type="text" name="name" id="p_name">
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug') }}">
                            </div>
                            @error('slug')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" name="category">
                                <option value="0">Chọn danh mục cha</option>
                                {!! $cats !!}
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên thương hiệu</th>
                                <th>Danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t=0;
                            @endphp
                            @foreach ($brands as $brand)

                                @foreach ($brand as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td scope="col">{{$t}}</td>
                                    <td scope="col">{{$item->name}}</td>
                                    <td scope="col">{{$item->product_cats->name}}</td>
                                    <td scope="col">{{$item->created_at->format('d/m/Y')}}</td>
                                    <td scope="col">
                                        <a href="" onclick="return confirm('Bạn có thực sự muốn xóa?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    {{$links->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

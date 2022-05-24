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
                    Danh mục sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{url('admin/product/cat/add')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="p_name">Tên danh mục</label>
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
                        {{-- <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" name="category">
                                <option value="0">Chọn danh mục cha</option>
                                {!! $cats !!}
                            </select>
                        </div> --}}
                         {{-- <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                    Công khai
                                </label>
                            </div>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
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
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
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
                                <td scope="col">{{$value->created_at}}</td>
                                <td scope="col">
                                    @can('product-cat-delete')
                                    <a href="{{route('admin.productCat.delete',$value->id)}}" onclick="return confirm('Bạn có thực sự muốn xóa?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{$data->links()}} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

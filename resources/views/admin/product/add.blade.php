@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('danger'))
        <p class="alert alert-danger">{{session('danger')}}</p>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form action="{{url('admin/product/store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="p_name">Tên sản phẩm</label>
                    {{-- <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}"> --}}
                    <input class="form-control" type="text" name="name" id="p_name" value="{{ old('name') }}">
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
                    <label for="price">Giá</label>
                    <input class="form-control" type="text" name="price" id="price" value="{{ old('price') }}">
                    {{-- <input class="form-control" type="text" name="price" id="price" value="{{ old('price') }}"> --}}
                    @error('price')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" name="cats">
                        <option value="0">Chọn danh mục</option>
                        {!!$cats!!}
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Thương hiệu</label>
                    <select class="form-control" name="brands">
                        <option value="0">Chọn thương hiệu</option>
                        @foreach ($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="intro">Mô tả ngắn</label>
                    <textarea name="intro" class="form-control" id="intro" cols="10" rows="5">{{ old('intro') }}</textarea>
                    {{-- <textarea name="intro" class="form-control" id="intro" cols="10" rows="5">{{ old('intro') }}</textarea> --}}
                </div>
                <div class="form-group">
                    <label for="content">Chi tiết sản phẩm</label>
                    <textarea id="full" class="form-control" name="content" class="form-control" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                    {{-- <textarea id="full" class="form-control" name="content" class="form-control" id="content" cols="30" rows="5">{{ old('content') }}</textarea> --}}
                </div>
                <div class="form-group">
                    <label for="thumbnail">Ảnh đại diện</label><br>
                    <input type="file" value="{{ old('thumbnail') }}" name="thumbnail" id="thumbnail">
                </div>
                <div class="form-group">
                    <label for="feature_img">Ảnh chi tiết</label><br>
                    <input type="file" multiple name="feature_img[]" id="feature_img">
                </div>

                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="0" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Còn hàng
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="1">
                        <label class="form-check-label" for="exampleRadios2">
                            Hết hàng
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="2">
                        <label class="form-check-label" for="exampleRadios3">
                            Đang về hàng
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection

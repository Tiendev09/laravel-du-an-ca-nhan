@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa nội dung sản phẩm
        </div>
        <div class="card-body">
            <form action="{{route('admin.product.update',$products->id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ $products->name }}">
                    @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input class="form-control" type="text" name="slug" id="slug" value="{{ $products->slug }}">
                </div>
                <div class="form-group">
                    <label for="price">Giá</label>
                    <input class="form-control" type="text" name="price" id="price" value="{{ $products->price }}">
                    @error('price')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" name="cats">
                        @foreach ($cate as $item)
                        @if ($item->id == $products->cat_id)
                        <option value="{{$item->id}}" selected>{{$item->name}}</option>
                        @else
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Thương hiệu</label>
                    <select class="form-control" name="brands">
                        @foreach ($brands as $brand)
                        @if ($brand->id == $products->brand_id)
                        <option value="{{$brand->id}}" selected>{{$brand->name}}</option>
                        @else
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="intro">Mô tả ngắn</label>
                    <textarea name="intro" class="form-control" id="intro" cols="10" rows="5">{{ $products->intro }}</textarea>
                </div>
                <div class="form-group">
                    <label for="content">Chi tiết sản phẩm</label>
                    <textarea id="full" class="form-control" name="content" class="form-control" id="content" cols="30" rows="5">{{ $products->content }}</textarea>
                </div>
                <div class="form-group">
                    {{-- value="{{$products->thumbnail}}" --}}
                    <label for="thumbnail">Ảnh đại diện</label><br>
                    <input type="file" name="thumbnail" id="thumb"><br>
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
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>

@endsection

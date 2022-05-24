@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
        <p class="alert alert-danger">{{session('status')}}</p>
    @endif
        <div class="card-header font-weight-bold">
            Thêm bài viết
        </div>
        <div class="card-body">
            <form action="{{url('admin/post/store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" value="{{ old('title') }}" type="text" name="title" id="title">
                    @error('title')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea id="full" name="content" class="form-control" id="content">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="thumbnail">Ảnh đại diện</label><br>
                    <input type="file" name="thumbnail" id="thumbnail">
                    @error('thumbnail')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" name="act" id="">
                     {!!$list_post_cats!!}
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="0" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="1">
                        <label class="form-check-label" for="exampleRadios2">
                          Công khai
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection

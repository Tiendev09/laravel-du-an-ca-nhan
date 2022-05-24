@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm Slide
        </div>
        <div class="card-body">
            <form action="{{route('admin.slide.update',$slides->id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="thumbnail">Ảnh đại diện</label><br>
                    <input type="file" value="{{ old('thumbnail') }}" name="thumbnail" id="thumbnail">
                    @error('thumbnail')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>

@endsection

@extends('layouts.admin')
@section('content')
{{-- <script>
    $(document).ready(function(){
        $('.wp_checkbox').click(function(){
            alert("ok");
        });
    });
</script> --}}
<form method="POST" action="{{url('admin/role/store')}}" class="mb-4">
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm vai trò
        </div>
        <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="name">Tên vai trò</label>
                    <input class="form-control" value="{{ old('name') }}" type="text" name="name" id="name">
                    @error('name')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desc">Mô tả</label>
                    <input class="form-control" type="text" value="{{ old('desc') }}" name="desc" id="desc">
                    @error('desc')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
        </div>
    </div>
            <div class="card text-white mb-2 mt-2">
                <div class="card-header text-primary">
                    <label>
                        <input type="checkbox" class="transform" id="selectall">
                        Chọn toàn bộ quyền
                    </label>
                </div>
            </div>
    @foreach ($permissionParent as $item)
    <div class="card text-white mb-3">
        <div class="card-header bg-success">
            <label>
                <input type="checkbox" class="wp_checkbox select transform">
                {{$item->name}}
            </label>
        </div>
        <div class="card-body text-primary">
            <div class="row">
                @foreach ($item->permissionChild as $value)
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" value="{{$value->id}}" name="permission_id[]" class="transform child_checkbox select">
                        {{$value->name}}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

</div>
    <button type="submit" value="Thêm mới" name="btn-add" class="btn btn-primary">Thêm mới</button>
</form>

@endsection

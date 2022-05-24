@extends('layouts.admin')
@section('content')
{{-- <script>
    $(document).ready(function(){
        $('.wp_checkbox').click(function(){
            alert("ok");
        });
    });
</script> --}}
<form method="POST" action="{{route('admin.role.update',$role->id)}}" class="mb-4">
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm quyền
        </div>
        <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="name">Tên quyền</label>
                    <input class="form-control" value="{{ $role->name }}" type="text" name="name" id="name">
                    @error('name')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desc">Mô tả</label>
                    <input class="form-control" type="text" value="{{ $role->desc }}" name="desc" id="desc">
                    @error('desc')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
        </div>
    </div>
    @foreach ($permissionParent as $item)
    <div class="card text-white mb-3">
        <div class="card-header bg-success">
            <label>
                <input type="checkbox" class="wp_checkbox">
                {{$item->name}}
            </label>
        </div>
        <div class="card-body text-primary">
            <div class="row">
                @foreach ($item->permissionChild as $value)
                <div class="col-md-3">
                    <label>
                        <input type="checkbox" {{$permissionsChecked->contains('id',$value->id) ? 'checked' : ''}} value="{{$value->id}}" name="permission_id[]" class="child_checkbox">
                        {{$value->name}}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

</div>
    <button type="submit" value="Thêm mới" name="btn-add" class="btn btn-primary">Cập nhật</button>
</form>

@endsection

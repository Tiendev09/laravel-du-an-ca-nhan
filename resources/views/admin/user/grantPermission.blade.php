@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cấp quyền
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('admin.user.update.permission',$user->id)}}">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" disabled type="text" name="name" id="name" value="{{$user->name}}">
                    @error('name')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{$user->email}}" disabled>
                    @error('email')
                        <p class="form-text text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="js-example-basic-multiple form-control" name="role_id[]" multiple="multiple">
                        @foreach ($roles as $v)
                        <option {{$roleOfUser->contains('id', $v->id) ? 'selected' : ''}} value="{{$v->id}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" value="Cập nhật" name="btn-add" class="btn btn-primary">Cấp quyền</button>
            </form>
        </div>
    </div>
</div>
@endsection

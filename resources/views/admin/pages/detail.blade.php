@extends('layouts.admin')
@section('content')
<p class="pt-3">Ngày tạo: {{$detail->created_at->format('d/m/Y')}}</p>
{!!$detail->content!!}
@endsection

@extends('layouts._master');

@section('banner')
	<h1>Are you sure?</h1>
@stop

@section('content')
<div class="confirm-message">
	<p>Are you sure you want to {{$action}}?</p>
	@if($additional)
		<p>NOTE: {{$additional}}.</p>
	@endif
	<p>This cannot be undone.</p>
	{{Form::open(array('url'=>$url, 'method'=>'DELETE'))}}
	{{Form::submit('Delete')}}
	<a href="{{$back}}"><div classs="back">BACK</back></a>
	{{Form::close()}}
</div>
@stop
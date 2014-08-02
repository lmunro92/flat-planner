{{--Form for changing password --}}

@extends('layouts._master')

@section('banner')
<h1>Change Password</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/change-password/', 'method'=>'POST', 'class'=>'fp-form'))}}
	<div class="form-line">
		{{Form::label('old-password', 'Old Password: ')}}
		{{Form::password('old-password', array('class'=>'flat-text'))}}
	<div>
	<div class="form-line">
		{{Form::label('password', 'New Password: ')}}
		{{Form::password('new-password', array('class'=>'flat-text'))}}
	<div>
	<div class="form-line">
		{{Form::label('confirm', 'Confirm Password: ')}}
		{{Form::password('confirm', array('class'=>'flat-text'))}}
	<div>
	<div class="form-line">
		{{Form::submit('Update')}}
	</div>
{{Form::close()}}
@stop

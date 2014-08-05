{{-- Login Screen --}}

@extends('layouts._master')

@section('banner')
	<h1>Log in</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/login/', 'method'=>'POST', 'class'=>'fp-form'))}}
	<div class="form-line">
		{{Form::label('username', 'Username or E-mail Address: ')}}
		{{Form::text('username', '', array('class'=>'flat-text', 'size'=>'30'))}}
	</div>
	<div class="form-line">
		{{Form::label('password', 'Password: ')}}
		{{Form::password('password', array('class'=>'flat-text', 'size'=>'30'))}}
	</div>
	<div class="form-line">
		{{Form::checkbox('remember', 'remember', true, array('class'=>'flat-check'))}}
		{{Form::label('remember', 'Remember Me')}}
	</div>
	{{Form::submit('Login')}}
{{Form::close()}}
@stop
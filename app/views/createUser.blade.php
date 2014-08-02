{{-- Create/Edit User --}}
@extends('layouts._master')

@section('banner')
<h1>Create New User</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/create-user/', 'method'=>'POST', 'class'=>'fp-form'))}}
	<div class="form-line">
		{{Form::label('first-name', 'First Name: ')}}
		{{Form::text('first-name', '', array('class'=>'flat-text', 'size'=>'20'))}}
		{{Form::label('last-name', 'Last Name: ')}}
		{{Form::text('last-name', '', array('class'=>'flat-text', 'size'=>'20'))}}
	</div>
	<div class="form-line">
		{{Form::label('username', 'Organization Name')}}
		{{Form::text('username', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('email', 'E-mail Address: ')}}
		{{Form::email('email', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('password', 'Password: ')}}
		{{Form::password('password', '', array('class'=>'flat-text', 'size'=>'20'))}}
		{{Form::label('confirm', 'Confirm Password: ')}}
		{{Form::password('confirm', '', array('class'=>'flat-text', 'size'=>'20'))}}
	</div>

	<div class="form-line">
		{{Form::label('image', 'Logo: ')}}
		{{Form::file('image', array('class'=>'flat-file-input'))}}
	</div>
	<div class="form-line">
		{{Form::label('city', 'City: ')}}
		{{Form::text('city', '', array('class'=>'flat-text', 'size'=>'15'))}}
		{{Form::label('state', 'State: ')}}
		{{Form::text('state', '', array('class'=>'flat-text', 'size'=>'15'))}}
		{{Form::label('country', 'Country: ')}}
		{{Form::text('country', '', array('class'=>'flat-text', 'size'=>'15'))}}
	</div>
	<div class="form-line">
		{{Form::label('profile', 'Profile: ')}}
	</div>
	<div class="form-line">
		{{Form::textarea('profile', '', array('class'=>'flat-text-area'))}}
	</div>
	<div class="form-line">
		{{Form::submit('Create');}}
	</div>
{{ Form::close() }}
@stop
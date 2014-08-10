{{-- Create/Edit User --}}
@extends('layouts._master')

@section('banner')
<h1>Create New User</h1>
@stop

@section('content')
<div class="form-errors">
	@foreach($errors as $error)
		<p class="error-message">{{$error->message}}</p>
	@endforeach
</div>
{{Form::open(array('url'=>'/create-user', 'method'=>'POST', 'class'=>'fp-form'))}}
	<div class="form-line">
		{{Form::label('first-name', 'First Name: ')}}
		{{Form::text('first-name', '', array('class'=>'flat-text', 'size'=>'20'))}}
		{{Form::label('last-name', 'Last Name: ')}}
		{{Form::text('last-name', '', array('class'=>'flat-text', 'size'=>'20'))}}
	</div>
	<div class="form-line">
		{{Form::label('username', 'Username: ')}}
		{{Form::text('username', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('email', 'E-mail Address: ')}}
		{{Form::email('email', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('password', 'Password: ')}}
		{{Form::password('password', '', array('class'=>'flat-text', 'size'=>'20'))}}
		{{Form::label('password_confirmation', 'Confirm Password: ')}}
		{{Form::password('password_confirmation', '', array('class'=>'flat-text', 'size'=>'20'))}}
	</div>

	<div class="form-line">
		{{Form::label('image_url', 'Image URL: ')}}
		{{Form::text('image_url', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('website', "Website URL: ")}}
		{{Form::text('website', '', array('class'=>'flat-text', 'size'=>'50'))}}
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
		{{Form::submit('Create', array('class'=>'flat-button'));}}
	</div>
{{ Form::close() }}
@stop
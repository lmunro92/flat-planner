{{-- Create/Edit User --}}
@extends('layouts._master')

@section('banner')
<h1>Edit {{{$user['first_name']}}} {{{$user['last_name']}}}</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/user/'.$user['username'], 'method'=>'PUT', 'class'=>'fp-form'))}}
	<div class="form-line">
		{{Form::label('first-name', 'First Name: ')}}
		{{Form::text('first-name', $user['first_name'], array('class'=>'flat-text', 'size'=>'20'))}}
		{{Form::label('last-name', 'Last Name: ')}}
		{{Form::text('last-name', $user['last_name'], array('class'=>'flat-text', 'size'=>'20'))}}
	</div>
	<div class="form-line">
		{{Form::label('email', 'E-mail Address: ')}}
		{{Form::email('email', $user['email'], array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('image_url', 'Image URL: ')}}
		{{Form::text('image_url', $user['image_url'], array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
</div>
	<div class="form-line">
		{{Form::label('website', "Website URL: ")}}
		{{Form::text('website', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('city', 'City: ')}}
		{{Form::text('city', $user['city'], array('class'=>'flat-text', 'size'=>'15'))}}
		{{Form::label('state', 'State: ')}}
		{{Form::text('state', $user['state'], array('class'=>'flat-text', 'size'=>'15'))}}
		{{Form::label('country', 'Country: ')}}
		{{Form::text('country', $user['country'], array('class'=>'flat-text', 'size'=>'15'))}}
	</div>
	<div class="form-line">
		{{Form::label('profile', 'Profile: ')}}
	</div>
	<div class="form-line">
		{{Form::textarea('profile', $user['bio'], array('class'=>'flat-text-area'))}}
	</div>
	<div class="form-line">
		{{Form::submit('update');}}
	</div>
{{ Form::close() }}
@stop
{{-- Organization Creation Form --}}

@extends('layouts._master')

@section('banner')
	<h1>Create New Organization</h1>
@stop

@section('content')
<div class="form-errors">
	@foreach($errors as $error)
		<p class="error-message">{{$error->message}}</p>
	@endforeach
</div>
{{Form::open(array('url'=>'/create-organization/', 'method'=>'POST', 'class'=>'fp-form'));}}

	<div class="form-line">
		{{Form::label('organization-name', 'Organization Name: ');}}
		{{Form::text('organization-name', '', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('image_url', 'Logo URL: ');}}
		{{Form::text('image_url', '', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('website', "Website URL: ")}}
		{{Form::text('website', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('city', 'City: ');}}
		{{Form::text('city', '', array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('state', 'State: ')}}
		{{Form::text('state', '', array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('country', 'Country: ')}}
		{{Form::text('country', '', array('class'=>'flat-text', 'size'=>'15'));}}
	</div>
	<div class="form-line">
		{{Form::label('description', 'Description: ');}}
	</div>
	<div class="form-line">
		{{Form::textarea('description', '', array('class'=>'flat-text-area'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Create', array('class'=>'flat-button'));}}
	</div>
{{ Form::close() }}
@stop
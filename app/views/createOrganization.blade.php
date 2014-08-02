{{-- Organization Creation Form --}}

@extends('layouts._master')

@section('banner')
	<h1>Create New Organization</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/create-organization/', 'method'=>'POST', 'class'=>'fp-form'));}}

	<div class="form-line">
		{{Form::label('organization-name', 'Organization Name: ');}}
		{{Form::text('organization-name', 'My New Organization', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('image_url', 'Logo: ');}}
		{{Form::file('image_url', array('class'=>'flat-file-input', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('city', 'City: ');}}
		{{Form::text('city', 'Fort Myers', array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('state', 'State: ')}}
		{{Form::text('state', 'Florida', array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('country', 'Country: ')}}
		{{Form::text('country', 'United States', array('class'=>'flat-text', 'size'=>'15'));}}
	</div>
	<div class="form-line">
		{{Form::label('description', 'Description: ');}}
	</div>
	<div class="form-line">
		{{Form::textarea('description', 'Tell us all about your new group!', array('class'=>'flat-text-area'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Create');}}
	</div>
{{ Form::close() }}
@stop
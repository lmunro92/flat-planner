{{-- Organization Creation Form --}}
@extends('layouts._master')

@section('banner')
	<h1>Edit {{{$org->name}}}</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/'.$org->slug.'/edit', 'method'=>'PUT', 'class'=>'fp-form'));}}

	<div class="form-line">
		{{Form::label('organization-name', 'Organization Name: ');}}
		{{Form::text('organization-name', $org->name, array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('image_url', 'Logo URL: ');}}
		{{Form::text('image_url', $org->image_url, array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('website', "Website URL: ")}}
		{{Form::text('website', $org->website_url, array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('city', 'City: ');}}
		{{Form::text('city', $org->city, array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('state', 'State: ')}}
		{{Form::text('state', $org->state, array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('country', 'Country: ')}}
		{{Form::text('country', $org->country, array('class'=>'flat-text', 'size'=>'15'));}}
	</div>
	<div class="form-line">
		{{Form::label('description', 'Description: ');}}
	</div>
	<div class="form-line">
		{{Form::textarea('description', $org->description, array('class'=>'flat-text-area'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Update');}}
	</div>
{{ Form::close() }}
@stop
{{-- Organization Creation Form --}}
@extends('layouts._master')

@section('banner')
	<h1>Edit {{{$organization['name']}}}</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/'.$organization['slug'].'/edit', 'method'=>'PUT', 'class'=>'fp-form'));}}

	<div class="form-line">
		{{Form::label('organization-name', 'Organization Name: ');}}
		{{Form::text('organization-name', $organization['name'], array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('image_url', 'Logo URL: ');}}
		{{Form::text('image_url', $organization['image_url'], array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('website', "Website URL: ")}}
		{{Form::text('website', '', array('class'=>'flat-text', 'size'=>'50'))}}
	</div>
	<div class="form-line">
		{{Form::label('city', 'City: ');}}
		{{Form::text('city', $organization['city'], array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('state', 'State: ')}}
		{{Form::text('state', $organization['state'], array('class'=>'flat-text', 'size'=>'15'));}}
		{{Form::label('country', 'Country: ')}}
		{{Form::text('country', $organization['country'], array('class'=>'flat-text', 'size'=>'15'));}}
	</div>
	<div class="form-line">
		{{Form::label('description', 'Description: ');}}
	</div>
	<div class="form-line">
		{{Form::textarea('description', $organization['description'], array('class'=>'flat-text-area'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Update');}}
	</div>
{{ Form::close() }}
@stop
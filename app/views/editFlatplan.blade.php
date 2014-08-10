@extends('layouts._master')

@section('banner')
<h1>Edit {{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/edit', 'method'=>'PUT', 'class'=>'fp-form'));}}

	<div class="form-line">
		{{Form::label('name', 'Flatplan Name: ');}}
		{{Form::text('name', $flatplan->name, array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('publication_date', 'Publication Date: ');}}
		{{Form::text('publication_date', $flatplan->pub_date, array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Update', array('class'=>'flat-button'));}}
	</div>
{{ Form::close() }}
@stop
@extends('layouts._master')

@section('banner')
<h1>Create New Flatplan</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/create-flatplan/', 'method'=>'POST', 'class'=>'fp-form'));}}

	<div class="form-line">
		{{Form::label('flatplan-name', 'Flatplan Name: ');}}
		{{Form::text('flatplan-name', '', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('publication_date', 'Publication Date: ');}}
		{{Form::text('publication_date', '', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('pages', 'Number of Pages: ');}}
		{{Form::text('pages', '', array('class'=>'flat-number', 'size'=>'15'));}}
		{{Form::checkbox('covers', 0, array('class'=>'flat-check'));}}
		{{Form::label('covers', '+4 (Covers)');}}
	</div>
	<div class="form-line">
		{{Form::submit('Create');}}
	</div>
{{ Form::close() }}
@stop
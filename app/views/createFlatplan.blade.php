@extends('layouts._master')

@section('banner')
<h1>Create New Flatplan</h1>
@stop

@section('content')
{{Form::open(array('url'=>'/'.$org['slug'].'/create-flatplan', 'method'=>'POST', 'class'=>'fp-form'));}}

	<div class="form-line">
		{{Form::label('name', 'Flatplan Name: ');}}
		{{Form::text('name', '', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('publication_date', 'Publication Date: ');}}
		{{Form::text('publication_date', '', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::label('pages', 'Number of Pages: ');}}
		{{Form::text('pages', '', array('class'=>'flat-number', 'size'=>'15'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Create');}}
	</div>
{{ Form::close() }}
@stop
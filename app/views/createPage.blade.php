{{-- Create a New Page --}}

@extends('layouts._master')

@section('banner')
<h1>Create New page</h1>
@stop

@section('content')
<?php $colors = array('white'=>'White', 'whitesmoke'=>'Grey', 'blue'=>'Blue', 'red'=>'Red', 'blueviolet'=>'Violet'); ?>
{{Form::open(array('url'=>'/create-flatplan/', 'method'=>'POST', 'class'=>'fp-form'));}}
	<div class="form-line">
		{{Form::label('number', 'Page Number: ');}}
		{{Form::text('number', '', array('class'=>'flat-text'));}}
		{{Form::checkbox('spread', 0, array('class'=>'flat-check'));}}
		{{Form::Label('spread', 'Create as spread?');}}
	</div>
	<div class="form-line">
		{{Form::label('slug', 'Slug: ');}}
		{{Form::text('slug', '', array('class'=>'flat-text', 'size'=>'50'));}}
		{{Form::label('color', 'Color: ');}}
		{{Form::select('color', $colors, 'White', array('class'=>'flat-select'))}}
	</div>
	<div class="form-line">
		{{Form::label('notes', 'Notes: ');}}
	</div>
	<div class-"form-line">
		{{Form::textarea('notes', '', array('class'=>'flat-text-area'));}}
	</div>
	<div class="form-line">
		{{Form::label('image', 'Image: ');}}
		{{Form::file('image', array('class'=>'flat-file-input'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Create');}}
	</div>
{{ Form::close() }}
@stop
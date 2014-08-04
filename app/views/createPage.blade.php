{{-- Create a New Page --}}

@extends('layouts._master')

@section('banner')
<h1>Create new page in {{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<?php $colors = array('white'=>'White', 'whitesmoke'=>'Grey', 'blue'=>'Blue', 'red'=>'Red', 'blueviolet'=>'Violet'); ?>
{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/create-page', 'method'=>'POST', 'class'=>'fp-form'));}}
	<div class="form-line">
		{{Form::label('number', 'Page Number: ');}}
		{{Form::text('number', (count($flatplan->pages)-3), array('class'=>'flat-text'));}}
		{{Form::checkbox('spread', 'spread', false, array('class'=>'flat-check'));}}
		{{Form::Label('spread', 'Create accompanying spread page?');}}
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
		{{Form::text('image', '', array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::submit('Create');}}
	</div>
{{ Form::close() }}
@stop
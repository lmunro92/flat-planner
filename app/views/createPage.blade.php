{{-- Create a New Page --}}

@extends('layouts._master')

@section('banner')
<h1>Create new page in {{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<div class="form-errors">
	@foreach($errors as $error)
		<p class="error-message">{{$error}}</p>
	@endforeach
</div>
<?php $colors = array('white'=>'White', 'whitesmoke'=>'Grey', 'blue'=>'Blue', 'red'=>'Red', 'blueviolet'=>'Violet'); ?>
{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/create-page', 'method'=>'POST', 'class'=>'fp-form'));}}
	<div class="form-line">
		<p>Creating pages {{count($flatplan->pages)-3}} and {{count($flatplan->pages)-2}} as a spread</p>
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
		{{Form::submit('Create');}}
	</div>
{{ Form::close() }}
@stop
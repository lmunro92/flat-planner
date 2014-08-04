{{-- Edit a single Page --}}

@extends('layouts._master')

@section('banner')
<h1>Edit page {{{$page->page_number}}} in {{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<?php $colors = array('white'=>'White', 'whitesmoke'=>'Grey', 'blue'=>'Blue', 'red'=>'Red', 'blueviolet'=>'Violet'); ?>
{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/edit', 'method'=>'PUT', 'class'=>'fp-form'));}}
	<div class="form-line">
		{{Form::label('number', 'Page Number: ');}}
		{{Form::text('number', $page->page_number, array('class'=>'flat-text'));}}
		@if($pageOpp)
			{{Form::Label('spread', 'Shares a spread with:');}}
			{{Form::text('spread', $pageOpp->page_number, array('class'=>'flat-check', 'readonly'=>''));}}
		@endif
	</div>
	<div class="form-line">
		{{Form::label('slug', 'Slug: ');}}
		{{Form::text('slug', $page->slug, array('class'=>'flat-text', 'size'=>'50'));}}
		{{Form::label('color', 'Color: ');}}
		{{Form::select('color', $colors, $page->color, array('class'=>'flat-select'))}}
	</div>
	<div class="form-line">
		{{Form::label('notes', 'Notes: ');}}
	</div>
	<div class-"form-line">
		{{Form::textarea('notes', $page->notes, array('class'=>'flat-text-area'));}}
	</div>
	<div class="form-line">
		{{Form::label('image', 'Image url: ');}}
		{{Form::text('image', $page->image_url, array('class'=>'flat-text', 'size'=>'50'));}}
	</div>
	<div class="form-line">
		{{Form::checkbox('copy', 'copy', $page->copy, array('class'=>'flat-check'))}}
		{{Form::label('copy', 'Copy')}}
		{{Form::checkbox('art', 'art', $page->art, array('class'=>'flat-check'))}}
		{{Form::label('art', 'Art')}}
		{{Form::checkbox('design', 'design', $page->design, array('class'=>'flat-check'))}}
		{{Form::label('design', 'Design')}}
	</div>
	<div class="form-line">
		{{Form::checkbox('edit', 'edit', $page->edit, array('class'=>'flat-check'))}}
		{{Form::Label('edit', 'Edit')}}
		{{Form::checkbox('approve', 'approve', $page->approve, array('class'=>'flat-check'))}}
		{{Form::label('approve', 'Approve')}}
		{{Form::checkbox('proofread', 'proofread', $page->proofread, array('class'=>'flat-check'))}}
		{{Form::label('proofread', 'Proofread')}}
	</div>
	<div class="form-line">
		{{Form::checkbox('close', 'close', $page->close, array('class'=>'flat-check'))}}
		{{Form::label('close', 'Close')}}
	</div>
	<div class="form-line">
		{{Form::submit('update');}}
	</div>
{{ Form::close() }}
@stop
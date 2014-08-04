@extends('layouts._master')

@section('banner')
@if($pageOpp)
	<h1>Pages {{{$page->page_number}}}-{{{$pageOpp->page_number}}} of {{{count($flatplan->pages)}}} in {{{$flatplan->name}}} from {{{$org->name}}}</h1>
@else
	<h1>Page {{{$page->page_number}}} of {{{count($flatplan->pages)}}} in {{{$flatplan->name}}} from {{{$org->name}}}</h1>
@endif
@stop

@section('content')
	<div class="page-wrapper">
		<div class="pageOutline" style="background: {{$page->color}}; border: 2px solid black; width: 170px; padding: 90px 45px;">
		</div>
	<div class="pageNumber" style="text-align: center;">
		<p>{{{$page->number}}}</p>
	</div>
	@if($pageOpp)
	<div class="page-wrapper">
		<div class="pageOutline" style="border: 2px solid black; width: 170px; padding: 90px 45px;">
		</div>
	<div class="pageNumber" style="text-align: center;">
		<p>{{{$pageOpp->number}}}</p>
	</div>
	@endif
		<div class="slug" style="height: 20px;">
			<p style="font-size: 20px;">{{{$page->slug}}}</p>
		</div>
	</div>

<div class="status">
	<h3>Status</h3>
	{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/edit', 'method'=>'PUT', 'class'=>'fp-form'))}}
	<div class="status-line">
		{{Form::checkbox('copy', 'copy', $page->copy, array('class'=>'flat-check'))}}
		{{Form::label('copy', 'Copy')}}
		{{Form::checkbox('art', 'art', $page->art, array('class'=>'flat-check'))}}
		{{Form::label('art', 'Art')}}
		{{Form::checkbox('design', 'design', $page->design, array('class'=>'flat-check'))}}
		{{Form::label('design', 'Design')}}
	</div>
	<div class="status-line">
		{{Form::checkbox('edit', 'edit', $page->edit, array('class'=>'flat-check'))}}
		{{Form::Label('edit', 'Edit')}}
		{{Form::checkbox('approve', 'approve', $page->approve, array('class'=>'flat-check'))}}
		{{Form::label('approve', 'Approve')}}
		{{Form::checkbox('proofread', 'proofread', $page->proofread, array('class'=>'flat-check'))}}
		{{Form::label('proofread', 'Proofread')}}
	</div>
	<div class="status-line">
		{{Form::checkbox('close', 'close', $page->close, array('class'=>'flat-check'))}}
		{{Form::label('close', 'Close')}}
	</div>
	<div class="status-line">
		{{Form::submit('Update')}}
	</div>
	{{Form::close()}}
</div>

<div class="assignment">
	<h3>Assignments</h3>
		@foreach ($assignments as $assignment)
			<p>{{{$assignment->deadline}}}: {{{$assignment->user->username}}}<p>
		@endforeach
</div>

<div class="assignment">
	<h3>Create New Assignment</h3>
	{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/create-assignment', 'method'=>'POST'))}}
		<div class="assignment-line">
			{{Form::label('user', 'Select User: ')}}
			{{Form::select('user', $members, '', array('class'=>'flat-select'))}}
			{{Form::label('deadline', 'Deadline: ')}}
			{{Form::text('deadline', '', array('class'=>'flat-text'))}}
		</div>
		<div class="assignment-line">
			{{Form::label('description', 'Description: ')}}
		</div>
		<div class="assignment-line">
			{{Form::textarea('description', '', array('class'=>'flat-text-area'))}}
		</div>
		<div class="assignemnt-line">
			{{Form::submit('Assign')}}
		</div>	
	{{Form::close()}}
</div>


<div class="notes">
	<h3>Notes</h3>
	<p>{{{$page->notes}}}</p>
</div>

@stop
@extends('layouts._master')

@section('banner')
	<h1>Page {{{$page->page_number}}} of {{{count($flatplan->pages)}}} in "{{{$flatplan->name}}}" from {{{$org->name}}}</h1>
@stop

@section('content')
<div class="nav-tree">
	<span class="tree-text">/ <a href="/{{{$org->slug}}}">{{{$org->name}}}</a> / <a href="/{{{$org->slug}}}/{{{$flatplan->slug}}}">{{{$flatplan->name}}}</a> / {{{$page->page_number}}}</span>
</div>
<div class="page-wrapper">
	<div class="pageOutline" style="background:{{$page->color}}; border: 2px solid black; width: 170px; padding: 90px 45px;">
	</div>
	<div class="page-info">
		<p>{{{$page->page_number}}}</p>
		<p>{{{$page->slug}}}</p>
		<p><a href="/{{{$org->slug}}}/{{{$flatplan->slug}}}/{{{$page->page_number}}}/edit">Edit Page</a></p>
	</div>

	<div class="page-notes">
		<h3>Notes</h3>
		<p>{{{$page->notes}}}</p>
	</div>

	<div class="page-status">
		<h3>Status</h3>
		{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/edit', 'method'=>'PUT', 'class'=>'fp-form'))}}
		<div class="page-status-line">
			{{Form::checkbox('copy', true, $page->copy, array('class'=>'flat-check', $readonly=>''))}}
			{{Form::label('copy', 'Copy')}}
			{{Form::checkbox('art', true, $page->art, array('class'=>'flat-check', $readonly=>''))}}
			{{Form::label('art', 'Art')}}
			{{Form::checkbox('design', true, $page->design, array('class'=>'flat-check', $readonly=>''))}}
			{{Form::label('design', 'Design')}}
		</div>
		<div class="page-status-line">
			{{Form::checkbox('edit', true, $page->edit, array('class'=>'flat-check', $readonly=>''))}}
			{{Form::Label('edit', 'Edit')}}
			{{Form::checkbox('approve', true, $page->approve, array('class'=>'flat-check', $readonly=>''))}}
			{{Form::label('approve', 'Approve')}}
			{{Form::checkbox('proofread', true, $page->proofread, array('class'=>'flat-check', $readonly=>''))}}
			{{Form::label('proofread', 'Proofread')}}
		</div>
		<div class="page-status-line">
			{{Form::checkbox('close', true, $page->close, array('class'=>'flat-check', $readonly=>''))}}
			{{Form::label('close', 'Close')}}
		</div>
		@if($permission == 'edit')
		<div class="page-status-line">
			{{Form::submit('Update')}}
		</div>
		@endif
		{{Form::close()}}
	</div>
</div>


<div class="page-assignments">
	<h3>Assignments</h3>
	<div class="list-headers">
		<div class="list-col1">
			<p>Deadline</p>
		</div>
		<div class="list-col">
			<p>Username</p>
		</div>
		<div class="list-col-notes">
			<p>Description</p>
		</div>
	</div>
	@if($assignments)
		@foreach ($assignments as $assignment)
		<div class="list-line">
			<div class="list-col1">
				<p>{{{$assignment->deadline}}}</p>
			</div>
			<div class-"list-col">
				<p>{{{$assignment->user->username}}}</p>
			</div>
			<div class="list-col">
				<p>{{{$assignment->description}}}</p>
			</div>
		@endforeach
	@endif
</div>

@if($permission == 'edit')
	<div class="page-create-assignments">
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
@endif
@stop
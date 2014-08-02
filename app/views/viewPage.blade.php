@extends('layouts._master')

@section('banner')
<h1>Viewing page __  of __</h1>
@stop

@section('content')
	<div class="page-wrapper">
	<div class="pageOutline" style="border: 2px solid black; width: 170px; padding: 90px 45px;">

	</div>
	<div class="pageNumber" style="text-align: center;">
		<p>42</p>
	</div>
		<div class="slug" style="height: 20px;">
			<p style="font-size: 20px;">Testing Slug</p>
		</div>
</div>

<div class="status">
	<h3>Status</h3>
	{{Form::open(array('url'=>'/update-page/','method'=>'POST'))}}
	<div class="status-line">
		{{Form::checkbox('copy', 0, array('class'=>'flat-check'))}}
		{{Form::label('copy', 'Copy')}}
		{{Form::checkbox('art', 0, array('class'=>'flat-check'))}}
		{{Form::label('art', 'Art')}}
		{{Form::checkbox('design', 0, array('class'=>'flat-check'))}}
		{{Form::label('design', 0, 'Design')}}
	</div>
	<div class="status-line">
		{{Form::checkbox('edit', 0, array('class'=>'flat-check'))}}
		{{Form::Label('edit', 'Edit')}}
		{{Form::checkbox('approve', 0, array('class'=>'flat-check'))}}
		{{Form::label('approve', 'Approve')}}
		{{Form::checkbox('proofread', 0, array('class'=>'flat-check'))}}
		{{Form::label('proofread', 'Proofread')}}
	</div>
	<div class="status-line">
		{{Form::checkbox('closed', 0, array('class'=>'flat-check'))}}
		{{Form::label('closed', 'Closed')}}
	</div>
	<div class="status-line">
		{{Form::submit('Update')}}
	</div>
	{{Form::close()}}
</div>

<div class="assignment">
	<h3>Assignments</h3>
	<p>Here's a list of assignments</p>
	<p>Here's another assignemnt</p>
</div>

<div class="assignment">
	<h3>Create New Assignment</h3>
	{{Form::open(array('url'=>'update-page', 'method'=>'POST'))}}
		<div class="assignment-line">
			{{Form::label('user', 'Select User: ')}}
			{{Form::select('user', array('dummy'=>'dummy'), 'dummy', array('class'=>'flat-select'))}}
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
	<p>These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page. These are the notes about the page.</p>
</div>


@stop
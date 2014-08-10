@extends('layouts._master')

@section('banner')
	<h1>Editing {{$assignment->user->username}}'s assignment</h1>
@stop
@section('content')
	{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/assignment/'.$assignment->id, 'method'=>'PUT'))}}
		<div class="form-line">
			{{Form::label('deadline', 'Deadline: ')}}
			{{Form::text('deadline', $assignment->deadline, array('class'=>'flat-text'))}}
			{{Form::checkbox('completed', 'completed', $assignment->completed, array('class'=>'flat-check'))}}
			{{Form::label('completed', 'Completed')}}
		</div>
		<div class="form-line">
			{{Form::label('description', 'Description: ')}}
		</div>
		<div class="form-line">
			{{Form::textarea('description', $assignment->description, array('class'=>'flat-text-area'))}}
		</div>
		<div class="assignemnt-line">
			{{Form::submit('Update', array('class'=>'flat-button'))}}
		</div>	
	{{Form::close()}}
@stop

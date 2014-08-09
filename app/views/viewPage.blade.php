@extends('layouts._master')

@section('banner')
	<h1>Page {{{$page->page_number}}} in "{{{$flatplan->name}}}"</h1>
@stop

@section('content')
<div class="back">
	<span class="back-text">:: <a href="/{{{$org->slug}}}/{{{$flatplan->slug}}}/">Back</a> ::</span>
</div>
<div class="page-block">
	<div class="page-wrapper">
		<div class="page-outline" style="background:{{$page->color}};">
		</div>
		<div class="page-info">
			<p>{{{$page->page_number}}}</p>
			<p>{{{$page->slug}}}</p>
			@if($permission == 'edit')
				<p><a href="/{{{$org->slug}}}/{{{$flatplan->slug}}}/{{{$page->page_number}}}/edit">Edit Page</a></p>
			@endif
		</div>
	</div>
	<div class="page-notes">
		<h3>Notes</h3>
		<p>{{{$page->notes}}}</p>
	</div>
</div>
<div class="page-block">
	<div class="page-status">
		<h3>Status</h3>
		{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/edit', 'method'=>'PUT', 'class'=>'fp-form'))}}
		<div class="page-status-line">
			<div class="page-status-line-item">
				{{Form::checkbox('copy', true, $page->copy, array('class'=>'flat-check', $readonly=>''))}}
				{{Form::label('copy', 'Copy')}}
			</div>
			<div class="page-status-line-item">
				{{Form::checkbox('art', true, $page->art, array('class'=>'flat-check', $readonly=>''))}}
				{{Form::label('art', 'Art')}}
			</div>
			<div class="page-status-line-item">
				{{Form::checkbox('design', true, $page->design, array('class'=>'flat-check', $readonly=>''))}}
				{{Form::label('design', 'Design')}}
			</div>
		</div>
		<div class="page-status-line">
			<div class="page-status-line-item">
				{{Form::checkbox('edit', true, $page->edit, array('class'=>'flat-check', $readonly=>''))}}
				{{Form::Label('edit', 'Edit')}}
			</div>
			<div class="page-status-line-item">
				{{Form::checkbox('approve', true, $page->approve, array('class'=>'flat-check', $readonly=>''))}}
				{{Form::label('approve', 'Approve')}}
			</div>
			<div class="page-status-line-item">
				{{Form::checkbox('proofread', true, $page->proofread, array('class'=>'flat-check', $readonly=>''))}}
				{{Form::label('proofread', 'Proofread')}}
			</div>
		</div>
		<div class="page-status-line">
			<div class="page-status-line-close">
				{{Form::checkbox('close', true, $page->close, array('class'=>'flat-check', $readonly=>''))}}
				{{Form::label('close', 'Close')}}
			</div>
		</div>
		@if($permission == 'edit')
		<div class="page-status-line">
			<div class="page-status-line-close">
				{{Form::submit('Update', array('class'=>'flat-button'))}}
			</div>
		</div>
		@endif
		{{Form::close()}}
	</div>


	<div class="page-assignments">
		<h3>Assignments</h3>
		<div class="list-header">
			<div class="list-col-delete">
			</div>						
			<div class="list-col">
				<h4>Deadline</h4>
			</div>
			<div class="list-col">
				<h4>Username</h4>
			</div>
			<div class="list-col-notes">
				<h4>Description</h4>
			</div>
		</div>
		@if($assignments)
			@foreach ($assignments as $assignment)
				<div class="list-line">
					<div class="list-col-delete">
						@if($permission == 'edit')
							<p class="delete-x"><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}/assignment/{{$assignment->id}}/delete">X</a></p>
						@endif
					</div>					
					<div class="list-col">
						<p>{{{$assignment->deadline}}}</p>
					</div>
					<div class="list-col">
						<p><a href="/user/{{{$assignment->user->username}}}">{{{$assignment->user->username}}}</a></p>
					</div>
					<div class="list-col-notes">
						<p><em>{{{$assignment->description}}}</em></p>
					</div>
				</div>
			@endforeach
		@endif
		@if($permission == 'edit')
			{{Form::open(array('url'=>'/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/create-assignment', 'method'=>'POST'))}}
				<div class="list-line">
					<div class="list-col">
						<p>{{Form::text('deadline', '', array('class'=>'flat-text', 'size'=>'15'))}}</p>
					</div>
					<div class="list-col">
						<p>{{Form::select('user', $members, '', array('class'=>'flat-select'))}}</p>
					</div>
					<div class="list-col-notes">
						<p>{{Form::text('description', '', array('class'=>'flat-text', 'size'=>'40'))}}</p>
					</div>
				</div>
				<div class="list-line-last">
					<div class="assignment-line-button">
						<p>{{Form::submit('Assign', array('class'=>'flat-button'
						))}}</p>
					</div>	
				{{Form::close()}}
			</div>
	@endif
	</div>


</div>
<div class="page-block">
	

</div>
@stop
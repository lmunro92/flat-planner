{{-- View a single organization --}}

@extends('layouts._master')

@section('banner')
	<h1>{{{$org->name}}}</h1>
@stop

{{--show the logo and vital info of the org in the top-left corner --}}
@section('content')
<div class="nav-tree">
	<span class="tree-text">/ {{{$org->name}}}</a> /</span>
</div>
<div class="nameplate">
	<div class="nameplate-image">
		<img src="{{{$org->image_url}}}" alt="{{{$org->name}}}" />
	</div>
	<div class="nameplate-name">
		<h2>{{{$org->name}}}</h2>
	</div> 
	<div class="nameplate-vitals">
		<p>{{{$org->city}}}, {{{$org->state}}}, {{{$org->country}}}</p>
		<p>{{{$org->description}}}</p>
	</div>
	@if($permission == 'edit')
	<div class="nameplate-edit">
		<p><a href="/{{{$org->slug}}}/edit">Edit Organization</a></p>
	</div>
	@endif
</div>

{{-- List all members of the organization in top-right --}}
<div class="organization-members">
	<h3>Members</h3>
	<div class="list-header">
		<div class="list-col1">
			<h4>Name</h4>
		</div>
		<div class="list-col">
			<h4>Title</h4>
		</div>
		@if($permission == 'edit' || $permission == 'view')
		<div class="list-col">
			<h4>Permission</h4>
		</div>
		@endif
	</div>
	@foreach($roles as $role)
	<div class="list-line">
		<div class="list-col1">
			<p><a href="/user/{{{$role->user->username}}}">{{$role->user->username}}</a></p> 
		</div>
		<div class="list-col">
			<p>{{$role->title}}</p>
		</div>
		@if($permission == 'edit' || $permission == 'view')
		<div class="list-col">
			<p>can {{$role->permissions}}</p>
		</div>
		@endif
	</div>
	@endforeach
	@if($permission == 'edit')
	<h3>Add Existing Users</h3>
	{{Form::open(array('url'=>'/'.$org->slug.'/add-member/', 'method'=>'POST', 'class'=>'fp-form'))}}
		<div class="add-member-line">
			{{Form::label('username', 'Username or e-mail Address: ')}}
			{{Form::text('username', '', array('class'=>'flat-text', 'size'=>'30'))}} 
		</div>
		<div class="add-member-line">
			{{Form::label('title', 'Title: ')}}
			{{Form::text('title', '', array('class'=>'flat-text', 'size'=>'30'))}} 
		</div>
		<div class="add-member-line">
			{{Form::label('permissions', 'Permissions: ')}}
			{{Form::radio('permissions', 'view', true, array('class'=>'flat-radio'))}}
			View
			{{Form::radio('permissions', 'edit', false, array('class'=>'flat-radio'))}}
			Edit
		</div>
		<div class="add-member-line">
			{{Form::submit('Add User')}}
		</div>
	{{Form::close()}}
	@endif
</div>

@if($permission == 'edit' || $permission == 'view')

{{-- Listing of all Flatplans in bottom left --}}
<div class="organization-flatplans">
	<h3>All Flatplans</h3>
	<div class="list-header">
		<div class="list-col1">
			<h4>flatplan</h4>
		</div>
		<div class="list-col">
			<h4>Publication Date</h4>
		</div>
	</div>
	@foreach($flatplans as $flatplan)
		<div class="list-line">
			<div class="list-col1">
				<p><a href="/{{{$org->slug}}}/{{{$flatplan->slug}}}/">{{{$flatplan->name}}}</a>
			</div>
			<div class="list-col">
				<p>{{{$flatplan->pub_date}}}</p>
			</div>
		</div>
	@endforeach
	@if($permission == 'edit')
	<div class="add-line">
		<p><a href="/{{{$org->slug}}}/create-flatplan">Create New Flatplan</a></p>
	</div>
	@endif
</div>

{{-- Listing of all outstanding assignment in bottom right --}}
<div class="organization-assignments">
	<h3>Outstanding Assignments</h3>
	<div class="list-header">
		<div class="list-col1">
			<h4>User</h4>
		</div>
		<div class="list-col">
			<h4>Flatplan</h4>
		</div>
		<div class="list-col-page">
			<h4>Page</h4>
		</div>
		<div class="list-col">
			<h4>Deadline</h4>
		</div>
	</div>
	@if($flatplans)
	@foreach($flatplans as $flatplan)
		@if($flatplan->pages)
		@foreach($flatplan->pages as $page)
			@if($page->assignments)
			@foreach($page->assignments as $assignment)
					<div class="list-line">
						<div class="list-col1">
							<p><a href="/user/{{{$assignment->user->username}}}">{{{$assignment->user->username}}}</a></p>
						</div>
						<div class="list-col">
							<p><a href="/{{{$org->slug}}}/{{{$flatplan->slug}}}">{{{$flatplan->name}}}</a></p>
						</div>
						<div class="list-col-page">
							<p><a href="/{{{$org->slug}}}/{{{$flatplan->slug}}}/{{{$page->page_number}}}">{{{$page->page_number}}}</a></p>
						</div>
						<div class="list-col">
							<p>{{{$assignment->deadline}}}</p>
						</div>
					</div>
			@endforeach
			@endif
		@endforeach
		@endif
	@endforeach
	@endif
</div>
@endif
@stop
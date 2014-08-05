{{-- View a single organization --}}

@extends('layouts._master')

@section('banner')
	<h1>{{{$organization['name']}}}</h1>
@stop

{{--show the logo and vital info of the org in the top-left corner --}}
@section('content')
<div class="nameplate">
	<div class="nameplate-image">
		<img src="{{{$organization['image_url']}}}" alt="{{{$organization['name']}}}" />
	</div>
	<div class="nameplate-name">
		<p>{{{$organization['name']}}}<p>
	</div> 
	<div class="nameplate-vitals">
		<p>{{{$organization['city']}}}, {{{$organization['state']}}}, {{{$organization['country']}}}</p>
		<p>{{{$organization['description']}}}</p>
	</div>
	<div class="nameplate-edit">
		<p><a href="/{{$organization['slug']}}/edit">Edit Organization</a></p>
	</div>
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
		<div class="list-col">
			<h4>Permission</h4>
		</div>
	</div>
	@foreach($roles as $role)
	<div class="list-line">
		<div class="list-col1">
			<p><a href="/user/{{$role->user->username}}">{{$role->user->username}}</a></p> 
		</div>
		<div class="list-col">
			<p>{{$role->title}}</p>
		</div>
		<div class="list-col">
			<p>can {{$role->permissions}}</p>
		</div>
	</div>
	@endforeach
	<h3>Add New</h3>
	<p>Add existing users to your organization</p>
	{{Form::open(array('url'=>'/'.$organization['slug'].'/add-member/', 'method'=>'POST', 'class'=>'fp-form'))}}
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
</div>

{{-- Listing of all Flatplans in bottom left --}}
<div class="organization-flatplans">
	<h3>All Flatplans</h3>
	<div class="list-headers">
		<div class="list-col1">
			<h4>flatplan</h4>
		</div>
		<div class="list-col">
			<h4>Deadline</h4>
		</div>
	</div>
</div>


{{-- Listing of all outstanding assignment in bottom right --}}
<div class="organization-assignments">
	<h3>Outstanding Assignment</h3>
	<div class="list-headers">
		<div class="list-col1">
			<h4>User</h4>
		</div>
		<div class="list-col1">
			<h4>Flatplan</h4>
		</div>
		<div class="list-col1">
			<h4>Page</h4>
		</div>
		<div class="list-col">
			<h4>Deadline</h4>
		</div>
	</div>
</div>

@stop
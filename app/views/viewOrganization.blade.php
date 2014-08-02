{{-- View a single organization --}}

@extends('layouts._master')

@section('banner')
	<h1>_______________ Organization</h1>
@stop

{{--show the logo and vital info of the org in the top-left corner --}}
@section('content')
<div class="nameplate">
	<div class="nameplate-image">
		<img src="" alt="Flat-Planner" />
	</div>
	<div class="nameplate-name">
		<p>Flat-Planner<p>
	</div> 
	<div class="nameplate-vitals">
		<p>Somerville, Massachusetts USA</p>
		<p>A collaborative editorial planning app</p>
	</div>
</div>

{{-- List all members of the organization in top-right --}}
<div class="organization-members">
	<h3>Members</h3>
	<div class="list-header">
		<div class="list-col1">
			<h4>Name</h4>
		</div>
		<div class="list-col2">
			<h4>Title</h4>
		</div>
	</div>
	<div class="list-line">
		<div class="list-line">
			<p>Jonathan Seitz</p>
		</div>
		<div class="list-line">
			<p>Founder</p>
		</div>
	</div>
	<h3>Add New</h3>
	<p>Add existing users to your organization</p>
	{{Form::open(array('url'=>'/view-organization/', 'method'=>'POST', 'class'=>'fp-form'))}}
		<div class="add-member-line">
			{{Form::label('username', 'Username or e-mail Address: ')}}
			{{Form::text('username', '', array('class'=>'flat-text', 'size'=>'30'))}} 
		</div>
		<div class="add-member-line">
			{{Form::label('title', 'Title: ')}}
			{{Form::text('title', '', array('class'=>'flat-text', 'size'=>'30'))}} 
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
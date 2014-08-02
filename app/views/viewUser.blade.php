{{-- View a single user --}}

@extends('layouts._master')

@section('banner')
	<h1>_______________ User</h1>
@stop

{{--show the logo and vital info of the org in the top-left corner --}}
@section('content')
<div class="nameplate">
	<div class="nameplate-image">
		<img src="" alt="Jonathan Seitz" />
	</div>
	<div class="nameplate-name">
		<p>Jonathan Seitz<p>
	</div>
	<div class="nameplate-vitals">
		<p>Somerville, Massachusetts USA</p>
		<p>Writer, editor, etc.</p>
	</div>
</div>

{{-- List all organizations in top-right --}}
<div class="user-organization">
	<h3>Organizations</h3>
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
			<p>Flat-Planner</p>
		</div>
		<div class="list-line">
			<p>Founder</p>
		</div>
	</div>
</div>

{{-- Listing of all outstanding assignment on bottom --}}
<div class="user-assignments"</div>
	<h3>Outstanding Assignment</h3>
	<div class="list-headers">
		<div class="list-col1">
			<h4>Organization</h4>
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
		<div class="list-col">
			<h4>Notes</h4>
		</div>
	</div>
</div>

@stop
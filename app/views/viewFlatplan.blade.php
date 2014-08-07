@extends('layouts._master')

@section('banner')
<h1>{{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<div class="nav-tree">
	<span class="tree-text">/ <a href="/{{{$org->slug}}}">{{{$org->name}}}</a> / {{{$flatplan->name}}}</a></span>
</div>
<div class="flatplan-info">
	<div class="flatplan-name">
		<h2>{{{$flatplan->name}}}</h2>
		@if($permission == 'edit')
			<p><a href="/{{$org['slug']}}/{{$flatplan['slug']}}/edit">Edit</a></p>
		@endif
	</div>
	<div class="flatplan-page-count">
		<p>{{count($pages)}} pages</p>
		@if($permission == 'edit')
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/create-page">Add Pages</a><p>
		@endif
	</div>
	<div class="flatplan-pub-date">
		<p>Pub Date: {{$flatplan->pub_date}}</p>
	</div>
</div>

<div class="flatplan-graphics">


	<div class="flatplan-cover">
		<div class="flatplan-page">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/COVER">{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->slug;}}</a></p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/COVER">{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->page_number;}}</a></p>
			</div>
		</div>
	</div>


	<div class="flatplan-inside-cover">
		<div class="flatplan-page">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IFC">{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->slug;}}</a></p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IFC">{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->page_number;}}</a></p>
			</div>
		</div>
	</div>


	@foreach($pages as $page)	
		<div class="flatplan-spread">
			<div class="flatplan-page">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}">{{{$page->slug}}}</a></p>
			</div>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}">{{{$page->page_number}}}</a></p>
			</div>
		</div>
	@endforeach


	<div class="flatplan-inside-back">
		<div class="flatplan-page">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IBC">{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->slug;}}</a></p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IBC">{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->page_number;}}</a></p>
			</div>
		</div>
	</div>


	<div class="flatplan-back">
		<div class="flatplan-page">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/BACK">{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->slug;}}</a></p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/BACK">{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->page_number;}}</a></p>
			</div>
		</div>		
	</div>
</div>


@stop
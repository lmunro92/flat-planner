@extends('layouts._master')

@section('banner')
<h1>{{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<div class="nav-tree">
	<span class="tree-text">/ <a href="/{{{$org->slug}}}">{{{$org->name}}}</a> / {{{$flatplan->name}}}</a></span>
</div>
<div class="flatplan-info">
	<div class="flatplan-info-block">
		<h2>{{{$flatplan->name}}}</h2>
	</div>
	<div class="flatplan-info-block">
		<h4>Pub Date: {{$flatplan->pub_date}}</h4>
	</div>
	<div class="flatplan-info-block">
		<h4>{{count($pages)}} pages</h4>
	</div>
		@if($permission == 'edit')
		<div class="flatplan-info-block">
			<h4><a href="/{{$org['slug']}}/{{$flatplan['slug']}}/edit">Edit Flatplan</a> | <a href="/{{$org->slug}}/{{$flatplan->slug}}/create-page">Add Pages</a> </h4>
		</div>
		@endif


</div>

<div class="flatplan-graphics">
	<div class="flatplan-page-wrap">
		<div class="flatplan-cover">
		</div>
		<div class="flatplan-page-number">
			<div class="page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/COVER">{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->page_number;}}</a></p>
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/COVER">{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->slug;}}</a>&nbsp;</p>
			</div>
		</div>
	</div>

	<div class="flatplan-page-spacer">
	</div>

	<div class="flatplan-page-wrap">
		<div class="flatplan-page">
		</div>
		<div class="flatplan-page-number">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IFC">{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->page_number;}}</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IFC">{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->slug;}}</a>&nbsp;</p>
		</div>
	</div>



	@foreach($pages as $page)	
		<div class="flatplan-page-wrap">
			<div class="flatplan-page">
			</div>
			<div class="flatplan-page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}">{{{$page->page_number}}}</a></p>
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}">{{{$page->slug}}}</a>&nbsp;</p>
			</div>
		</div>
		@if($page->page_number % 2 != 0)
			<div class="flatplan-page-spacer"></div>
		@endif
	@endforeach


	<div class="flatplan-page-wrap">
		<div class="flatplan-page">
		</div>
		<div class="flatplan-page-number">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IBC">{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->page_number;}}</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IBC">{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->slug;}}</a>&nbsp;</p>
		</div>
	</div>

	<div class="flatplan-page-spacer">
	</div>

	<div class="flatplan-page-wrap">
		<div class="flatplan-back">
		</div>
		<div class="flatplan-page-number">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/BACK">{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->page_number;}}</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/BACK">{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->slug;}}</a>&nbsp;</p>
		</div>
		
	</div>
</div>

@stop
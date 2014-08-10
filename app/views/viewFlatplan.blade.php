@extends('layouts._master')

@section('banner')
<h1>{{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<div class="back">
	<span class="back-text">:: <a href="/{{{$org->slug}}}/">Back</a> ::</span>
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
	<div class="flatplan-invisible-page">
	</div>
	<div class="flatplan-page-wrap">
		<div class="flatplan-cover" style="background:{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->color;}}">
		</div>
		<div class="flatplan-page-number">
			<div class="page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/COVER">{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->page_number;}}</a></p>
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/COVER">{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->slug;}}&nbsp;</a></p>
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/COVER/edit">EDIT</a></p>
			</div>
		</div>
	</div>

	<div class="flatplan-page-spacer">
	</div>

	<div class="flatplan-page-wrap">
		<div class="flatplan-page" style="background:{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->color;}}">
		</div>
		<div class="flatplan-page-number">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IFC">{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->page_number;}}</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IFC">{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->slug;}}</a>&nbsp;</p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IFC/edit">EDIT</a></p>
		</div>
	</div>



	@foreach($pages as $page)	
		<div class="flatplan-page-wrap">
			<div class="flatplan-page" style="background:{{$page->color}}">
			</div>
			<div class="flatplan-page-number">
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}" class="page-link">{{{$page->page_number}}}</a></p>
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}" class="page-link">{{{$page->slug}}}&nbsp;</a></p>
				<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}/edit">EDIT</a> | <a href="/{{$org->slug}}/{{$flatplan->slug}}/{{$page->page_number}}/delete" class="page-delete">DELETE</a>
			</div>
		</div>
		@if($page->page_number % 2 != 0)
			<div class="flatplan-page-spacer"></div>
		@endif
	@endforeach


	<div class="flatplan-page-wrap">
		<div class="flatplan-page" style="background:{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->color;}}">
		</div>
		<div class="flatplan-page-number">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IBC">{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->page_number;}}</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IBC">{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->slug;}}&nbsp;</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/IBC/edit">EDIT</a></p>
		</div>
	</div>

	<div class="flatplan-page-spacer">
	</div>

	<div class="flatplan-page-wrap">
		<div class="flatplan-back" style="background:{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->color;}}">
		</div>
		<div class="flatplan-page-number">
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/BACK">{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->page_number;}}</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/BACK">{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->slug;}}&nbsp;</a></p>
			<p><a href="/{{$org->slug}}/{{$flatplan->slug}}/back/edit">EDIT</a></p>
		</div>
		
	</div>
	<div class="flatplan-invisible-page">
	</div>
</div>

@stop
@extends('layouts._master')

@section('banner')
<h1>{{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<div class="flatplan-info">
	<div class="flatplan-name">
		<h2>{{{$flatplan->name}}}</h2>
		<p><a href="/{{$org['slug']}}/{{$flatplan['slug']}}/edit">Edit</a></p>
	</div>
	<div class="flatplan-page-count">
		<p>{{count($pages)}} pages</p>
	</div>
	<div class="flatplan-pub-date">
		<p>Pub Date: {{$flatplan->pub_date}}</p>
	</div>
</div>

<div class="flatplan-graphics">


	<div class="flatplan-cover">
		<div class="flatplan-page">
			<p>{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->slug;}}</p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p>{{$covers->filter(function($page){return $page->page_number == 'COVER';})->first()->page_number;}}</p>
			</div>
		</div>
	</div>


	<div class="flatplan-inside-cover">
		<div class="flatplan-page">
			<p>{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->slug;}}</p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p>{{$covers->filter(function($page){return $page->page_number == 'IFC';})->first()->page_number;}}</p>
			</div>
		</div>
	</div>


	@foreach($pages as $page)	
		<div class="flatplan-spread">
			<div class="flatplan-page">
				<p>{{{$page->slug}}}</p>
			</div>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p>{{{$page->page_number}}}</p>
			</div>
		</div>
	@endforeach


	<div class="flatplan-inside-back">
		<div class="flatplan-page">
			<p>{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->slug;}}</p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p>{{$covers->filter(function($page){return $page->page_number == 'IBC';})->first()->page_number;}}</p>
			</div>
		</div>
	</div>


	<div class="flatplan-back">
		<div class="flatplan-page">
			<p>{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->slug;}}</p>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p>{{$covers->filter(function($page){return $page->page_number == 'BACK';})->first()->page_number;}}</p>
			</div>
		</div>		
	</div>
</div>


@stop
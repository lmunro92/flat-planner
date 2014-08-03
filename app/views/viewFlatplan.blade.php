@extends('layouts._master')

@section('banner')
<h1>{{{$flatplan->name}}} from {{{$org->name}}}</h1>
@stop

@section('content')
<div class="flatplan-info">
	<div class="flatplan-name">
		<h2>{{{$flatplan->name}}}</h2>
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
	</div>
	<div class="flatplan-inside-cover">
	</div>
	@for($i = 2; $i < count($pages); $i += 2)
		<?php $page = Page::where('page_number', '=', $i)->first(); ?>
		<?php $pageOpp = Page::where('id','=', $page->spread_page_id)->first(); ?>
		<?php dd($pageOpp); ?>
		<div class="flatplan-spread">
			<div class="flatplan-page">
				<p>{{{$page->slug}}}</p>
			</div>
			<div class="flatplan-page">
				<p>{{{$pageOpp->slug}}}</p>
			</div>
		</div>
		<div class="page-numbers">
			<div class="page-number">
				<p>{{{$page->page_number}}}</p>
			</div>
			<div class="page-number">
				<p>{{{$pageOpp->page_number}}}</p>
			</div>
		</div>
	@endfor
	<div class="flatplan-inside-back">
	</div>
	<div class="flatplan-back">
	</div>
</div>


@stop
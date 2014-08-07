<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"></meta>
	<link rel="stylesheet" type="text/css" href="/styles/style.css" /> 
	<script type="text/javascript" src="//use.typekit.net/dnc5tpl.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	<?php $fplogo = '/assets/image/logo.svg'; ?>
	@yield('head')
	<title>
		@yield('title', 'Flat-Planner')
	</title>
</head>
<body>
	<header>
		@include('layouts._header')
	</header>
	<article>
		<div class="wrapper">
			@yield('content')
		</div>
	</article>
	<footer>
		@include('layouts._footer')
	</footer>
	@yield('body')
</body>
</html>
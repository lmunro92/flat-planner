<div class="logo-box">
	<img src="{{ $fplogo }}" alt="Flat-Planner" class="fplogo" />
</div>

<div class="banner">
@yield('banner')
</div>

<div class="flash">
	@if(Session::get('flash_message'))
		{{Session::get('flash_message')}}
	@endif
<div class="flash">

<div class="credentials">
	@if(Auth::check())
		<a href="/user/{{Auth::user()->username}}">{{{Auth::user()->username}}}</a> | </a><a href="/logout">log out</a>
	@else
		<a href="/login">Log in</a> | <a href="/signup">sign up</a>
	@endif
</div>
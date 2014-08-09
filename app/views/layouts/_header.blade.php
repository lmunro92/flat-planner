<div class="header-line">
	<div class="logo-box">
		<img src="{{ $fplogo }}" alt="Flat-Planner" class="fplogo" />
	</div>

	<div class="banner">
	@yield('banner')
	</div>

	<div class="credentials">
		@if(Auth::check())
			<a href="/user/{{Auth::user()->username}}">{{{Auth::user()->username}}}</a> | </a><a href="/logout">log out</a>
		@else
			<a href="/login">Log in</a> | <a href="/signup">sign up</a>
		@endif
	</div>
</div>

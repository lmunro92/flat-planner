<div class="logo-box">
	<img src="{{ $fplogo }}" alt="Flat-Planner" class="fplogo" />
</div>

<div class="banner">
@yield('banner')
</div>

<div class="credentials">
	@if(Session::get('flash_message'))
		{{ Session::get('flash_message') }}
	@else
		<a href="/login">Log in/Sign up</a>
	@endif
</div>
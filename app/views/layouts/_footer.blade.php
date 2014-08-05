<div class="bottom-nav">
	<ul>
		<li>Home</li>
		<li>About</li>
		<li>Contact</li>
	</ul>
</div>
<div class="bottom-center">
	<p class="copyright">Flat-Planner is © Jonathan Seitz, 2014.</p>
</div>
@if(Auth::check())
	<p>Logged in as {{Auth::user()->username}}</p>
@endif



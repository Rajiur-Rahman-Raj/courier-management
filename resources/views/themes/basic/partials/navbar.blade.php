<!-- Nav_area_start -->
<nav class="navbar navbar-expand-lg">
	<div class="container custom_nav shadow3 ">
		<a class="logo" href="#"><img src="{{ getFile(config('basic.default_file_driver'),config('basic.logo_image')) }}" alt=""></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
				aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="bars"><i class="fal fa-bars"></i></span>
		</button>
		@php
			$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
			$lastUriSegment = array_pop($uriSegments);
		@endphp

		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav ms-auto text-center align-items-center">
				<li class="nav-item">
					<a class="nav-link @if($lastUriSegment == '') active @endif" aria-current="page" href="{{ route('home') }}">@lang('Home')</a>
				</li>

				<li class="nav-item">
					<a class="nav-link @if($lastUriSegment == 'about') active @endif" href="{{ route('about') }}">@lang('About')</a>
				</li>

				<li class="nav-item">
					<a class="nav-link @if($lastUriSegment == 'service') active @endif" href="{{ route('service') }}">@lang('Service')</a>
				</li>

				<li class="nav-item">
					<a class="nav-link @if($lastUriSegment == 'tracking') active @endif" href="{{ route('tracking') }}">@lang('Tracking')</a>
				</li>

{{--				<li class="nav-item">--}}
{{--					<a class="nav-link @if($lastUriSegment == 'booking') active @endif" href="{{ route('booking') }}">@lang('Booking')</a>--}}
{{--				</li>--}}

				<li class="nav-item">
					<a class="nav-link @if($lastUriSegment == 'blog') active @endif" href="{{ route('blog') }}">@lang('Blog')</a>
				</li>

				<li class="nav-item">
					<a class="nav-link @if($lastUriSegment == 'contact') active @endif" href="{{ route('contact') }}">@lang('Contact')</a>
				</li>

				@guest
					<li class="nav-item">
						<a class="login_btn" href="{{ route('login') }}"><i class="far fa-user me-1"></i>@lang('Login')</a>
					</li>
				@else
					<li class="nav-item">
						<a class="login_btn" href="{{ route('user.dashboard') }}"><i class="far fa-user me-1"></i>@lang('Dashboard')</a>
					</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>
<!-- Nav_area_end -->

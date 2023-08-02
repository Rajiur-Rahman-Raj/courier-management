<!DOCTYPE html>
<html lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="{{ getFile(config('basic.default_file_driver'),config('basic.favicon_image')) }}" rel="icon">
	<title> @yield('page_title') | {{ basicControl()->site_title }} </title>

	@include($theme.'partials.user.styles')
</head>

<body>

<div id="app">
{{--	<div class="main-wrapper main-wrapper-1">--}}
{{--		@include($theme.'partials.user.sidebar')--}}
{{--		@section('content')--}}
{{--		@show--}}
{{--		@include($theme.'partials.user.footer')--}}

		<!-- user_panel_start -->
		<div class="dashboard-wrapper">
			@include($theme.'partials.user.sidebar')

			<!-- content -->
			<div id="content">
				<div class="overlay">
					@include($theme.'partials.user.topbar')
					@yield('content')
				</div>
			</div>
		</div>
		<!-- user_panel_end -->
	</div>
</div>

@include($theme.'partials.user.scripts')
@include($theme.'partials.user.flash-message')

@yield('scripts')

</body>
</html>

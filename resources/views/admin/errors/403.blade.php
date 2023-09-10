@extends('admin.layouts.403_master')
@section('title')
	@lang('403')
@endsection


@section('content')
	<div class="main-content">
		<section class="section">
{{--			<div class="row mt-5">--}}
{{--				<div class="col-12">--}}
{{--					<div class="card">--}}
{{--						<div class="card-body">--}}
{{--							<p class="text-center times-403"><i class="fa fa-user-times"></i></p>--}}
{{--							<h4 class="card-title mb-3 text-center color-secondary"> @lang("You don't have permission to access that link")</h4>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}


			<div class="forbidden_text_wrapper">
				<div class="forbidden_title" data-content="404">
					403 - ACCESS DENIED
				</div>

				<div class="forbidden_subtitle">
					Oops, You don't have permission to access this page.
				</div>
				<div class="forbidden_isi">
					A web server may return a 403 Forbidden HTTP status code in response to a request from a client for a web page or resource to indicate that the server can be reached and understood the request, but refuses to take any further action. Status code 403 responses are the result of the web server being configured to deny access, for some reason, to the requested resource by the client.
				</div>

				<div class="forbidden_buttons">
					<a class="button" href="{{ url()->previous() }}">Go to homepage</a>
				</div>
			</div>


		</section>
	</div>

@endsection

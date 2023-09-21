@extends($theme.'layouts.user')
@section('page_title',__('Create Ticket'))

@section('content')
<div class="main-content">
	<section class="section pt-4 p-5">
		<div class="section-header">
			<h3>@lang('Create Ticket')</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a></li>
					<li class="breadcrumb-item active" aria-current="page">@lang('Create Ticket')</li>
				</ol>
			</nav>
		</div>

		<div class="row mb-3">
			<div class="container-fluid" id="container-wrapper">
				<div class="row justify-content-md-center">
					<div class="col-sm-12">
						<div class="card mb-4 card-primary shadow">
							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
								<h6 class="m-0 font-weight-bold text-primary">@lang('Create Ticket')</h6>
							</div>
							<div class="card-body profile-setting">
								<form action="{{route('user.ticket.store')}}" method="post" enctype="multipart/form-data">
									@csrf

									<div class="input-box">
										<label for="subject">@lang('Subject')</label>
										<input type="text" name="subject" placeholder="@lang('Subject')"
											   value="{{ old('subject') }}"
											   class="form-control @error('subject') is-invalid @enderror">
										<div class="invalid-feedback">
											@error('subject') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="input-box">
										<label for="message">@lang('Message')</label>
										<textarea name="message" rows="5"
												  class="form-control @error('note') is-invalid @enderror">{{ old('message') }}</textarea>
										<div class="invalid-feedback">
											@error('message') @lang($message) @enderror
										</div>
									</div>
									<div class="input-box mt-4">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="upload" name="attachments[]"
												   multiple>
											<label class="custom-file-label form-control-sm"
												   for="upload">@lang('Choose files')</label>
										</div>
										<p class="text-danger select-files-count"></p>
										@error('attachments')
											<div class="error text-danger"> @lang($message) </div>
										@enderror
									</div>
									<button type="submit" class="btn btn-primary btn-sm btn-block cmn_btn">
										@lang('Submit Ticket')
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>

@endsection
@section('scripts')
    <script>
        'use strict';
        $(document).ready(function () {
            $(document).on('change', '#upload', function () {
                var fileCount = $(this)[0].files.length;
                $('.select-files-count').text(fileCount + ' file(s) selected');
            });
        });
    </script>
@endsection

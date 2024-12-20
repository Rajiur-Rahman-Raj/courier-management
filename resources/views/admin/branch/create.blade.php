@extends('admin.layouts.master')

@section('page_title')
	@lang('Create Branch')
@endsection


@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Create Branch")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('branchList')}}">@lang("Branch List")</a></div>
					<div class="breadcrumb-item">@lang("Create Branch")</div>
				</div>
			</div>
		</section>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h5>@lang("Create Branch")</h5>

							<a href="{{route('branchList')}}" class="btn btn-sm  btn-primary mr-2">
								<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
							</a>
						</div>
						<div class="card-body">
							<form method="post" action="{{ route('branchStore') }}"
								  class="mt-4" enctype="multipart/form-data">
								@csrf

								<div class="row">
									<div class="col-sm-12 col-md-12 mb-3">
										<label for="branch_name"> @lang('Branch Name') <span
												class="text-danger">*</span></label>
										<input type="text" name="branch_name"
											   class="form-control @error('branch_name') is-invalid @enderror"
											   value="{{ old('branch_name') }}">
										<div class="invalid-feedback">
											@error('branch_name') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-12 mb-3">
										<label for="email"> @lang('Email') </label>
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-12 mb-3">
										<label for="phone"> @lang('phone') <span class="text-danger">*</span></label>
										<input type="text" name="phone"
											   class="form-control @error('phone') is-invalid @enderror"
											   value="{{ old('phone') }}">
										<div class="invalid-feedback">
											@error('phone') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-12 mb-3">
										<label for="address"> @lang('address') <span
												class="text-danger">*</span></label>
										<input type="text" name="address"
											   class="form-control @error('address') is-invalid @enderror"
											   value="{{ old('address') }}">
										<div class="invalid-feedback">
											@error('address') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-12 my-3">
										<div class="form-group ">
											<label for="details"> @lang('Details') </label>

											<textarea
												class="form-control details_height @error('details') is-invalid @enderror"
												name="details"
												value="{{ old('details') }}">{{old('details')}}</textarea>

											<div class="invalid-feedback">
												@error('details') @lang($message) @enderror
											</div>
											<div class="valid-feedback"></div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-3">
										<div class="form-group mb-4">
											<label class="col-form-label">@lang("Upload Image")</label>
											<div id="image-preview" class="image-preview"
												 style="background-image: url({{ getFile(config('location.category.path'))}}">
												<label for="image-upload"
													   id="image-label">@lang('Choose File')</label>
												<input type="file" name="image" class=""
													   id="image-upload"/>
											</div>
											@error('image')
											<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<div class="col-md-5 form-group">
										<label>@lang('Status')</label>
										<div class="selectgroup w-100">
											<label class="selectgroup-item">
												<input type="radio" name="status" value="0"
													   class="selectgroup-input" {{ old('status') == 0 ? 'checked' : ''}}>
												<span class="selectgroup-button">@lang('OFF')</span>
											</label>
											<label class="selectgroup-item">
												<input type="radio" name="status" value="1"
													   class="selectgroup-input"
													   checked {{ old('status') == 1 ? 'checked' : ''}}>
												<span class="selectgroup-button">@lang('ON')</span>
											</label>
										</div>
									</div>
								</div>

								<button type="submit"
										class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endsection


		@push('extra_scripts')
			<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
		@endpush

		@section('scripts')
			<script type="text/javascript">
				'use strict';
				$(document).ready(function () {
					$.uploadPreview({
						input_field: "#image-upload",
						preview_box: "#image-preview",
						label_field: "#image-label",
						label_default: "Choose File",
						label_selected: "Change File",
						no_label: false
					});
				});
			</script>

@endsection

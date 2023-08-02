@extends('admin.layouts.master')

@section('title')
	@lang('Create New Shipment')
@endsection

@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/image-uploader.css') }}"/>
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Create New Shipment")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('shipmentList')}}">@lang("Shipments List")</a></div>
					<div class="breadcrumb-item">@lang("Create Shipment")</div>
				</div>
			</div>
		</section>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h5>@lang("Create Shipment")</h5>

							<a href="{{route('branchManagerList')}}" class="btn btn-sm  btn-primary mr-2">
								<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
							</a>
						</div>

						<div class="card-body">
							<form method="post" action="{{ route('branchManagerStore') }}"
								  class="mt-4" enctype="multipart/form-data">
								@csrf
								<div class="row mb-3">
									<div class="col-sm-12 col-md-12 mb-3">
										<label for="branch_id"> @lang('Shipment Type') <span
												class="text-danger">*</span></label>

										<div class="custom-control custom-radio">
											<input type="radio" id="customRadio1" name="customRadio"
												   class="custom-control-input">
											<label class="custom-control-label" for="customRadio1">@lang('Pickup')
												(@lang('For door to door delivery'))</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" id="customRadio2" name="customRadio"
												   class="custom-control-input">
											<label class="custom-control-label" for="customRadio2">@lang('Drop off')
												(@lang('For delivery package from branch directly'))</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" id="customRadio3" name="customRadio"
												   class="custom-control-input">
											<label class="custom-control-label" for="customRadio3">@lang('Condition')
												(@lang('Cash on delivery'))</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-3 mb-3">
										<label for="email"> @lang('Shipping Date') <span
												class="text-danger">*</span></label>
										<input type="datetime-local" class="form-control start_date" name="start_date"
											   value="{{ old('start_date',request()->start_date) }}"
											   placeholder="@lang('Start date')" autocomplete="off"/>
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="email"> @lang('Estimate Delivery Date') <span
												class="text-danger">*</span></label>
										<input type="date" class="form-control start_date" name="start_date"
											   value="{{ old('start_date',request()->start_date) }}"
											   placeholder="@lang('Start date')" autocomplete="off"/>
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Sender Branch') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Receiver Branch') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>

								<div class="row">

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Sender') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2" id="senderShipment">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Receiver') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('From Country') <span class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('To Country') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('From State') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('To State') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('From City') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('To City') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

								</div>

								<div class="row">
									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('From Area') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('To Area') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Payment Type') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">@lang('From Wallet')</option>
											<option value="">@lang('Cash')</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Payment Status') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">@lang('Paid')</option>
											<option value="">@lang('Unpaid')</option>
											<option value="">@lang('Postpaid')</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>


								<div class="row mb-3">
									<div class="col-sm-12 col-md-12 mb-3">
										<label for="branch_id"> @lang('Packing Service') <span
												class="text-danger">*</span></label>
										<div class="custom-control custom-radio">
											<input type="radio" id="packing_service" name="packing_service"
												   class="custom-control-input">
											<label class="custom-control-label"
												   for="packing_service">@lang('Yes')</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" id="packing_service2" name="packing_service"
												   class="custom-control-input">
											<label class="custom-control-label"
												   for="packing_service2">@lang('No')</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Packing Type') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">asdfasd</option>
											<option value="">adsasdfs</option>
											<option value="">adsasdf</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="email"> @lang('quantity') <span class="text-danger">*</span></label>
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="email"> @lang('Total Packing Cost') <span
												class="text-danger">*</span></label>
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

								</div>


								<div class="row">
									<div class="col-sm-12 col-md-3 mb-3">
										<label for="branch_id"> @lang('Percel Type') <span
												class="text-danger">*</span></label>
										<select name="branch_id"
												class="form-control @error('branch_id') is-invalid @enderror select2">
											<option value="" disabled selected>@lang('Select Branch')</option>
											<option value="">Food</option>
											<option value="">Oil</option>
											<option value="">Wood</option>
											<option value="">Electronics</option>
										</select>

										<div class="invalid-feedback">
											@error('branch_id') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="email"> @lang('Description/Percel Name') <span
												class="text-danger">*</span></label>
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="email"> @lang('Quantity') <span class="text-danger">*</span></label>
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-3 mb-3">
										<label for="email"> @lang('Weight') kg <span
												class="text-danger">*</span></label>
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>


								<div class="row">
									<div class="col-sm-12 col-md-12">
										<label for="email"> @lang('Dimensions') [Length x Width x Height] (cm) <span
												class="text-danger">*</span></label>
									</div>

									<div class="col-sm-12 col-md-4 mb-3">
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-4 mb-3">
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>

									<div class="col-sm-12 col-md-4 mb-3">
										<input type="text" name="email"
											   class="form-control @error('email') is-invalid @enderror managerEmail"
											   value="{{ old('email') }}">
										<div class="invalid-feedback">
											@error('email') @lang($message) @enderror
										</div>
										<div class="valid-feedback"></div>
									</div>
								</div>

								<div class="row">
									{{--									<div class="col-sm-12 col-md-7">--}}
									{{--										<div class="form-group mb-4">--}}
									{{--											<label class="col-form-label">@lang("Manager Photo")</label>--}}
									{{--											<div id="image-preview" class="image-preview"--}}
									{{--												 style="background-image: url({{ getFile(config('location.category.path'))}}">--}}
									{{--												<label for="image-upload"--}}
									{{--													   id="image-label">@lang('Choose File')</label>--}}
									{{--												<input type="file" name="image" class=""--}}
									{{--													   id="image-upload"/>--}}
									{{--											</div>--}}
									{{--											@error('image')--}}
									{{--											<span class="text-danger">{{ $message }}</span>--}}
									{{--											@enderror--}}
									{{--										</div>--}}
									{{--									</div>--}}

									<div class="col-sm-12 col-md-7">
										<div class="form-group mb-4">
											<label class="col-form-label">@lang("Attatchments")</label>
											<div class="shipment-image"></div>
											@error('listing_image.*')
											<span class="text-danger">@lang($message)</span>
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
													   class="selectgroup-input" {{ old('status') == 1 ? 'checked' : ''}}>
												<span class="selectgroup-button">@lang('ON')</span>
											</label>
										</div>
									</div>
								</div>


								<div class="border-line-area">
									<h6 class="border-line-title">Summary</h6>
								</div>

								<div class="d-flex justify-content-end shipmentsDiscount">
									<div class="col-md-3">
										<div class="input-group">
											<span class="input-group-text">Discount</span>
											<input type="number" name="discount" value=""
												   class="form-control bg-white text-dark discount" id="discount">
											<span class="input-group-text">%</span>
										</div>
									</div>
								</div>

								<div class=" d-flex justify-content-end mt-2">
									<div class="col-md-3  d-flex justify-content-between">
										<span class="fw-bold">Subtotal:</span>
										<div>$<span class="subtotal">30.00</span></div>
									</div>
								</div>

								<div class=" d-flex justify-content-end mt-2">
									<div class="col-md-3  d-flex justify-content-between">
										<span class="fw-bold">Total:</span>
										<div> $<span class="total">27.00</span></div>
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
			<script src="{{ asset('assets/dashboard/js/image-uploader.js') }}"></script>
		@endpush

		@section('scripts')
			<script type="text/javascript">
				'use strict';
				$(document).ready(function () {

					let shipingImageOptions = {
						imagesInputName: 'shipment_image',
						label: 'Drag & Drop files here or click to browse images',
						extensions: ['.jpg', '.jpeg', '.png'],
						mimes: ['image/jpeg', 'image/png'],
						maxSize: 5242880
					};

					$('.shipment-image').imageUploader(shipingImageOptions);



					$.uploadPreview({
						input_field: "#image-upload",
						preview_box: "#image-preview",
						label_field: "#image-label",
						label_default: "Choose File",
						label_selected: "Change File",
						no_label: false
					});

					$('.selectRole').on('change', function () {
						let selectedValue = $(this).val();
						getSeletedRoleUser(selectedValue);
					})

					function getSeletedRoleUser(value) {

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url: '{{ route('getRoleUser') }}',
							method: 'POST',
							data: {
								id: value,
							},
							success: function (response) {
								$('#branchManager').empty();
								let responseData = response;
								responseData.forEach(res => {
									$('#branchManager').append(`<option value="${res.id}">${res.name}</option>`)
								})
								$('#branchManager').append(`<option value="" selected disabled>@lang('Select Manager')</option>`)
							},
							error: function (xhr, status, error) {
								console.log(error)
							}
						});
					}


					$('.branchManager').on('change', function () {
						let selectedValue = $(this).val();
						getSeletedRoleUserInfo(selectedValue);
					})

					function getSeletedRoleUserInfo(value) {

						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

						$.ajax({
							url: '{{ route('getRoleUserInfo') }}',
							method: 'POST',
							data: {
								id: value,
							},
							success: function (response) {
								$('.managerEmail').val(response.email);
								$('.managerPhone').val(response.phone);
							},
							error: function (xhr, status, error) {
								console.log(error)
							}
						});
					}
				});
			</script>
@endsection

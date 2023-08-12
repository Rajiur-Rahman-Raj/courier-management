@extends('admin.layouts.master')

@section('page_title')
	@lang('Create New Shipment')
@endsection

@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/image-uploader.css') }}"/>
	<link href="{{ asset('assets/dashboard/css/flatpickr.min.css') }}" rel="stylesheet">
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

							<a href="{{route('shipmentList')}}" class="btn btn-sm  btn-primary mr-2">
								<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
							</a>
						</div>

						<div class="card-body">
							@include('errors.error')
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active show" data-toggle="tab"
									   href="#tab1" role="tab"
									   aria-controls="tab1"
									   id="operatorCountry"
									   aria-selected="true">@lang('Operator Country')</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" data-toggle="tab"
									   href="#tab2" role="tab"
									   aria-controls="tab2"
									   id="internationalCountry"
									   aria-selected="false">@lang('Internationally')</a>
								</li>
							</ul>

							<div class="tab-content mt-2" id="myTabContent">
								<div class="tab-pane fade show active"
									 id="tab1" role="tabpanel">
									<form method="post" action="{{ route('shipmentStore') }}"
										  class="mt-4" enctype="multipart/form-data">
										@csrf
										<div class="row mb-3">
											<div class="col-sm-12 col-md-12 mb-3">
												<label for="branch_id"> @lang('Shipment Type') </label>
												@foreach($operatorCountryShipmentTypes as $shipmentType)
													<div class="custom-control custom-radio">
														<input type="radio" id="shipmentType{{ $shipmentType->id }}"
															   name="shipment_type"
															   class="custom-control-input">
														<label class="custom-control-label"
															   for="shipmentType{{ $shipmentType->id }}">@lang($shipmentType->shipment_type)
															(@lang($shipmentType->title))</label>
													</div>
												@endforeach
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12 col-md-3 mb-3">
												<label for="email"> @lang('Shipping Date') </label>
												<input type="text" class="form-control shipment_date flatpickr"
													   name="shipment_date"
													   value="{{ old('shipment_date',request()->shipment_date) }}"
													   placeholder="@lang('shipment date')" autocomplete="off"/>
												<div class="invalid-feedback">
													@error('shipment_date') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="email"> @lang('Estimate Delivery Date') </label>
												<input type="date" class="form-control start_date flatpickr2"
													   name="delivery_date"
													   value="{{ old('delivery_date',request()->delivery_date) }}"
													   placeholder="@lang('Delivery date')" autocomplete="off"/>
												<div class="invalid-feedback">
													@error('delivery_date') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="sender_branch"> @lang('Sender Branch') </label>
												<select name="sender_branch"
														class="form-control @error('sender_branch') is-invalid @enderror select2 select-branch">
													<option value="" disabled selected>@lang('Select Branch')</option>
													@foreach($allBranches as $branch)
														<option
															value="{{ $branch->id }}">@lang($branch->branch_name)</option>
													@endforeach
												</select>
												<div class="invalid-feedback">
													@error('sender_branch') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="receiver_branch"> @lang('Receiver Branch')</label>
												<select name="receiver_branch"
														class="form-control @error('receiver_branch') is-invalid @enderror select2 select-branch">
													<option value="" disabled selected>@lang('Select Branch')</option>
													@foreach($allBranches as $branch)
														<option
															value="{{ $branch->id }}">@lang($branch->branch_name)</option>
													@endforeach
												</select>

												<div class="invalid-feedback">
													@error('branch_id') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>
										</div>

										<div class="row">

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="sender_id"> @lang('Sender')</label>
												<select name="sender_id"
														class="form-control @error('sender_id') is-invalid @enderror select2 select-client">
													<option value="" disabled selected>@lang('Select Sender')</option>
													@foreach($senders as $sender)
														<option
															value="{{ $sender->id }}">@lang($sender->name)</option>
													@endforeach
												</select>

												<div class="invalid-feedback">
													@error('sender_id') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="receiver_id"> @lang('Receiver')</label>
												<select name="receiver_id"
														class="form-control @error('receiver_id') is-invalid @enderror select2 select-client">
													<option value="" disabled selected>@lang('Select Receiver')</option>
													@foreach($receivers as $receiver)
														<option
															value="{{ $receiver->id }}">@lang($receiver->name)</option>
													@endforeach
												</select>

												<div class="invalid-feedback">
													@error('receiver_id') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="from_state_id">@lang('From State') </label>
												<select name="from_state_id"
														class="form-control @error('from_state_id') is-invalid @enderror select2 select2State selectedFromState">
													<option value="" selected disabled>@lang('Select State')</option>
													@foreach(optional($basicControl->operatorCountry)->state() as $state)
														<option value="{{ $state->id }}">@lang($state->name)</option>
													@endforeach
												</select>
												<div class="invalid-feedback">
													@error('from_state_id') @lang($message) @enderror
												</div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="from_city_id">@lang('Select City') <span class="text-dark font-weight-bold">(@lang('optional'))</span></label>
												<select name="from_city_id"
														class="form-control @error('from_city_id') is-invalid @enderror select2 select2City selectedFromCity">
												</select>
												<div class="invalid-feedback">
													@error('from_city_id') @lang($message) @enderror
												</div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="from_area_id">@lang('Select Area') <span class="text-dark font-weight-bold">(@lang('optional'))</span></label>
												<select name="from_area_id"
														class="form-control @error('from_area_id') is-invalid @enderror select2 select2Area selectedFromArea">

												</select>
												<div class="invalid-feedback">
													@error('from_area_id') @lang($message) @enderror
												</div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="to_state_id">@lang('To State') </label>
												<select name="to_state_id"
														class="form-control @error('to_state_id') is-invalid @enderror select2 select2State selectedToState">
													<option value="" selected disabled>@lang('Select State')</option>
													@foreach(optional($basicControl->operatorCountry)->state() as $state)
														<option value="{{ $state->id }}">@lang($state->name)</option>
													@endforeach
												</select>
												<div class="invalid-feedback">
													@error('to_state_id') @lang($message) @enderror
												</div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="to_city_id">@lang('Select City') <span class="text-dark font-weight-bold">(@lang('optional'))</span></label>
												<select name="to_city_id"
														class="form-control @error('to_city_id') is-invalid @enderror select2 select2City selectedToCity">
												</select>
												<div class="invalid-feedback">
													@error('to_city_id') @lang($message) @enderror
												</div>
											</div>


											<div class="col-sm-12 col-md-3 mb-3">
												<label for="to_area_id">@lang('Select Area') <span class="text-dark font-weight-bold">(@lang('optional'))</span> </label>
												<select name="to_area_id"
														class="form-control @error('to_area_id') is-invalid @enderror select2 select2Area selectedToArea">
												</select>
												<div class="invalid-feedback">
													@error('to_area_id') @lang($message) @enderror
												</div>
											</div>

											<div class="col-sm-12 col-md-4 mb-3">
												<label for="payment_by"> @lang('Payment By')</label>
												<select name="payment_by"
														class="form-control @error('payment_by') is-invalid @enderror">
													<option value="1">@lang('Sender')</option>
													<option value="2">@lang('Receiver')</option>
												</select>

												<div class="invalid-feedback">
													@error('payment_by') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-4 mb-3">
												<label for="branch_id"> @lang('Payment Type')</label>
												<select name="payment_type"
														class="form-control @error('payment_type') is-invalid @enderror select2">
													<option value="" disabled selected>@lang('Select Payment Type')</option>
													<option value="wallet">@lang('From Wallet')</option>
													<option value="cash">@lang('Cash')</option>
												</select>

												<div class="invalid-feedback">
													@error('payment_type') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-4 mb-3">
												<label for="payment_status"> @lang('Payment Status') <span
														class="text-danger">*</span></label>
												<select name="payment_status"
														class="form-control @error('payment_status') is-invalid @enderror select2">
													<option value="" disabled selected>@lang('Select Payment Status')</option>
													<option value="1">@lang('Paid')</option>
													<option value="2">@lang('Unpaid')</option>
												</select>

												<div class="invalid-feedback">
													@error('payment_status') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>
										</div>


										<div class="row mb-3">
											<div class="col-sm-12 col-md-12 mb-3 mt-3">
												<label for="branch_id"> @lang('Packing Service') </label>
												<div class="custom-control custom-radio">
													<input type="radio" id="packing_service" name="packing_service"
														   class="custom-control-input">
													<label class="custom-control-label"
														   for="packing_service">@lang('Yes')</label>
												</div>
												<div class="custom-control custom-radio">
													<input type="radio" id="packing_service2" name="packing_service"
														   class="custom-control-input" checked>
													<label class="custom-control-label"
														   for="packing_service2">@lang('No')</label>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12 col-md-3 mb-3">
												<label for="package_id"> @lang('Select Package')</label>
												<select name="package_id"
														class="form-control @error('package_id') is-invalid @enderror select2 selectedPackage">
													<option value="" disabled selected>@lang('Select package')</option>
													@foreach($packageList as $package)
														<option value="{{ $package->id }}">@lang($package->package_name)</option>
													@endforeach
												</select>

												<div class="invalid-feedback">
													@error('package_id') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="">@lang('Select Variant')</label>
												<select name="variant_id"
														class="form-control @error('variant_id') is-invalid @enderror selectedVariant">
												</select>

												<div class="invalid-feedback">
													@error('variant_id') @lang($message) @enderror
												</div>
											</div>

											<div class="col-sm-12 col-md-2 mb-3">
												<label for="variant_price"> @lang('Price')</label>
												<div class="input-group">
													<input type="text" name="variant_price"
														   class="form-control @error('variant_price') is-invalid @enderror variantPrice">
													<div class="input-group-append" readonly="">
														<div class="form-control">
															{{ config('basic.currency_symbol') }}
														</div>
													</div>
													<div class="invalid-feedback">
														@error('variant_price') @lang($message) @enderror
													</div>
													<div class="valid-feedback"></div>
												</div>
											</div>



											<div class="col-sm-12 col-md-2 mb-3">
												<label for="variant_quantity"> @lang('quantity')</label>
												<input type="text" name="variant_quantity"
													   class="form-control @error('variant_quantity') is-invalid @enderror"
													   value="{{ old('variant_quantity') }}" id="variantQuantity">
												<div class="invalid-feedback">
													@error('variant_quantity') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-2 mb-3">
												<label for="email"> @lang('Total Packing Cost') <span
														class="text-danger">*</span></label>
												<input type="text" name="email"
													   class="form-control @error('email') is-invalid @enderror managerEmail totalPackingCost"
													   value="{{ old('email') }}" readonly>
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
												<label for="email"> @lang('Dimensions') [Length x Width x Height] (cm)
													<span
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
														   class="form-control bg-white text-dark discount"
														   id="discount">
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

								<div class="tab-pane fade"
									 id="tab2" role="tabpanel">
									<form method="post" action="{{ route('shipmentStore') }}"
										  class="mt-4" enctype="multipart/form-data">
										@csrf
										<div class="row mb-3">
											<div class="col-sm-12 col-md-12 mb-3">
												<label for="branch_id"> @lang('Shipment Type') </label>
												@foreach($internationallyShipmentTypes as $shipmentType)
													<div class="custom-control custom-radio">
														<input type="radio" id="shipmentType{{ $shipmentType->id }}"
															   name="shipment_type"
															   class="custom-control-input">
														<label class="custom-control-label"
															   for="shipmentType{{ $shipmentType->id }}">@lang($shipmentType->shipment_type)
															(@lang($shipmentType->title))</label>
													</div>
												@endforeach
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12 col-md-3 mb-3">
												<label for="email"> @lang('Shipping Date') </label>
												<input type="text" class="form-control shipment_date flatpickr"
													   name="shipment_date"
													   value="{{ old('shipment_date',request()->shipment_date) }}"
													   placeholder="@lang('shipment date')" autocomplete="off"/>
												<div class="invalid-feedback">
													@error('shipment_date') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="email"> @lang('Estimate Delivery Date') </label>
												<input type="date" class="form-control start_date flatpickr2"
													   name="delivery_date"
													   value="{{ old('delivery_date',request()->delivery_date) }}"
													   placeholder="@lang('Delivery date')" autocomplete="off"/>
												<div class="invalid-feedback">
													@error('delivery_date') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="sender_branch"> @lang('Sender Branch') </label>
												<select name="sender_branch"
														class="form-control @error('sender_branch') is-invalid @enderror select2 select-branch">
													<option value="" disabled selected>@lang('Select Branch')</option>
													@foreach($allBranches as $branch)
														<option
															value="{{ $branch->id }}">@lang($branch->branch_name)</option>
													@endforeach
												</select>
												<div class="invalid-feedback">
													@error('sender_branch') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="receiver_branch"> @lang('Receiver Branch')</label>
												<select name="receiver_branch"
														class="form-control @error('receiver_branch') is-invalid @enderror select2 select-branch">
													<option value="" disabled selected>@lang('Select Branch')</option>
													@foreach($allBranches as $branch)
														<option
															value="{{ $branch->id }}">@lang($branch->branch_name)</option>
													@endforeach
												</select>

												<div class="invalid-feedback">
													@error('branch_id') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>
										</div>

										<div class="row">

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="sender_id"> @lang('Sender')</label>
												<select name="sender_id"
														class="form-control @error('sender_id') is-invalid @enderror select2 select-client"
														id="sender_id">
													<option value="" disabled selected>@lang('Select Sender')</option>
													@foreach($senders as $sender)
														<option value="{{ $sender->id }}">@lang($sender->name)</option>
													@endforeach
												</select>

												<div class="invalid-feedback">
													@error('sender_id') @lang($message) @enderror
												</div>
												<div class="valid-feedback"></div>
											</div>

											<div class="col-sm-12 col-md-3 mb-3">
												<label for="receiver_id"> @lang('Receiver')</label>
												<select name="receiver_id"
														class="form-control @error('receiver_id') is-invalid @enderror select2 select-client">
													<option value="" disabled selected>@lang('Select Receiver')</option>
													@foreach($receivers as $receiver)
														<option
															value="{{ $receiver->id }}">@lang($receiver->name)</option>
													@endforeach
												</select>

												<div class="invalid-feedback">
													@error('receiver_id') @lang($message) @enderror
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
												<label for="email"> @lang('Dimensions') [Length x Width x Height] (cm)
													<span
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
														   class="form-control bg-white text-dark discount"
														   id="discount">
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
			</div>
		</div>
		@endsection

		@push('extra_scripts')
			<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
			<script src="{{ asset('assets/dashboard/js/image-uploader.js') }}"></script>
			<script src="{{ asset('assets/dashboard/js/flatpickr.js') }}"></script>
		@endpush

		@section('scripts')
			@include('partials.getParcelUnit')
			@include('partials.locationJs')
			@include('partials.select2Create')
			@include('partials.packageVariant')
			<script type="text/javascript">
				'use strict';
				$(document).ready(function () {

					$(".flatpickr").flatpickr({
						altInput: true,
						dateFormat: "Y-m-d H:i",
						enableTime: true,

					});

					$(".flatpickr2").flatpickr({
						altInput: true,
						dateFormat: "Y-m-d H:i",
					});


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

					$('#variantQuantity').on('keyup', function (){
						let quantity = $(this).val();
						let variantPrice = $('.variantPrice').val();

						let totalPackingCost = quantity * variantPrice;
						$('.totalPackingCost').val(totalPackingCost);
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

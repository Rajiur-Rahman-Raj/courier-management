@extends('admin.layouts.master')
@section('page_title', 'Shipment Type List')
@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Parcel Service List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Shipment Type List')</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row mt-sm-4">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="container-fluid" id="container-wrapper">
							<div class="row justify-content-md-center">
								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Shipment Type List')</h6>
											<button class="btn btn-sm btn-outline-primary"
													data-target="#add-shipmentType-modal"
													data-toggle="modal"><i
													class="fas fa-plus-circle"></i> @lang('Add Shipment Type')</button>
										</div>

										<div class="card-body">
											@include('errors.error')
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col">@lang('Shipment Area')</th>
														<th scope="col">@lang('Shipment Type')</th>
														<th scope="col">@lang('title')</th>
														<th scope="col">@lang('Status')</th>
														<th scope="col">@lang('Action')</th>
													</tr>
													</thead>

													<tbody>
													@forelse($allShipmentType as $key => $type)
														<tr>
															<td data-label="@lang('Shipment Area')">
																@if($type->shipment_area == '1')
																	@lang('Operator Country')
																@elseif($type->shipment_area == '2')
																	@lang('Internationally')
																@else
																	@lang('Operator Country + Internationally')
																@endif
															</td>

															<td data-label="@lang('Shipment Type')">
																@lang($type->shipment_type)
															</td>

															<td data-label="@lang('title')">
																@lang($type->title)
															</td>

															<td data-label="@lang('Status')"
																class="font-weight-bold text-dark">
																	<?php echo $type->statusMessage; ?>
															</td>

															<td data-label="@lang('Action')">
																<button data-target="#updateShipmnetTypeModal"
																		data-toggle="modal"
																		data-route="{{route('shipmentTypeUpdate', $type->id)}}"
																		data-property="{{ $type }}"
																		class="btn btn-sm btn-outline-primary editShipmentType">
																	<i class="fas fa-edit"></i> @lang(' Edit')</button>
															</td>
														</tr>
													@empty
														<tr>
															<th colspan="100%"
																class="text-center">@lang('No data found')</th>
														</tr>
													@endforelse
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>
	</div>


	{{-- Add Parcel Type Modal --}}
	<div id="add-shipmentType-modal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Add Shipment Type')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="{{ route('shipmentTypeStore') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="col-12 mt-3">
							<label for="">@lang('Shipment Area')</label>
							<select name="shipment_area"
									class="form-control @error('shipment_area') is-invalid @enderror select2">
								<option value="" disabled selected>@lang('Select One')</option>
									<option value="1">@lang('Operator Country')</option>
									<option value="2">@lang('Internationally')</option>
									<option value="3">@lang('Both') (@lang('Operator Country + Internationally'))</option>
							</select>
							<div class="invalid-feedback">
								@error('shipment_area') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Shipment Type') </label>
							<input
								type="text"
								class="form-control @error('shipment_type') is-invalid @enderror" name="shipment_type"
								placeholder="@lang('shipment type')" required/>
							<div class="invalid-feedback">
								@error('shipment_type') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Title') <span class="text-danger">(@lang('optional'))</span></label>
							<input
								type="text"
								class="form-control @error('title') is-invalid @enderror" name="title"
								placeholder="@lang('title')" required/>
							<div class="invalid-feedback">
								@error('title') @lang($message) @enderror
							</div>
						</div>

						<div class="col-md-12 my-3">
							<label for="">@lang('Status') </label>
							<div class="selectgroup w-100">
								<label class="selectgroup-item">
									<input type="radio" name="status" value="0" class="selectgroup-input">
									<span class="selectgroup-button">@lang('OFF')</span>
								</label>
								<label class="selectgroup-item">
									<input type="radio" name="status" value="1" class="selectgroup-input" checked>
									<span class="selectgroup-button">@lang('ON')</span>
								</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
						<button type="submit" class="btn btn-primary">@lang('save')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Edit Parcel Type Modal --}}
	<div id="updateShipmnetTypeModal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Edit Shipment Type')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="editShipmentTypeForm">
					@csrf
					@method('put')
					<div class="modal-body">

						<div class="col-12 mt-3">
							<label for="">@lang('Shipment Area')</label>
							<select name="shipment_area"
									class="form-control @error('shipment_area') is-invalid @enderror shipment-area">
								<option value="1">@lang('Operator Country')</option>
								<option value="2">@lang('Internationally')</option>
								<option value="3">@lang('Both') (@lang('Operator Country + Internationally'))</option>
							</select>
							<div class="invalid-feedback">
								@error('shipment_area') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Shipment Type') <span class="text-danger">*</span></label>
							<input
								type="text"
								class="form-control shipment-type-name" name="shipment_type"
								placeholder="@lang('shipment type')" required/>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Title') <span class="text-danger">*</span></label>
							<input
								type="text"
								class="form-control shipment-type-title" name="title"
								placeholder="@lang('title')" required/>
						</div>

						<div class="col-md-12 my-3">
							<label for="">@lang('Status') </label>
							<div class="selectgroup w-100">
								<label class="selectgroup-item">
									<input type="radio" name="status" value="0"
										   class="selectgroup-input status_disabled">
									<span class="selectgroup-button">@lang('OFF')</span>
								</label>
								<label class="selectgroup-item">
									<input type="radio" name="status" value="1"
										   class="selectgroup-input status_enabled">
									<span class="selectgroup-button">@lang('ON')</span>
								</label>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
						<button type="submit" class="btn btn-primary">@lang('Update')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		'use strict'
		$(document).ready(function () {

			$(document).on('click', '.editShipmentType', function () {
				let dataRoute = $(this).data('route');
				$('#editShipmentTypeForm').attr('action', dataRoute);
				let dataProperty = $(this).data('property');
				$('.shipment-area').val(dataProperty.shipment_area);
				$('.shipment-type-name').val(dataProperty.shipment_type);
				$('.shipment-type-title').val(dataProperty.title);
				$(dataProperty.status == 0 ? '.status_disabled' : '.status_enabled').prop('checked', true);
			});
		})
	</script>

	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict"
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif

@endsection

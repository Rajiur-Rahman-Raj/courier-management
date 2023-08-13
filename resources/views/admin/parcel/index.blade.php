@extends('admin.layouts.master')
@section('page_title', 'Parcel Service List')
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
					<div class="breadcrumb-item">@lang('Parcel Service List')</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row mt-sm-4">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="container-fluid" id="container-wrapper">

							<div class="row justify-content-md-between">
								<div class="col-lg-6">
									<div class="card mb-4 card-primary shadow">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Parcel Type List')</h6>
											<button class="btn btn-sm btn-outline-primary"
													data-target="#add-parcel-type-modal"
													data-toggle="modal"><i
													class="fas fa-plus-circle"></i> @lang('Add Parcel Type')</button>
										</div>

										<div class="card-body">
											@include('errors.error')
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col">@lang('Parcel Type')</th>
														<th scope="col">@lang('Status')</th>
														<th scope="col">@lang('Action')</th>
													</tr>
													</thead>

													<tbody>
													@forelse($allParcelTypes as $key => $types)
														<tr>
															<td data-label="@lang('Package Name')">
																@lang($types->parcel_type)
															</td>

															<td data-label="@lang('Status')"
																class="font-weight-bold text-dark">
																	<?php echo $types->statusMessage; ?>
															</td>

															<td data-label="@lang('Action')">
																<button data-target="#editParcelTypeModal"
																		data-toggle="modal"
																		data-route="{{route('parcelTypeUpdate', $types->id)}}"
																		data-property="{{ $types }}"
																		class="btn btn-sm btn-outline-primary editParcelType">
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
											<div
												class="card-footer d-flex justify-content-center">{{ $allParcelTypes->links() }}</div>
										</div>
									</div>
								</div>


								<div class="col-lg-6">
									<div class="card mb-4 card-primary shadow">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Parcel Unit')</h6>
											<button class="btn btn-sm btn-outline-primary"
													data-target="#add-parcel-unit-modal"
													data-toggle="modal"><i
													class="fas fa-plus-circle"></i> @lang('Add Unit')</button>
										</div>

										<div class="card-body">
											@include('errors.error')
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col">@lang('Parcel Type')</th>
														<th scope="col">@lang('Unit')</th>
														<th scope="col">@lang('Status')</th>
														<th scope="col">@lang('Action')</th>
													</tr>
													</thead>

													<tbody>
													@forelse($allParcelUnits as $key => $unit)
														<tr>
															<td data-label="@lang('Parcel Type')">
																@lang(optional($unit->parcelType)->parcel_type)
															</td>

															<td data-label="@lang('Unit')">
																@lang($unit->unit)
															</td>

															<td data-label="@lang('Status')"
																class="font-weight-bold text-dark">
																	<?php echo $types->statusMessage; ?>
															</td>


															<td data-label="@lang('Action')">
																<button data-target="#editParcelUnitModal"
																		data-toggle="modal"
																		data-route="{{ route('parcelUnitUpdate', $unit->id) }}"
																		data-property="{{ $unit }}"
																		class="btn btn-sm btn-outline-primary editParcelUnit">
																	<i class="fas fa-edit"></i> @lang(' Edit')</button>
															</td>

														</tr>
													@empty
														<tr>
															<th colspan="100%" class="text-center">@lang('No data found')</th>
														</tr>
													@endforelse
													</tbody>
												</table>
											</div>
											<div class="card-footer d-flex justify-content-center">{{ $allParcelUnits->links() }}</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow-sm">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Search')</h6>
										</div>

										<div class="card-body">
											<form action="" method="get">
												<div class="row">
													<div class="col-md-3">
														<div class="form-group">
															<input placeholder="@lang('parcel type')" name="parcel_type"
																   value="{{ old('parcel_type',request()->parcel_type) }}"
																   type="text"
																   class="form-control form-control-sm">
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<input placeholder="@lang('unit')" name="parcel_unit"
																   value="{{ old('parcel_unit',request()->parcel_unit) }}"
																   type="text"
																   class="form-control form-control-sm">
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group search-currency-dropdown">
															<select name="status" class="form-control form-control-sm">
																<option value="all">@lang('All Status')</option>
																<option
																	value="active" {{  request()->status == 'active' ? 'selected' : '' }}>@lang('Active')</option>
																<option
																	value="deactive" {{  request()->status == 'deactive' ? 'selected' : '' }}>@lang('Deactive')</option>
															</select>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<button type="submit"
																	class="btn btn-primary btn-sm btn-block"><i
																	class="fas fa-search"></i> @lang('Search')</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="row justify-content-md-center">
								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Parcel Service List')</h6>
											<button class="btn btn-sm btn-outline-primary"
													data-target="#add-parcelService-modal"
													data-toggle="modal"><i
													class="fas fa-plus-circle"></i> @lang('Add Service')</button>
										</div>

										<div class="card-body">
											@include('errors.error')
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col">@lang('Parcel Type')</th>
														<th scope="col">@lang('Unit')</th>
														<th scope="col">@lang('Cost')</th>
														<th scope="col">@lang('Status')</th>
														<th scope="col">@lang('Action')</th>
													</tr>
													</thead>

													<tbody>
													@forelse($allParcelService as $key => $service)
														<tr>
															<td data-label="@lang('Parcel Type')">
																@lang(optional($service->parcelType)->parcel_type)
															</td>

															<td data-label="@lang('Unit')">
																@lang(optional($service->parcelUnit)->unit)
															</td>

															<td data-label="@lang('Cost')">
																{{ config('basic.currency_symbol') . $service->cost }}
															</td>


															<td data-label="@lang('Status')"
																class="font-weight-bold text-dark">
																	<?php echo $service->statusMessage; ?>
															</td>

															<td data-label="@lang('Action')">
																<button data-target="#updateParcelServiceModal"
																		data-toggle="modal"
																		data-route="{{route('parcelServiceUpdate', $service->id)}}"
																		data-property="{{ $service }}"
																		class="btn btn-sm btn-outline-primary editParcelService">
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
											<div
												class="card-footer d-flex justify-content-center">{{ $allParcelService->links() }}</div>
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
	<div id="add-parcel-type-modal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Add Parcel Type')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="{{ route('parcelTypeStore') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="col-12 mt-3">
							<label for="">@lang('Parcel Type') <span class="text-danger">*</span></label>
							<input
								type="text"
								class="form-control @error('parcel_type') is-invalid @enderror" name="parcel_type"
								placeholder="@lang('parcel type')" required/>
							<div class="invalid-feedback">
								@error('parcel_type') @lang($message) @enderror
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
	<div id="editParcelTypeModal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Edit Parcel Type')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="editParcelTypeForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<div class="col-12 mt-3">
							<label for="">@lang('Parcel Type')</label>
							<input
								type="text"
								class="form-control parcel-type-name" name="parcel_type"
								placeholder="@lang('type name')" required/>
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

	{{-- Add Parcel Unit Modal --}}
	<div id="add-parcel-unit-modal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Add Parcel Unit')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="{{ route('parcelUnitStore') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="col-12 mt-3">
							<label for="">@lang('Select Parcel Type') <span class="text-danger">*</span></label>
							<select name="parcel_type_id"
									class="form-control @error('parcel_type_id') is-invalid @enderror select2">
								<option value="" disabled selected>@lang('Select Parcel Type')</option>
								@foreach($allParcelTypes as $type)
									<option value="{{ $type->id }}">@lang($type->parcel_type)</option>
								@endforeach
							</select>

							<div class="invalid-feedback">
								@error('parcel_type_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Unit') <span class="text-danger">*</span></label>
							<input
								type="text"
								class="form-control @error('unit') is-invalid @enderror" name="unit"
								placeholder="@lang('unit')" required/>
							<div class="invalid-feedback">
								@error('unit') @lang($message) @enderror
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

	{{-- Uddate Parcel Unit Modal --}}
	<div id="editParcelUnitModal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Edit Parcel Unit')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="updateParcelUnitForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<div class="col-12 mt-3">
							<label for="">@lang('Select Parcel Type') <span class="text-danger">*</span></label>
							<select name="parcel_type_id" class="form-control @error('parcel_type_id') is-invalid @enderror"
									id="parcelTypeId">
								@foreach($allParcelTypes as $type)
									<option value="{{ $type->id }}">@lang($type->parcel_type)</option>
								@endforeach
							</select>

							<div class="invalid-feedback">
								@error('parcel_type_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="" class="variant-label">@lang('Unit') <span
									class="text-danger">*</span></label>
							<input
								type="text"
								class="form-control @error('unit') is-invalid @enderror parcel-unit-name" name="unit"
								placeholder="@lang('unit')" value="" required/>
							<div class="invalid-feedback">
								@error('unit') @lang($message) @enderror
							</div>
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

	{{-- Add Parcel Service Modal --}}
	<div id="add-parcelService-modal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Add Parcel Service')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="{{ route('parcelServiceStore') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="col-12 mt-3">
							<label for="">@lang('Select Parcel Type') <span class="text-danger">*</span></label>
							<select name="parcel_type_id"
									class="form-control @error('parcel_type_id') is-invalid @enderror selectedParcelType">
								<option value="" disabled selected>@lang('Select Parcel Type')</option>
								@foreach($allParcelTypes as $type)
									<option value="{{ $type->id }}">@lang($type->parcel_type)</option>
								@endforeach
							</select>

							<div class="invalid-feedback">
								@error('parcel_type_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Select Unit') <span class="text-danger">*</span></label>
							<select name="parcel_unit_id"
									class="form-control @error('parcel_unit_id') is-invalid @enderror selectedParcelUnit">
							</select>

							<div class="invalid-feedback">
								@error('parcel_unit_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Cost per unit') <span class="text-danger">*</span> <span class=" text-dark font-weight-bold"></span></label>

							<div class="input-group">
								<input type="text" class="form-control @error('cost') is-invalid @enderror" name="cost"
									   placeholder="@lang('amount')" required/>
								<div class="input-group-append">
									<div class="form-control">
										{{ config('basic.base_currency') }}
									</div>
								</div>
								<div class="invalid-feedback">
									@error('cost') @lang($message) @enderror
								</div>
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

	{{-- Uddate Parcel Service Modal --}}
	<div id="updateParcelServiceModal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Update Parcel Service')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="updateParcelServiceForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<div class="col-12 mt-3">
							<label for="">@lang('Select Parcel Type') <span class="text-danger">*</span></label>
							<select name="parcel_type_id"
									class="form-control @error('parcel_type_id') is-invalid @enderror selectedParcelType"
									id="typeId">
								@foreach($allParcelTypes as $types)
									<option value="{{ $types->id }}">@lang($types->parcel_type)</option>
								@endforeach
							</select>

							<div class="invalid-feedback">
								@error('parcel_type_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Select Unit') <span class="text-danger">*</span></label>
							<select name="parcel_unit_id" class="form-control @error('parcel_unit_id') is-invalid @enderror selectedParcelUnit"
									id="unitId">
								@foreach($allParcelUnits as $unit)
									<option value="{{ $unit->id }}">@lang($unit->unit)</option>
								@endforeach
							</select>

							<div class="invalid-feedback">
								@error('parcel_unit_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Cost per unit') <span class="text-danger">*</span> <span class="font-weight-bold"></span></label>

							<div class="input-group">
								<input type="text" class="form-control @error('cost') is-invalid @enderror parcel-cost"
									   name="cost"
									   placeholder="@lang('amount')" required/>
								<div class="input-group-append">
									<div class="form-control">
										{{ config('basic.base_currency') }}
									</div>
								</div>
								<div class="invalid-feedback">
									@error('cost') @lang($message) @enderror
								</div>
							</div>
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
	@include('partials.getParcelUnit')
	<script>
		'use strict'
		$(document).ready(function () {

			$(document).on('click', '.editParcelType', function () {
				let dataRoute = $(this).data('route');
				$('#editParcelTypeForm').attr('action', dataRoute);
				let dataProperty = $(this).data('property');
				$('.parcel-type-name').val(dataProperty.parcel_type);
				$(dataProperty.status == 0 ? '.status_disabled' : '.status_enabled').prop('checked', true);
			});



			$(document).on('click', '.editParcelUnit', function () {

				let dataRoute = $(this).data('route');
				let dataProperty = $(this).data('property');

				$('#updateParcelUnitForm').attr('action', dataRoute);
				$('#parcelTypeId').val(dataProperty.parcel_type_id);
				$('.parcel-unit-name').val(dataProperty.unit);

				$(dataProperty.status == 0 ? '.status_disabled' : '.status_enabled').prop('checked', true);
			});

			$(document).on('click', '.editParcelService', function () {
				let dataRoute = $(this).data('route');

				let dataProperty = $(this).data('property');

				$('#updateParcelServiceForm').attr('action', dataRoute)


				$('#typeId').val(dataProperty.parcel_type_id);
				$('#unitId').val(dataProperty.parcel_unit_id);
				$('.parcel-cost').val(dataProperty.cost);

				$(dataProperty.status == 0 ? '.status_disabled' : '.status_enabled').prop('checked', true);

				let unitId = dataProperty.parcel_unit_id;

				getSelectedParcelTypeUnit(dataProperty.parcel_type_id, unitId);

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

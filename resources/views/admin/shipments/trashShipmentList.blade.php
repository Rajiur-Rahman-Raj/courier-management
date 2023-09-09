@extends('admin.layouts.master')
@section('page_title', __('Trash Shipment List'))
@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Deleted Shipment List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Trash Shipment')</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row mt-sm-4">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="container-fluid" id="container-wrapper">
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
															<label for="shipment_id" class="custom-text">@lang('Shipment id')</label>
															<input placeholder="@lang('shipment id')" name="shipment_id"
																   value="{{ old('name',request()->shipment_id) }}" type="text"
																   class="form-control form-control-sm">
														</div>
													</div>


													<div class="col-md-3">
														<div class="form-group">
															<label for="shipment_date" class="custom-text">@lang('Shipment Date')</label>
															<input placeholder="@lang('shipment date')" name="shipment_date"
																   value="{{ old('shipment_date', request()->shipment_date) }}" type="date"
																   class="form-control form-control-sm" autocomplete="off">
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group search-currency-dropdown">
															<label for="status" class="custom-text">@lang('Status')</label>
															<select name="status" class="form-control form-control-sm">
																<option value="">@lang('All Status')</option>
																<option
																	value="queue" {{  request()->status == 'queue' ? 'selected' : '' }}>@lang('In Queue')</option>
																<option
																	value="dispatch" {{  request()->status == 'dispatch' ? 'selected' : '' }}>@lang('Dispatch')</option>
																<option
																	value="upcoming" {{  request()->status == 'upcoming' ? 'selected' : '' }}>@lang('Upcoming')</option>
																<option
																	value="received" {{  request()->status == 'received' ? 'selected' : '' }}>@lang('Received')</option>
																<option
																	value="delivered" {{  request()->status == 'delivered' ? 'selected' : '' }}>@lang('Delivered')</option>
															</select>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<span class="opacity-0">---</span>
															<button type="submit"
																	class="btn btn-primary btn-sm btn-block mt-2"><i
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
											<h6 class="m-0 font-weight-bold text-primary">@lang('Trash Shipment List')</h6>
										</div>

										<div class="card-body">
											{{-- Table --}}
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col"
															class="custom-text">@lang('SL.')</th>
														<th scope="col"
															class="custom-text">@lang('Shipment Id')</th>
														<th scope="col"
															class="custom-text">@lang('Shipment Type')</th>
														<th scope="col"
															class="custom-text">@lang('Sender Branch')</th>
														<th scope="col"
															class="custom-text">@lang('Receiver Branch')</th>
														<th scope="col"
															class="custom-text">@lang('From State')</th>
														<th scope="col"
															class="custom-text">@lang('To State')</th>
														<th scope="col"
															class="custom-text">@lang('Total Cost')</th>
														<th scope="col"
															class="custom-text">@lang('Shipment Date')</th>
														<th scope="col"
															class="custom-text">@lang('Status')</th>
														<th scope="col"
															class="custom-text">@lang('Action')</th>
													</tr>
													</thead>

													<tbody>

													@forelse($trashShipments as $key => $shipment)
														<tr>
															<td data-label="SL."> {{ ++$key }} </td>
															<td data-label="Shipment Id"> {{ $shipment->shipment_id }} </td>
															<td data-label="Shipment Type"> {{ $shipment->shipment_type }} </td>
															<td data-label="Sender Branch"> @lang(optional($shipment->senderBranch)->branch_name) </td>
															<td data-label="Receiver Branch"> @lang(optional($shipment->receiverBranch)->branch_name) </td>
															<td data-label="From State"> @lang(optional($shipment->fromState)->name) </td>
															<td data-label="To State"> @lang(optional($shipment->toState)->name) </td>
															<td data-label="Total Cost"> {{ $basic->currency_symbol }}{{ $shipment->total_pay }} </td>

															<td data-label="Shipment Date"> {{ customDate($shipment->shipment_date) }} </td>

															<td data-label="Status">
																@if($shipment->status == 1)
																	<span
																		class="badge badge-info">@lang('In Queue')</span>
																@elseif($shipment->status == 2)
																	<span
																		class="badge badge-warning">@lang('Dispatch')</span>
																@elseif($shipment->status == 3)
																	<span
																		class="badge badge-primary">@lang('Upcoming')</span>
																@elseif($shipment->status == 4)
																	<span
																		class="badge badge-success">@lang('Received')</span>
																@elseif($shipment->status == 5)
																	<span
																		class="badge badge-danger">@lang('Delivered')</span>
																@endif
															</td>

															<td data-label="@lang('Action')">
																<div class="btn-group">
																	<button type="button"
																			class="btn btn-primary btn-sm dropdown-toggle"
																			data-toggle="dropdown"
																			aria-haspopup="true"
																			aria-expanded="false">
																		@lang('Options')
																	</button>
																	<div class="dropdown-menu">
																		<a data-target="#restoreShipment"
																		   data-toggle="modal"
																		   data-route="{{route('restoreShipment', $shipment->id)}}"
																		   href="javascript:void(0)"
																		   class="dropdown-item btn-outline-primary btn-sm restoreShipment"><i class="fas fa-window-restore mr-2"></i> @lang('Restore')
																		</a>

																		<a data-target="#forceDeleteShipment"
																		   data-toggle="modal"
																		   data-route="{{route('forceDeleteShipment', $shipment->id)}}"
																		   href="javascript:void(0)"
																		   class="dropdown-item btn-outline-primary btn-sm forceDeleteShipment"> <i class="fas fa-trash mr-2"></i> @lang('Delete Permanent')
																		</a>
																	</div>
																</div>
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
												class="card-footer d-flex justify-content-center">{{ $trashShipments->links() }}</div>
											{{-- Table --}}
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

	{{-- Edit Shipment Status Modal --}}
	<div id="updateShipmentStatus" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Confirmation')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="editShipmentStatusForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<p>@lang('Are you sure to dispatch this shipment?')</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Delete Shipment Modal --}}
	<div id="deleteShipment" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Confirmation')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="deleteShipmentForm">
					@csrf
					@method('delete')
					<div class="modal-body">
						<p>@lang('Are you sure to delete this shipment?')</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Restore Shipment Modal --}}
	<div id="restoreShipment" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Confirmation')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="get" id="restoreShipmentForm">
					<div class="modal-body">
						<p>@lang('Are you sure to restore this shipment?')</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Force Delete Shipment Modal --}}
	<div id="forceDeleteShipment" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Confirmation')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="forceDeleteShipmentForm">
					@csrf
					@method('delete')
					<div class="modal-body">
						<p>@lang('Are you sure to permanent delete this shipment?')</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
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
			$(document).on('click', '.editShipmentStatus', function () {
				let dataRoute = $(this).data('route');
				$('#editShipmentStatusForm').attr('action', dataRoute);
			});

			$(document).on('click', '.deleteShipment', function () {
				let dataRoute = $(this).data('route');
				$('#deleteShipmentForm').attr('action', dataRoute);
			});

			$(document).on('click', '.restoreShipment', function () {
				let dataRoute = $(this).data('route');
				$('#restoreShipmentForm').attr('action', dataRoute);
			});

			$(document).on('click', '.forceDeleteShipment', function () {
				let dataRoute = $(this).data('route');
				$('#forceDeleteShipmentForm').attr('action', dataRoute);
			});
		})
	</script>

	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif
@endsection

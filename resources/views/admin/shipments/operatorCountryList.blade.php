@extends('admin.layouts.master')
@section('page_title', __('All Shipment List'))
@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Shipment List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Shipment List')</div>
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
											@include('partials.shipmentSearchForm')
										</div>
									</div>
								</div>
							</div>

							<div class="row justify-content-md-center">
								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Shipment List')</h6>
											@if(adminAccessRoute(config('permissionList.Manage_Shipments.Shipment_List.permission.add')))
												@if($authenticateUser->branch != null || $authenticateUser->role_id == null)
													<a href="{{route('createShipment', ['shipment_type' => 'operator-country', 'shipment_status' => $status])}}"
													   class="btn btn-sm btn-outline-primary add"><i
															class="fas fa-plus-circle"></i> @lang('Create Shipment')</a>
												@endif
											@endif
										</div>

										<div class="card-body">
											<div class="switcher">
												<a href="{{ route('shipmentList', ['shipment_status' => $status, 'shipment_type' => 'operator-country']) }}">
													<button
														class="custom-text @if(lastUriSegment() == 'operator-country') active @endif">@lang(optional(basicControl()->operatorCountry)->name)</button>
												</a>
												<a href="{{ route('shipmentList', ['shipment_status' => $status, 'shipment_type' => 'internationally']) }}">
													<button
														class="custom-text @if(lastUriSegment() == 'internationally') active @endif">@lang('Internationally')</button>
												</a>
											</div>

											{{-- Table --}}
											<div class="row justify-content-md-center mt-4">
												<div class="col-lg-12">
													<div class="card mb-4 card-primary shadow">
														<div
															class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
															<h6 class="m-0 font-weight-bold text-primary">@lang(optional(basicControl()->operatorCountry)->name. " All Shipment List")</h6>
														</div>

														<div class="card-body">
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
																	@forelse($allShipments as $key => $shipment)

																		<tr>
																			<td data-label="SL."> {{ ++$key }} </td>
																			<td data-label="Shipment Id"> {{ $shipment->shipment_id }} </td>
																			<td data-label="Shipment Type"> {{ formatedShipmentType($shipment->shipment_type) }} </td>
																			<td data-label="Sender Branch"> @lang(optional($shipment->senderBranch)->branch_name) </td>
																			<td data-label="Receiver Branch"> @lang(optional($shipment->receiverBranch)->branch_name) </td>
																			<td data-label="From State"> @lang(optional($shipment->fromState)->name) </td>
																			<td data-label="To State"> @lang(optional($shipment->toState)->name) </td>
																			<td data-label="Total Cost"> {{ $basic->currency_symbol }}{{ $shipment->total_pay }} </td>

																			<td data-label="Shipment Date"> {{ customDate($shipment->shipment_date) }} </td>

																			<td data-label="Status">
																				@if(($shipment->status == 0) || ($shipment->status == 5 && $shipment->assign_to_collect != null))
																					<span
																						class="badge badge-dark rounded">@lang('Requested')</span>
																				@elseif($shipment->status == 6)
																					<span
																						class="badge badge-danger rounded">@lang('Canceled')</span>
																				@elseif($shipment->status == 1)
																					<span
																						class="badge badge-info rounded">@lang('In Queue')</span>
																					{{--																					optional(auth()->guard('admin')->user()->branch)->branch_id--}}
																				@elseif($shipment->status == 2 && $status == 'dispatch')
																					<span
																						class="badge badge-warning rounded">@lang('Dispatch')</span>
																				@elseif($shipment->status == 2 && $status == 'upcoming')
																					<span
																						class="badge badge-primary rounded">@lang('Upcoming')</span>
																				@elseif(($shipment->status == 3) || ($shipment->status == 7 && $shipment->assign_to_delivery != null))
																					<span
																						class="badge badge-success rounded">@lang('Received')</span>
																				@elseif($shipment->status == 4)
																					<span
																						class="badge badge-danger rounded">@lang('Delivered')</span>
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
																						@if($shipment->status == 1 && $status == 'in_queue' && optional(optional($shipment->senderBranch)->branchManager)->admin_id == $authenticateUser->id)
																							@if(adminAccessRoute(config('permissionList.Manage_Shipments.Shipment_List.permission.dispatch')))
																								<a data-target="#updateShipmentStatus"
																								   data-toggle="modal"
																								   data-status="{{ $status }}"
																								   data-route="{{route('updateShipmentStatus', ['id' => $shipment->id, 'type' => 'dispatch'])}}"
																								   href="javascript:void(0)"
																								   class="dropdown-item btn-outline-primary btn-sm editShipmentStatus"><i
																										class="fas fa-file-invoice mr-2"></i> @lang('Dispatch')
																								</a>
																							@endif
																						@elseif($shipment->status == 2 && $status == 'upcoming')
																							<a data-target="#updateShipmentStatus"
																							   data-toggle="modal"
																							   data-status="{{ $status }}"
																							   data-route="{{route('updateShipmentStatus', ['id' => $shipment->id, 'type' => 'received'])}}"
																							   href="javascript:void(0)"
																							   class="dropdown-item btn-outline-primary btn-sm editShipmentStatus">
																								<i class="far fa-handshake mr-2"></i> @lang('Received')
																							</a>

																						@elseif(($shipment->status == 3 || $shipment->status == 7) && ($status == 'received' || $status == 'assign_to_delivery') && (optional(optional($shipment->receiverBranch)->branchManager)->admin_id == $authenticateUser->id || optional($shipment->assignToDelivery)->id == $authenticateUser->id))
																							<a data-target="#updateShipmentStatus"
																							   data-toggle="modal"
																							   data-status="{{ $status }}"
																							   data-route="{{route('updateShipmentStatus', ['id' => $shipment->id, 'type' => 'delivered'])}}"
																							   href="javascript:void(0)"
																							   class="dropdown-item btn-outline-primary btn-sm editShipmentStatus">
																								<i class="fas fa-thumbs-up mr-2"></i> @lang('Delivered')
																							</a>

																							<a data-target="#assignToDeliveredShipmentRequest"
																							   data-toggle="modal"
																							   data-route="{{route('assignToDeliveredShipmentRequest', $shipment->id)}}"
																							   data-property="{{ $shipment }}"
																							   href="javascript:void(0)"
																							   class="dropdown-item btn-outline-primary btn-sm assignToDeliveredShipmentRequest"><i
																									class="fas fa-check"></i> @lang('Assign To Delivery')
																							</a>

																						@endif

																						{{--																						<a class="dropdown-item btn-outline-primary btn-sm"--}}
																						{{--																						   href="#"><i--}}
																						{{--																								class="fas fa-file-invoice mr-2"></i> @lang('Invoice')--}}
																						{{--																						</a>--}}

																						<a class="dropdown-item btn-outline-primary btn-sm"
																						   href="{{ route('viewShipment', ['id' => $shipment->id, 'segment' => $status, 'shipment_type' => 'operator-country']) }}"><i
																								class="fa fa-eye mr-2"
																								aria-hidden="true"></i> @lang('Details')
																						</a>

																						@if(adminAccessRoute(config('permissionList.Manage_Shipments.Shipment_List.permission.edit')))
																							@if(($shipment->status == 0 || $shipment->status == 1 || $shipment->status == 5) && (optional(optional($shipment->senderBranch)->branchManager)->admin_id == $authenticateUser->id || optional(optional($shipment->receiverBranch)->branchManager)->admin_id == $authenticateUser->id || optional($shipment->assignToCollect)->id == $authenticateUser->id) || ($shipment->status == 3 && $shipment->payment_status == 2))
																								<a class="dropdown-item btn-outline-primary btn-sm"
																								   href="{{ route('editShipment', ['id' => $shipment->id, 'shipment_identifier' => $shipment->shipment_identifier, 'segment' => $status, 'shipment_type' => 'operator-country']) }}"><i
																										class="fa fa-edit mr-2"
																										aria-hidden="true"></i> @lang('Edit')
																								</a>
																							@endif
																						@endif

																						@if($shipment->status == 0 || $shipment->status == 5)
																							<a data-target="#acceptShipmentRequest"
																							   data-toggle="modal"
																							   data-route="{{route('acceptShipmentRequest', $shipment->id)}}"
																							   href="javascript:void(0)"
																							   class="dropdown-item btn-outline-primary btn-sm acceptShipmentRequest"><i
																									class="fas fa-check"></i> @lang('Accept Request')
																							</a>

																							<a data-target="#cancelShipmentRequest"
																							   data-toggle="modal"
																							   data-route="{{route('cancelShipmentRequest', $shipment->id)}}"
																							   data-property="{{ $shipment }}"
																							   href="javascript:void(0)"
																							   class="dropdown-item btn-outline-primary btn-sm cancelShipmentRequest"><i
																									class="fas fa-ban"></i> @lang('Cancel Request')
																							</a>
																							@if($shipment->shipment_type == 'pickup' && $shipment->status == 0)
																								<a data-target="#assignToCollectShipmentRequest"
																								   data-toggle="modal"
																								   data-route="{{route('assignToCollectShipmentRequest', $shipment->id)}}"
																								   data-property="{{ $shipment }}"
																								   href="javascript:void(0)"
																								   class="dropdown-item btn-outline-primary btn-sm assignToCollectShipmentRequest"><i
																										class="fas fa-check"></i> @lang('Assign To Collect')
																								</a>
																							@endif
																						@endif

																						@if(adminAccessRoute(config('permissionList.Manage_Shipments.Shipment_List.permission.delete')))
																							@if(($shipment->status == 6 && $shipment->shipment_cancel_time != null && $shipment->refund_time == null) || $shipment->status == 4)
																								<a data-target="#deleteShipment"
																								   data-toggle="modal"
																								   data-route="{{route('deleteShipment', $shipment->id)}}"
																								   href="javascript:void(0)"
																								   class="dropdown-item btn-outline-primary btn-sm deleteShipment"><i
																										class="fas fa-trash mr-2"></i> @lang('Delete')
																								</a>
																								{{--																							@elseif($shipment->status == 5 && $shipment->shipment_cancel_time == null && $shipment->refund_time == null)--}}
																								{{--																								<a data-target="#deleteShipment"--}}
																								{{--																								   data-toggle="modal"--}}
																								{{--																								   data-route="{{route('deleteShipment', $shipment->id)}}"--}}
																								{{--																								   href="javascript:void(0)"--}}
																								{{--																								   class="dropdown-item btn-outline-primary btn-sm deleteShipment"><i--}}
																								{{--																										class="fas fa-trash mr-2"></i> @lang('Delete')--}}
																								{{--																								</a>--}}
																							@endif
																						@endif

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
																class="card-footer d-flex justify-content-center">{{ $allShipments->links() }}</div>
														</div>
														`
													</div>
												</div>
											</div>
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

	{{-- shipment status update modal --}}
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
						<p class="shipmentStatusChangeMessage"></p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Assign To Collect Shipment Request Modal --}}
	<div id="assignToCollectShipmentRequest" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Assign Confirmation')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="assignToCollectShipmentRequestForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<div class="row mb-3">
							<div class="col-sm-12 col-md-12 mb-3">
								<label for="branch_driver_id"> @lang('Select Driver') <span class="text-danger">*</span></label>
								<select name="branch_driver_id"
										class="form-control @error('branch_driver_id') is-invalid @enderror select2 senderBranchDriver"
										id="branchDriver">
								</select>

								<div class="invalid-feedback">
									@error('branch_driver_id') @lang($message) @enderror
								</div>
								<div class="valid-feedback"></div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Assign')</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	{{-- Assign To Delivered Shipment Request Modal --}}
	<div id="assignToDeliveredShipmentRequest" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Assign Confirmation')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="assignToDeliveredShipmentRequestForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<div class="row mb-3">
							<div class="col-sm-12 col-md-12 mb-3">
								<label for="branch_driver_id"> @lang('Select Driver') <span class="text-danger">*</span></label>
								<select name="branch_driver_id"
										class="form-control @error('branch_driver_id') is-invalid @enderror select2 receiverBranchDriver"
										id="branchDriver">
								</select>

								<div class="invalid-feedback">
									@error('branch_driver_id') @lang($message) @enderror
								</div>
								<div class="valid-feedback"></div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Assign')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Accept Shipment Request Modal --}}
	<div id="acceptShipmentRequest" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Confirmation')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="acceptShipmentRequestForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<p>@lang('Are you sure to accept this shipment?')</p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
						<button type="submit" class="btn btn-primary">@lang('Yes')</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	{{-- Cancel Shipment Request Modal --}}
	<div id="cancelShipmentRequest" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Confirmation')</h4>
					<button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="cancelShipmentRequestForm">
					@csrf
					@method('put')
					<div class="modal-body">
						<div class="mb-5">
							<p>@lang('Are you sure to cancel this shipment request?')</p>
						</div>
						<div class="shipment-refund-alert"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-dark modal-close" data-dismiss="modal">@lang('No')</button>
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

@endsection

@section('scripts')
	<script>
		'use strict'
		$(document).on('click', '.cancelShipmentRequest', function () {
			let dataRoute = $(this).data('route');
			$('#cancelShipmentRequestForm').attr('action', dataRoute);
			let basicControl = @json(basicControl());
			let refundTimeArray = basicControl.refund_time.split("_");
			let refundTime = refundTimeArray[0];
			let refundTimeType = refundTimeArray[1];
			let dataProperty = $(this).data('property');
			let paymentType = dataProperty.payment_type;
			let paymentStatus = dataProperty.payment_status;

			if (paymentType == 'wallet' && paymentStatus == 1) {
				$('.shipment-refund-alert').html(`
						<div class="bd-callout bd-callout-warning">
							<i class="fas fa-info-circle mr-2"></i>
							N.B: You will get a refund ${refundTime} ${refundTimeType} after canceling your shipment request. Refund charges will be deducted.
						</div>
					`);
			}
		});

		$(document).on('click', '.modal-close', function () {
			$('.shipment-refund-alert').html('');
		});

		$(document).ready(function () {
			$(document).on('click', '.editShipmentStatus', function () {
				let dataRoute = $(this).data('route');
				console.log(dataRoute);
				let dataStatus = $(this).data('status');
				if (dataStatus == 'in_queue') {
					$('.shipmentStatusChangeMessage').text('Are you sure to dispatch this shipment?')
				} else if (dataStatus == 'upcoming') {
					$('.shipmentStatusChangeMessage').text('Are you sure to received this shipment?')
				} else if (dataStatus == 'received') {
					$('.shipmentStatusChangeMessage').text('Are you sure to delivered this shipment?')
				}else if (dataStatus == 'assign_to_delivery') {
					$('.shipmentStatusChangeMessage').text('Are you sure to delivered this shipment?')
				}
				$('#editShipmentStatusForm').attr('action', dataRoute);
			});

			$(document).on('click', '.assignToCollectShipmentRequest', function () {
				let dataRoute = $(this).data('route');
				$('#assignToCollectShipmentRequestForm').attr('action', dataRoute);

				let dataPropertry = $(this).data('property');
				let branchDriver = dataPropertry.sender_branch.branch_driver;

				branchDriver.forEach(res => {
					$('.senderBranchDriver').append(`<option value="${res.admin_id}">${res.admin.name}</option>`)
				})
			});

			$(document).on('click', '.assignToDeliveredShipmentRequest', function () {
				let dataRoute = $(this).data('route');
				$('#assignToDeliveredShipmentRequestForm').attr('action', dataRoute);

				let dataPropertry = $(this).data('property');
				let branchDriver = dataPropertry.receiver_branch.branch_driver;

				branchDriver.forEach(res => {
					$('.receiverBranchDriver').append(`<option value="${res.admin_id}">${res.admin.name}</option>`)
				})
			});

			$(document).on('click', '.acceptShipmentRequest', function () {
				let dataRoute = $(this).data('route');
				$('#acceptShipmentRequestForm').attr('action', dataRoute);
			});


			$(document).on('click', '.deleteShipment', function () {
				let dataRoute = $(this).data('route');
				$('#deleteShipmentForm').attr('action', dataRoute);
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

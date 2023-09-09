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
											<a href="{{route('createShipment', ['shipment_type' => 'internationally', 'shipment_status' => $status])}}"
											   class="btn btn-sm btn-outline-primary add"><i
													class="fas fa-plus-circle"></i> @lang('Create Shipment')</a>
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
															<h6 class="m-0 font-weight-bold text-primary">@lang("Internationally All Shipment List")</h6>
														</div>

														<div class="card-body">
															<div class="table-responsive">
																<table
																	class="table table-striped table-hover align-items-center table-flush"
																	id="data-table">
																	<thead class="thead-light">
																	<tr>
																		<th scope="col">@lang('SL.')</th>
																		<th scope="col">@lang('Shipment Id')</th>
																		<th scope="col">@lang('Shipment Type')</th>
																		<th scope="col">@lang('Sender Branch')</th>
																		<th scope="col">@lang('Receiver Branch')</th>
																		<th scope="col">@lang('From Country')</th>
																		<th scope="col">@lang('To Country')</th>
																		<th scope="col">@lang('Total Cost')</th>
																		<th scope="col">@lang('Shipment Date')</th>
																		<th scope="col">@lang('Status')</th>
																		<th scope="col">@lang('Action')</th>
																	</tr>
																	</thead>

																	<tbody>
																	@forelse($allShipments as $key => $shipment)
																		<tr>
																			<td data-label="SL."> {{ ++$key }} </td>
																			<td data-label="Shipment Id"> {{ $shipment->shipment_id }} </td>
																			<td data-label="Shipment Type"> {{ $shipment->shipment_type }} </td>
																			<td data-label="Sender Branch"> @lang(optional($shipment->senderBranch)->branch_name) </td>
																			<td data-label="Receiver Branch"> @lang(optional($shipment->receiverBranch)->branch_name) </td>
																			<td data-label="From Country"> @lang(optional($shipment->fromCountry)->name) </td>
																			<td data-label="To Country"> @lang(optional($shipment->toCountry)->name) </td>
																			<td data-label="Total Cost"> {{ $basic->currency_symbol }}{{ $shipment->total_pay }} </td>

																			<td data-label="Shipment Date"> {{ dateTime($shipment->shipment_date) }} </td>

																			<td data-label="Status">
																				@if($shipment->status == 1)
																					<span class="badge badge-info">@lang('In Queue')</span>
																				@elseif($shipment->status == 2)
																					<span class="badge badge-warning">@lang('Dispatch')</span>
																				@elseif($shipment->status == 3)
																					<span class="badge badge-primary">@lang('Upcoming')</span>
																				@elseif($shipment->status == 4)
																					<span class="badge badge-success">@lang('Received')</span>
																				@elseif($shipment->status == 5)
																					<span class="badge badge-danger">@lang('Delivered')</span>
																				@endif
																			</td>

																			<td data-label="@lang('Action')">
																				<div class="btn-group">
																					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																						Options
																					</button>
																					<div class="dropdown-menu">
																						<a class="dropdown-item btn-outline-primary btn-sm" href="#"><i class="fas fa-file-invoice mr-2"></i>  @lang('Invoice')</a>
																						<a class="dropdown-item btn-outline-primary btn-sm"
																						   href="{{ route('viewShipment', ['id' => $shipment->id, 'segment' => $status, 'shipment_type' => 'internationally']) }}"><i
																								class="fa fa-eye mr-2"
																								aria-hidden="true"></i> @lang('Details')
																						</a>
																						<a class="dropdown-item btn-outline-primary btn-sm" href="{{ route('editShipment', ['id' => $shipment->id, 'shipment_identifier' => $shipment->shipment_identifier, 'segment' => $status, 'shipment_type' => 'internationally']) }}"><i class="fa fa-edit mr-2" aria-hidden="true"></i>  @lang('Edit')</a>
																						<a data-target="#deleteShipment"
																						   data-toggle="modal"
																						   data-route="{{route('deleteShipment', $shipment->id)}}"
																						   href="javascript:void(0)"
																						   class="dropdown-item btn-outline-primary btn-sm deleteShipment"><i
																								class="fas fa-trash mr-2"></i> @lang('Delete')
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
															<div class="card-footer d-flex justify-content-center">{{ $allShipments->links() }}</div>
														</div>

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

@endsection

@section('scripts')
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

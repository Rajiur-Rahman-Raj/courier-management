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
											<form action="" method="get">
												<div class="row">
													<div class="col-md-2">
														<div class="form-group">
															<input placeholder="@lang('Branch name')" name="name"
																   value="{{ old('name',request()->name) }}" type="text"
																   class="form-control form-control-sm">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<input placeholder="@lang('Phone')" name="phone"
																   value="{{ old('phone',request()->phone) }}"
																   type="text" class="form-control form-control-sm">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<input placeholder="@lang('E-mail')" name="email"
																   value="{{ old('email',request()->email) }}"
																   type="text" class="form-control form-control-sm">
														</div>
													</div>

													<div class="col-md-2">
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

													<div class="col-md-2">
														<div class="form-group search-currency-dropdown">
															<select name="branch_type"
																	class="form-control form-control-sm">
																<option value="">@lang('All Branch')</option>
																<option
																	value="head_office" {{  request()->branch_type == 'head_office' ? 'selected' : '' }}>@lang('Head Office')</option>
																<option
																	value="main_branch" {{  request()->branch_type == 'main_branch' ? 'selected' : '' }}>@lang('Main Branch')</option>
																<option
																	value="sub_branch" {{  request()->branch_type == 'sub_branch' ? 'selected' : '' }}>@lang('Sub Branch')</option>
															</select>
														</div>
													</div>

													<div class="col-md-2">
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
											<h6 class="m-0 font-weight-bold text-primary">@lang('Shipment List')</h6>
											<a href="{{route('createShipment', 'operator-country')}}"
											   class="btn btn-sm btn-outline-primary add"><i
													class="fas fa-plus-circle"></i> @lang('Create Shipment')</a>
										</div>

										<div class="card-body">
											<div class="switcher">
												<a href="{{ route('shipmentList', 'operator-country') }}">
													<button
														class="@if(lastUriSegment() == 'operator-country') active @endif">@lang(optional(basicControl()->operatorCountry)->name)</button>
												</a>
												<a href="{{ route('shipmentList', 'internationally') }}">
													<button
														class="@if(lastUriSegment() == 'internationally') active @endif">@lang('Internationally')</button>
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
																		<th scope="col">@lang('SL.')</th>
																		<th scope="col">@lang('Shipment Id')</th>
																		<th scope="col">@lang('Shipment Type')</th>
																		<th scope="col">@lang('Sender Branch')</th>
																		<th scope="col">@lang('Receiver Branch')</th>
																		<th scope="col">@lang('From State')</th>
																		<th scope="col">@lang('To State')</th>
																		<th scope="col">@lang('Total Cost')</th>
																		<th scope="col">@lang('Payment Status')</th>
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
																			<td data-label="From State"> @lang(optional($shipment->fromState)->name) </td>
																			<td data-label="To State"> @lang(optional($shipment->toState)->name) </td>
																			<td data-label="Total Cost"> {{ $shipment->total_pay }} </td>
																			<td data-label="Payment Status">
																				@if($shipment->payment_status == 1)
																					<span class="badge badge-primary"><i class="fa fa-circle text-white danger font-12"></i> @lang('Paid')</span>
																				@else
																					<span class="badge badge-warning"><i class="fa fa-circle text-white danger font-12"></i> @lang('Due')</span>
																				@endif
																			</td>
																			<td data-label="Shipment Date"> {{ dateTime($shipment->shipment_date) }} </td>

																			<td data-label="Status">
																				@if($shipment->payment_status == 1)
																					<span class="badge badge-success"><i class="fa fa-circle text-white danger font-12"></i> @lang('Active')</span>
																				@else
																					<span class="badge badge-danger"><i class="fa fa-circle text-white danger font-12"></i> @lang('Deactive')</span>
																				@endif
																			</td>

																			<td data-label="@lang('Action')">
																				<a href="{{ route('editShipment', $shipment->id) }}"
																				   class="btn btn-outline-primary btn-sm"
																				   title="@lang('Edit Shipment')"><i
																						class="fa fa-eye"
																						aria-hidden="true"></i> @lang('Edit')
																				</a>
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

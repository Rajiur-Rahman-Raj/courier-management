@extends('admin.layouts.master')
@section('page_title', __('View Shipment'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Shipment Details')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">
						<a href="{{ route('admin.home') }}">@lang('Shipment List')</a>
					</div>
					<div class="breadcrumb-item">@lang('Details')</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body shadow">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title">@lang("Shipment Details")</h4>

								<div>
									<a href="{{route('shipmentList', 'operator-country')}}"
									   class="btn btn-sm  btn-primary mr-2">
										<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
									</a>
									<button
										data-target="#confirmModal" data-toggle="modal"
										data-route="#"
										class="btn btn-success btn-sm confirmButton"><i
											class="far fa-check-circle"></i> @lang('Pay Bill')
									</button>
									<button
										data-toggle="modal"
										data-target="#confirmModal"
										data-route="#"
										class="btn btn-danger btn-sm returnButton"><i
											class="fas fa-times-circle"></i> @lang('Return Bill')
									</button>
								</div>
							</div>
							<hr>
							<div class="p-4 card-body shadow">
								<div class="row">
									<div class="col-md-6 border-right">
										<ul class="list-style-none shipment-view-ul">
											<li class="my-2 border-bottom-2 pb-3">
												<span class="font-weight-medium text-dark custom-text"> <i
														class="fas fa-fingerprint mr-2 text-orange "></i> @lang("Shipment Id"): <small
														class="float-right custom-text"> #{{ $singleShipment->shipment_id }} </small></span>

											</li>

											<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-shipping-fast mr-2 text-primary"></i> @lang("Shipment Type") : <span
													class="font-weight-medium">@lang($singleShipment->shipmentTypeFormat())</span></span>
											</li>

											<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="far fa-calendar-alt mr-2 text-success"></i> @lang("Shipment Date") : <span
													class="font-weight-medium">{{ customDate($singleShipment->shipment_date) }}</span></span>
											</li>

											<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="far fa-calendar-alt mr-2 text-purple"></i> @lang("Estimate Delivery Date") : <span
													class="font-weight-medium">{{ customDate($singleShipment->delivery_date) }}</span></span>
											</li>

											<li class="my-3 d-flex align-items-center">
												<span class="font-weight-bold text-dark"><i class="fas fa-user-plus mr-2 text-primary"></i> @lang('Sender :')</span>

												<a class="ml-3 text-decoration-none"
												   href="{{ route('user.edit',optional($singleShipment->sender)->id) }}">
													<div class="d-lg-flex d-block align-items-center">
														<div class="mr-2"><img
																src="{{ getFile(optional($singleShipment->sender->profile)->driver,optional($singleShipment->sender->profile)->profile_picture) }}"
																alt="user" class="rounded-circle" width="45"
																height="45"></div>
														<div class="">
															<h6 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($singleShipment->sender)->name)</h6>
															<p class="text-muted mb-0 font-12 font-weight-normal">@lang(optional($singleShipment->sender)->email)</p>
														</div>
													</div>
												</a>
											</li>

											<li class="my-3 d-flex align-items-center">
												<span class="font-weight-bold text-dark"> <i class="fas fa-user-minus mr-2 text-orange "></i> @lang('Receiver :')</span>

												<a class="ml-3 text-decoration-none"
												   href="{{ route('user.edit',optional($singleShipment->receiver)->id) }}">
													<div class="d-lg-flex d-block align-items-center">
														<div class="mr-2"><img
																src="{{ getFile(optional($singleShipment->receiver->profile)->driver,optional($singleShipment->receiver->profile)->profile_picture) }}"
																alt="user" class="rounded-circle" width="45"
																height="45"></div>
														<div class="">
															<h6 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($singleShipment->receiver)->name)</h6>
															<p class="text-muted mb-0 font-12 font-weight-medium">@lang(optional($singleShipment->receiver)->email)</p>
														</div>
													</div>
												</a>
											</li>

											@if($singleShipment->shipment_type == 'condition')
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i
													class="fas fa-check-circle mr-2 text-primary"></i> @lang("Receive Amount") : <span
													class="font-weight-medium">{{ $basic->currency_symbol }}{{ $singleShipment->receive_amount }}</span></span>
												</li>
											@endif

											<li class="my-3 d-flex align-items-center">
												<span class="font-weight-bold text-dark"> <i class="fas fa-tree mr-2 text-purple"></i> @lang('Sender Branch') : </span>

												<a class="ml-3 text-decoration-none"
												   href="{{ route('branchEdit', optional($singleShipment->senderBranch)->id) }}">
													<div class="d-lg-flex d-block align-items-center">
														<div class="mr-2"><img
																src="{{getFile(optional($singleShipment->senderBranch)->driver,optional($singleShipment->senderBranch)->image) }}"
																alt="user" class="rounded-circle" width="45"
																height="45"></div>
														<div class="">
															<h6 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($singleShipment->senderBranch)->branch_name)</h6>
															<p class="text-muted mb-0 font-12 font-weight-medium">@lang(optional($singleShipment->senderBranch)->email)</p>
														</div>
													</div>
												</a>
											</li>

											<li class="my-3 d-flex align-items-center">
												<span class="font-weight-bold text-dark"> <i class="fas fa-tree mr-2 text-info"></i> @lang('Receiver Branch') : </span>

												<a class="ml-3 text-decoration-none"
												   href="{{ route('branchEdit', optional($singleShipment->receiverBranch)->id) }}">
													<div class="d-lg-flex d-block align-items-center">
														<div class="mr-2"><img
																src="{{getFile(optional($singleShipment->receiverBranch)->driver,optional($singleShipment->receiverBranch)->image) }}"
																alt="user" class="rounded-circle" width="45"
																height="45"></div>
														<div class="">
															<h6 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($singleShipment->receiverBranch)->branch_name)</h6>
															<p class="text-muted mb-0 font-12 font-weight-medium">@lang(optional($singleShipment->receiverBranch)->email)</p>
														</div>
													</div>
												</a>
											</li>


											@if($singleShipment->from_country_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"> <i class="fas fa-map-marker-alt mr-2 text-primary"></i> @lang("From Country") : <span
													class="font-weight-medium">@lang(optional($singleShipment->fromCountry)->name)</span></span>
												</li>
											@endif

											@if($singleShipment->from_state_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-map-marker-alt mr-2 text-primary"></i> @lang("From State") : <span
													class="font-weight-medium">@lang(optional($singleShipment->fromState)->name)</span></span>
												</li>
											@endif

											@if($singleShipment->from_city_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-map-marker-alt mr-2 text-danger"></i> @lang("From City") : <span
													class="font-weight-medium">@lang(optional($singleShipment->fromCity)->name)</span></span>
												</li>
											@endif

											@if($singleShipment->from_area_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-map-marker-alt mr-2 text-success"></i> @lang("From Area") : <span
													class="font-weight-medium">@lang(optional($singleShipment->fromArea)->name)</span></span>
												</li>
											@endif

											@if($singleShipment->to_country_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-map-marker-alt mr-2 text-cyan"></i> @lang("To Country") : <span
													class="font-weight-medium">@lang(optional($singleShipment->toCountry)->name)</span></span>
												</li>
											@endif

											@if($singleShipment->to_state_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-map-marker-alt mr-2 text-success "></i> @lang("To State") : <span
													class="font-weight-medium">@lang(optional($singleShipment->toState)->name)</span></span>
												</li>
											@endif

											@if($singleShipment->to_city_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-map-marker mr-2 text-purple"></i> @lang("To City") : <span
													class="font-weight-medium">@lang(optional($singleShipment->toCity)->name)</span></span>
												</li>
											@endif

											@if($singleShipment->to_area_id != null)
												<li class="my-3">
                                            <span class="font-weight-bold text-dark"> <i class="fas fa-location-arrow mr-2 text-primary"></i> @lang("To Area") : <span
													class="font-weight-medium text-dark">@lang(optional($singleShipment->toArea)->name)</span></span>
												</li>
											@endif

											<li class="my-3">
                                            <span class="font-weight-bold text-dark">  <i class="fas fa-search-dollar  mr-2 text-orange"></i> @lang("Payment Type") : <span
													class="font-weight-medium text-dark">@lang($singleShipment->payment_type)</span></span>
											</li>

											<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-money-check-alt  mr-2 text-primary"></i> @lang('Payment Status') :
                                                @if($singleShipment->payment_status == 1)
													<p class="badge badge-success">@lang('Paid')</p>
												@else
													<p class="badge badge-warning">@lang('Unpaid')</p>
												@endif
                                            </span>
											</li>

											<li class="my-3">
                                            <span class="font-weight-bold text-dark"><i class="fas fa-shipping-fast mr-2 text-warning"></i> @lang('Shipment Status') :
                                                @if($singleShipment->status == 1)
													<p class="badge badge-warning">@lang('Active')</p>
												@else
													<p class="badge badge-danger">@lang('Deactive')</p>
												@endif
                                            </span>
											</li>
										</ul>
									</div>


									<div class="col-md-6 ">
										<ul class="list-style-none shipment-view-ul">

											<li class="my-2 border-bottom-2 pb-3">
												<span class="font-weight-bold text-dark"> <i class="fas fa-cart-plus mr-2 text-primary"></i> @lang('Parcel Information')</span>
											</li>

											@if($singleShipment->packing_services != null)
												<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-check-circle mr-2 text-success"></i>  @lang('Packing Service')

                                            </span>
												</li>

												<table class="table table-bordered">
													<thead>
													<tr>
														<th scope="col">@lang('Package')</th>
														<th scope="col">@lang('Variant')</th>
														<th scope="col">@lang('Price')</th>
														<th scope="col">@lang('Quantity')</th>
														<th scope="col">@lang('Cost')</th>
													</tr>
													</thead>
													<tbody>
													@php
														$totalPackingCost = 0;
													@endphp
													@foreach($singleShipment->packing_services as $packing_service)

														<tr>
															<td>{{ $singleShipment->packageName($packing_service['package_id'])  }}</td>
															<td>{{ $singleShipment->variantName($packing_service['variant_id']) }}</td>
															<td>{{ $basic->currency_symbol }}{{ $packing_service['variant_price'] }}</td>
															<td>{{ $packing_service['variant_quantity'] }}</td>
															<td>{{ $basic->currency_symbol }}{{ $packing_service['package_cost'] }}</td>
															@php
																$totalPackingCost += $packing_service['package_cost'];
															@endphp
														</tr>
													@endforeach

													<tr>
														<th colspan="4" class="text-right">@lang('Total Price')</th>
														<td>{{ $basic->currency_symbol }}{{ number_format($totalPackingCost, 2) }}</td>
													</tr>
													</tbody>
												</table>
											@endif

											@if($singleShipment->parcel_information != null)
												<li class="my-3">
                                            		<span class="custom-text"><i class="fas fa-check-circle mr-2 text-success"></i>  @lang('Parcel Details')</span>
												</li>

												<table class="table table-bordered">
													<thead>
													<tr>
														<th scope="col">@lang('Parcel Name')</th>
														<th scope="col">@lang('Quantity')</th>
														<th scope="col">@lang('Parcel Type')</th>
														<th scope="col">@lang('Total Unit')</th>
														<th scope="col">@lang('Cost')</th>
													</tr>
													</thead>
													<tbody>
													@php
														$totalParcelCost = 0;
													@endphp
													@foreach($singleShipment->parcel_information as $parcel_information)
														<tr>
															<td>{{ $parcel_information['parcel_name'] }}</td>
															<td>{{ $parcel_information['parcel_quantity'] }}</td>
															<td>{{ $singleShipment->parcelType($parcel_information['parcel_type_id'])  }}</td>
															<td>{{ $parcel_information['total_unit'] }} <span class="">{{ $singleShipment->parcelUnit($parcel_information['parcel_unit_id']) }}</span></td>
															<td>{{ $basic->currency_symbol }}{{ $parcel_information['parcel_total_cost'] }}</td>
															@php
																$totalParcelCost += $parcel_information['parcel_total_cost'];
															@endphp
														</tr>
													@endforeach

													<tr>
														<th colspan="4" class="text-right">@lang('Total Price')</th>
														<td>{{ $basic->currency_symbol }}{{ number_format($totalParcelCost, 2) }}</td>
													</tr>
													</tbody>
												</table>
											@else
												<li class="my-3">
													<span class="custom-text"><i class="fas fa-check-circle mr-2 text-success"></i>  @lang('Parcel Details')</span>
												</li>
												<table class="table table-bordered mb-5">
													<tbody>
														<tr>
															<td>@lang($singleShipment->parcel_details)</td>
														</tr>
													</tbody>
												</table>
											@endif

											<li class="my-2 border-bottom-2 pb-3">
												<span class="font-weight-bold text-dark"> <i
														class="fas fa-credit-card mr-2 text-primary"></i> @lang('Payment Calculation')</span>
											</li>

											<li class="my-3 ">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-warning"></i>  @lang('Discount') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->discount_amount)</span>

                                            </span>
											</li>

											<li class="my-3">
                                            <span class="custom-text"> <i class="fas fa-dollar-sign mr-2 text-primary"></i> @lang('Sub Total') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->sub_total)</span>

                                            </span>
											</li>
											@if($singleShipment->shipment_type == 'pickup')
												<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-success"></i>  @lang('Pickup Cost') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->pickup_cost)</span>

                                            </span>
												</li>

												<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-danger"></i>  @lang('Supply Cost') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->supply_cost)</span>

                                            </span>
												</li>
											@endif

											<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-purple"></i>  @lang('Shipping Cost') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->shipping_cost)</span>

                                            </span>
											</li>

											<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-orange"></i>  @lang('Tax') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->tax)</span>

                                            </span>
											</li>

											<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-info"></i>  @lang('Insurance') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->insurance)</span>

                                            </span>
											</li>

											<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-primary"></i>  @lang('Payable Amount') :
												<span
													class="custom-text text-warning">{{ $basic->currency_symbol }}@lang($singleShipment->total_pay)</span>
                                            </span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-white bg-primary">
					<h5 class="modal-title" id="exampleModalLabel"><i
							class="fas fa-info-circle"></i> @lang('Confirmation !')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="" method="post" id="confirmForm">
					@csrf
					<div class="modal-body text-center">
						<p>@lang('Are you sure you want to confirm this action?')</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-dark"
								data-dismiss="modal">@lang('Close')</button>
						<input type="submit" class="btn btn-primary" value="@lang('Confirm')">
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		'use strict'
		$(document).on('click', '.confirmButton,.returnButton', function () {
			let submitUrl = $(this).data('route');
			$('#confirmForm').attr('action', submitUrl)
		})
	</script>
@endsection





{{--@extends('admin.layouts.master')--}}
{{--@section('page_title', __('View Shipment'))--}}
{{--@section('content')--}}
{{--	<div class="main-content">--}}
{{--		<section class="section">--}}
{{--			<div class="section-header">--}}
{{--				<h1>@lang('Shipment Details')</h1>--}}
{{--				<div class="section-header-breadcrumb">--}}
{{--					<div class="breadcrumb-item active">--}}
{{--						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>--}}
{{--					</div>--}}
{{--					<div class="breadcrumb-item">--}}
{{--						<a href="{{ route('admin.home') }}">@lang('Shipment List')</a>--}}
{{--					</div>--}}
{{--					<div class="breadcrumb-item">@lang('Details')</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="row mb-3">--}}
{{--				<div class="container-fluid user-profile" id="container-wrapper">--}}
{{--					<div class="row justify-content-md-center">--}}
{{--						<div class="col-lg-8">--}}
{{--							<div class="card mb-4 card-primary shadow">--}}
{{--								<div class="card-body">--}}
{{--									<div class="d-flex justify-content-end">--}}
{{--										<a href="{{route('shipmentList', 'operator-country')}}"--}}
{{--										   class="btn btn-sm  btn-primary mr-2">--}}
{{--											<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>--}}
{{--										</a>--}}
{{--									</div>--}}

{{--									<div class="d-flex justify-content-between mt-3 mb-3">--}}
{{--										<div class="">--}}
{{--											<h6 class="mb-1 font-weight-bold text-primary">@lang('Shipment Date')</h6>--}}
{{--											<a href="javascript:void(0)">--}}
{{--												{{ customDate($singleShipment->shipment_date) }}--}}
{{--											</a>--}}
{{--										</div>--}}
{{--										<div class="">--}}
{{--											<h6 class="mb-1 font-weight-bold text-primary">@lang('Estimate Delivery Date')</h6>--}}
{{--											<a href="javascript:void(0)">--}}
{{--												{{ customDate($singleShipment->delivery_date) }}--}}
{{--											</a>--}}
{{--										</div>--}}
{{--									</div>--}}

{{--									<ul class="list-group">--}}
{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Shipment Id') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--											#{{ $singleShipment->shipment_id }}--}}
{{--										</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Shipment Type') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--											@lang($singleShipment->shipmentTypeFormat())--}}
{{--										</span>--}}
{{--										</li>--}}

{{--										@if($singleShipment->shipment_type == 'condition')--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--											<span>--}}
{{--												@lang('Receive Amount') &nbsp;--}}
{{--											</span>--}}
{{--												<span>--}}
{{--												{{ $basic->currency_symbol }}{{ $singleShipment->receive_amount }}--}}
{{--											</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Sender Branch') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--											@lang(optional($singleShipment->senderBranch)->branch_name)--}}
{{--										</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Receiver Branch') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--											@lang(optional($singleShipment->receiverBranch)->branch_name)--}}
{{--										</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Sender') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--											<a href="{{ route('user.edit',optional($singleShipment->sender)->id) }}"--}}
{{--											   target="_blank">--}}
{{--												@lang(optional($singleShipment->sender)->name)--}}
{{--											</a>--}}
{{--										</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Receiver') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												<a href="{{ route('user.edit',optional($singleShipment->receiver)->id) }}"--}}
{{--												   target="_blank">--}}
{{--												@lang(optional($singleShipment->receiver)->name)--}}
{{--											</a>--}}
{{--										</span>--}}
{{--										</li>--}}

{{--										@if($singleShipment->from_country_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('From Country') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->fromCountry)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										@if($singleShipment->from_state_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('From State') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->fromState)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										@if($singleShipment->from_city_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('From City') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->fromCity)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										@if($singleShipment->from_area_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('From Area') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->fromArea)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}


{{--										@if($singleShipment->to_country_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('To Country') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->toCountry)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										@if($singleShipment->to_state_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('To State') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->toState)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										@if($singleShipment->to_city_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('To City') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->toCity)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										@if($singleShipment->to_area_id != null)--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('To Area') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--													@lang(optional($singleShipment->toArea)->name)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Payment By') &nbsp;--}}
{{--										</span>--}}
{{--											@if($singleShipment->payment_by == 1)--}}
{{--												<span>--}}
{{--													<a href="{{ route('user.edit',optional($singleShipment->sender)->id) }}"--}}
{{--													   target="_blank">--}}
{{--													@lang(optional($singleShipment->sender)->name)--}}
{{--												</a>--}}
{{--												</span>--}}
{{--											@else--}}
{{--												<span>--}}
{{--													<a href="{{ route('user.edit',optional($singleShipment->sender)->id) }}"--}}
{{--													   target="_blank">--}}
{{--													@lang(optional($singleShipment->receiver)->name)--}}
{{--												</a>--}}
{{--												</span>--}}
{{--											@endif--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Payment Type') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												@lang($singleShipment->payment_type)--}}
{{--											</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Payment Status') &nbsp;--}}
{{--										</span>--}}
{{--											@if($singleShipment->payment_status == 1)--}}
{{--												<span class="badge badge-primary text-white rounded"><i--}}
{{--														class="fa fa-circle text-white danger font-12"></i> @lang('Paid')</span>--}}
{{--											@else--}}
{{--												<span class="badge badge-danger rounded text-white"><i--}}
{{--														class="fa fa-circle text-white danger font-12"></i> @lang('Unpaid')</span>--}}
{{--											@endif--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Sub Total') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->sub_total)--}}
{{--											</span>--}}
{{--										</li>--}}

{{--										@if($singleShipment->shipment_type == 'pickup')--}}
{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Pickup Cost') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->pickup_cost)--}}
{{--												</span>--}}
{{--											</li>--}}

{{--											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Supply Cost') &nbsp;--}}
{{--										</span>--}}
{{--												<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->supply_cost)--}}
{{--												</span>--}}
{{--											</li>--}}
{{--										@endif--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Shipping Cost') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->shipping_cost)--}}
{{--												</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Tax') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->tax)--}}
{{--											</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Insurance') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->insurance)--}}
{{--											</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Discount') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->discount_amount)--}}
{{--											</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Total Pay') &nbsp;--}}
{{--										</span>--}}
{{--											<span>--}}
{{--												{{ $basic->currency_symbol }}@lang($singleShipment->insurance)--}}
{{--											</span>--}}
{{--										</li>--}}

{{--										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">--}}
{{--										<span>--}}
{{--											@lang('Payment Status') &nbsp;--}}
{{--										</span>--}}
{{--											@if($singleShipment->status == 1)--}}
{{--												<span class="badge badge-primary text-white rounded"><i--}}
{{--														class="fa fa-circle text-white danger font-12"></i> @lang('Active')</span>--}}
{{--											@else--}}
{{--												<span class="badge badge-danger rounded text-white"><i--}}
{{--														class="fa fa-circle text-white danger font-12"></i> @lang('Deactive')</span>--}}
{{--											@endif--}}
{{--										</li>--}}

{{--									</ul>--}}
{{--								</div>--}}


{{--								<div class="card-body">--}}
{{--									<h6 class="mb-3 font-weight-bold text-primary">@lang('User Transaction Details')</h6>--}}
{{--									<div class="row">--}}
{{--										<div class="col-md-6 mb-sm-3">--}}

{{--											<a href="">--}}
{{--												<div class="card card-statistic-1 shadow-sm branch-box">--}}
{{--													<div class="card-icon bg-primary">--}}
{{--														<i class="fas fa-funnel-dollar"></i>--}}
{{--													</div>--}}
{{--													<div class="card-wrap">--}}
{{--														<div class="card-header">--}}
{{--															<h4>@lang('Fund History')</h4>--}}
{{--														</div>--}}
{{--														<div class="card-body">--}}
{{--															2--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</a>--}}

{{--										</div>--}}
{{--										<div class="col-md-6 mb-sm-3">--}}
{{--											<a href="">--}}
{{--												<div class="card card-statistic-1 shadow-sm branch-box">--}}
{{--													<div class="card-icon bg-primary">--}}
{{--														<i class="fas fa-hand-holding-usd"></i>--}}
{{--													</div>--}}
{{--													<div class="card-wrap">--}}
{{--														<div class="card-header">--}}
{{--															<h4>@lang('Payout History')</h4>--}}
{{--														</div>--}}
{{--														<div class="card-body">--}}
{{--															20--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</a>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}


{{--								<div class="card-body">--}}
{{--									<h6 class="mb-3 font-weight-bold text-primary">@lang('User Shipment Details')</h6>--}}
{{--									<div class="row">--}}
{{--										<div class="col-md-6 mb-3">--}}
{{--											<div class="card card-statistic-1 shadow-sm branch-box">--}}
{{--												<div class="card-icon bg-primary">--}}
{{--													<i class="fas fa-shipping-fast"></i>--}}
{{--												</div>--}}
{{--												<div class="card-wrap">--}}
{{--													<div class="card-header">--}}
{{--														<h4>@lang('Total Send Courier')</h4>--}}
{{--													</div>--}}
{{--													<div class="card-body">--}}
{{--														30--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--										<div class="col-md-6 mb-3">--}}
{{--											<div class="card card-statistic-1 shadow-sm branch-box">--}}
{{--												<div class="card-icon bg-primary">--}}
{{--													<i class="fas fa-people-carry"></i>--}}
{{--												</div>--}}
{{--												<div class="card-wrap">--}}
{{--													<div class="card-header">--}}
{{--														<h4>@lang('Total Receive Courier')</h4>--}}
{{--													</div>--}}
{{--													<div class="card-body">--}}
{{--														20--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}

{{--										<div class="col-md-6 mb-3">--}}
{{--											<div class="card card-statistic-1 shadow-sm branch-box">--}}
{{--												<div class="card-icon bg-primary">--}}
{{--													<i class="fas fa-dollar-sign"></i>--}}
{{--												</div>--}}
{{--												<div class="card-wrap">--}}
{{--													<div class="card-header">--}}
{{--														<h4>@lang('Total Transaction')</h4>--}}
{{--													</div>--}}
{{--													<div class="card-body">--}}
{{--														20--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}

{{--										<div class="col-md-6 mb-3">--}}
{{--											<div class="card card-statistic-1 shadow-sm branch-box">--}}
{{--												<div class="card-icon bg-primary">--}}
{{--													<i class="fas fa-dollar-sign"></i>--}}
{{--												</div>--}}
{{--												<div class="card-wrap">--}}
{{--													<div class="card-header">--}}
{{--														<h4>@lang('Total Transaction')</h4>--}}
{{--													</div>--}}
{{--													<div class="card-body">--}}
{{--														20--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}

{{--									</div>--}}
{{--								</div>--}}

{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</section>--}}
{{--	</div>--}}
{{--@endsection--}}


{{--@section('scripts')--}}

{{--@endsection--}}

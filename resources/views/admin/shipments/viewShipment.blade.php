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
						<a href="{{ route('admin.home') }}">@lang('Shipment List')</a>
					</div>
					<div class="breadcrumb-item">@lang('Details')</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="container-fluid user-profile" id="container-wrapper">
					<div class="row justify-content-md-center">
						<div class="col-lg-8">
							<div class="card mb-4 card-primary shadow">
								<div class="card-body">
									<div class="d-flex justify-content-end">
										<a href="{{route('shipmentList', 'operator-country')}}"
										   class="btn btn-sm  btn-primary mr-2">
											<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
										</a>
									</div>

									<div class="d-flex justify-content-between mt-3 mb-3">
										<div class="">
											<h6 class="mb-1 font-weight-bold text-primary">@lang('Shipment Date')</h6>
											<a href="javascript:void(0)">
												{{ customDate($singleShipment->shipment_date) }}
											</a>
										</div>
										<div class="">
											<h6 class="mb-1 font-weight-bold text-primary">@lang('Estimate Delivery Date')</h6>
											<a href="javascript:void(0)">
												{{ customDate($singleShipment->delivery_date) }}
											</a>
										</div>
									</div>

									<ul class="list-group">
										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('Shipment Id') &nbsp;
										</span>
											<span>
											#{{ $singleShipment->shipment_id }}
										</span>
										</li>

										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('Shipment Type') &nbsp;
										</span>
											<span>
											@lang($singleShipment->shipmentTypeFormat())
										</span>
										</li>

										@if($singleShipment->shipment_type == 'condition')
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
											<span>
												@lang('Receive Amount') &nbsp;
											</span>
												<span>
												{{ $basic->currency_symbol }}{{ $singleShipment->receive_amount }}
											</span>
											</li>
										@endif

										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('Sender Branch') &nbsp;
										</span>
											<span>
											@lang(optional($singleShipment->senderBranch)->branch_name)
										</span>
										</li>

										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('Receiver Branch') &nbsp;
										</span>
											<span>
											@lang(optional($singleShipment->receiverBranch)->branch_name)
										</span>
										</li>

										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('Sender') &nbsp;
										</span>
											<span>
											<a href="{{ route('user.edit',optional($singleShipment->sender)->id) }}"
											   target="_blank">
												@lang(optional($singleShipment->sender)->name)
											</a>
										</span>
										</li>

										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('Receiver') &nbsp;
										</span>
											<span>
												<a href="{{ route('user.edit',optional($singleShipment->receiver)->id) }}"
												   target="_blank">
												@lang(optional($singleShipment->receiver)->name)
											</a>
										</span>
										</li>

										@if($singleShipment->from_country_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('From Country') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->fromCountry)->name)
												</span>
											</li>
										@endif

										@if($singleShipment->from_state_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('From State') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->fromState)->name)
												</span>
											</li>
										@endif

										@if($singleShipment->from_city_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('From City') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->fromCity)->name)
												</span>
											</li>
										@endif

										@if($singleShipment->from_area_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('From Area') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->fromArea)->name)
												</span>
											</li>
										@endif


										@if($singleShipment->to_country_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('To Country') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->toCountry)->name)
												</span>
											</li>
										@endif

										@if($singleShipment->to_state_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('To State') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->toState)->name)
												</span>
											</li>
										@endif

										@if($singleShipment->to_city_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('To City') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->toCity)->name)
												</span>
											</li>
										@endif

										@if($singleShipment->to_area_id != null)
											<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('To Area') &nbsp;
										</span>
												<span>
													@lang(optional($singleShipment->toArea)->name)
												</span>
											</li>
										@endif

										<li class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<span>
											@lang('Payment By') &nbsp;
										</span>
											<span>
													@lang(optional($singleShipment->toArea)->name)
												</span>
										</li>


									</ul>
								</div>


								<div class="card-body">
									<h6 class="mb-3 font-weight-bold text-primary">@lang('User Transaction Details')</h6>
									<div class="row">
										<div class="col-md-6 mb-sm-3">

											<a href="">
												<div class="card card-statistic-1 shadow-sm branch-box">
													<div class="card-icon bg-primary">
														<i class="fas fa-funnel-dollar"></i>
													</div>
													<div class="card-wrap">
														<div class="card-header">
															<h4>@lang('Fund History')</h4>
														</div>
														<div class="card-body">
															2
														</div>
													</div>
												</div>
											</a>

										</div>
										<div class="col-md-6 mb-sm-3">
											<a href="">
												<div class="card card-statistic-1 shadow-sm branch-box">
													<div class="card-icon bg-primary">
														<i class="fas fa-hand-holding-usd"></i>
													</div>
													<div class="card-wrap">
														<div class="card-header">
															<h4>@lang('Payout History')</h4>
														</div>
														<div class="card-body">
															20
														</div>
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>


								<div class="card-body">
									<h6 class="mb-3 font-weight-bold text-primary">@lang('User Shipment Details')</h6>
									<div class="row">
										<div class="col-md-6 mb-3">
											<div class="card card-statistic-1 shadow-sm branch-box">
												<div class="card-icon bg-primary">
													<i class="fas fa-shipping-fast"></i>
												</div>
												<div class="card-wrap">
													<div class="card-header">
														<h4>@lang('Total Send Courier')</h4>
													</div>
													<div class="card-body">
														30
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="card card-statistic-1 shadow-sm branch-box">
												<div class="card-icon bg-primary">
													<i class="fas fa-people-carry"></i>
												</div>
												<div class="card-wrap">
													<div class="card-header">
														<h4>@lang('Total Receive Courier')</h4>
													</div>
													<div class="card-body">
														20
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<div class="card card-statistic-1 shadow-sm branch-box">
												<div class="card-icon bg-primary">
													<i class="fas fa-dollar-sign"></i>
												</div>
												<div class="card-wrap">
													<div class="card-header">
														<h4>@lang('Total Transaction')</h4>
													</div>
													<div class="card-body">
														20
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<div class="card card-statistic-1 shadow-sm branch-box">
												<div class="card-icon bg-primary">
													<i class="fas fa-dollar-sign"></i>
												</div>
												<div class="card-wrap">
													<div class="card-header">
														<h4>@lang('Total Transaction')</h4>
													</div>
													<div class="card-body">
														20
													</div>
												</div>
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
@endsection


@section('scripts')

@endsection

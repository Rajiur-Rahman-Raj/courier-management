@extends('admin.layouts.master')
@section('page_title',__('Dashboard'))
@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Admin Dashboard')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Admin Dashboard')</div>
				</div>
			</div>

			<!---------- User Statistics -------------->
			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.User_Statistics.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<h6 class="mb-3 text-darku">@lang('User Statistics')</h6>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-users"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total User')</h4>
								</div>
								<div class="card-body">
									{{ $userRecord['totalUser']  }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-user-tie"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Active User')</h4>
								</div>
								<div class="card-body">
									{{ $userRecord['activeUser'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-user-plus"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Last 30 Days Users')</h4>
								</div>
								<div class="card-body">
									{{ $userRecord['last_30_days_join'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-funnel-dollar"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total User Fund')</h4>
								</div>
								<div class="card-body">
									{{trans($basic->currency_symbol)}}{{getAmount($userRecord['totalUserBalance'], config('basic.fraction_number'))}}
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Branch_Statistics.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<h6 class="mb-3 text-darku">@lang('Branch Statistics')</h6>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-code-branch"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Branches')</h4>
								</div>
								<div class="card-body">
									{{ $branchRecord['totalBranches']  }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-users"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Branch Manager')</h4>
								</div>
								<div class="card-body">
									{{ $branchRecord['totalBranchManagers']  }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-bicycle"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Branch Driver')</h4>
								</div>
								<div class="card-body">
									{{ $branchRecord['totalBranchDrivers'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-users-cog"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Branch Employee')</h4>
								</div>
								<div class="card-body">
									{{ $branchRecord['totalBranchEmployees'] }}
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Shipment_Statistics.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<h6 class="mb-3 text-darku">@lang('Shipment Statistics')</h6>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-shipping-fast"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalShipments']  }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-truck"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang(optional(basicControl()->operatorCountry)->name) @lang('Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalOperatorCountryShipments']  }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-plane"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Internationally Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalInternationallyShipments']  }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-cubes"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang("Today's Shipments")</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalTodayShipments']  }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-truck"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Drop Off Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalDropOffShipments'] }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-truck-pickup"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Pickup Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalPickupShipments'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="far fa-money-bill-alt"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Condition Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalConditionShipments'] }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-spinner" aria-hidden="true"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Pending Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalPendingShipments'] }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-paper-plane"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Sent In Queue')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalInQueueShipments'] }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-truck-loading"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Distaptch Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalDispatchShipments'] }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-spinner" aria-hidden="true"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Delivery In Queue')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalDeliveryInQueueShipments'] }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-people-carry"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Delivered Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalDeliveredShipments'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="far fa-paper-plane fa-rotate-270"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Return In Queue')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalReturnInQueueShipments'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-truck-loading fa-flip-horizontal"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Return In Dispatch')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalReturnInDispatchShipments'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-spinner" aria-hidden="true"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Return Delivery In Queue')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalReturnDeliveryInQueueShipments'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-check-double"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Return Delivered Shipments')</h4>
								</div>
								<div class="card-body">
									{{ $shipmentRecord['totalReturnInDelivered'] }}
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			<!---------- Shipments Summary Current Month-------------->
			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Shipment_Statistics.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="card mb-4 shadow-sm">
							<div class="card-body">
								<h5 class="card-title">@lang('Current month Shipments summary')</h5>
								<div>
									<canvas id="shipments-line-chart" height="80"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
			<!---------- Shipments Summary Current Year-------------->
			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Shipment_Statistics.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="card mb-4 shadow-sm">
							<div class="card-body">
								<h5 class="card-title">@lang('Current Year Shipments Summery')</h5>
								<div>
									<canvas id="shipment-year-chart" height="120"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Shipment_Transaction.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<h6 class="mb-3 text-darku">@lang('Shipment Transaction')</h6>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-code-branch"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Total Transactions')</h4>
								</div>
								<div class="card-body">
									{{trans($basic->currency_symbol)}}{{getAmount($transactionRecord['totalShipmentTransactions'], config('basic.fraction_number'))}}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-users"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Drop Off Transactions')</h4>
								</div>
								<div class="card-body">
									{{trans($basic->currency_symbol)}}{{getAmount($transactionRecord['totalDropOffTransactions'], config('basic.fraction_number'))}}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-bicycle"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Pickup Transactions')</h4>
								</div>
								<div class="card-body">
									{{trans($basic->currency_symbol)}}{{getAmount($transactionRecord['totalPickupTransactions'], config('basic.fraction_number'))}}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-users-cog"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Cash On Delivery Transactions')</h4>
								</div>
								<div class="card-body">
									{{trans($basic->currency_symbol)}}{{getAmount($transactionRecord['totalConditionTransactions'], config('basic.fraction_number'))}}
								</div>
							</div>
						</div>
					</div>

				</div>
			@endif

			<!---------- Shipments Transactions Current Month-------------->
			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Shipment_Transaction_Chart.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="card mb-4 shadow-sm">
							<div class="card-body">
								<h5 class="card-title">@lang('Current month Shipments Transactions')</h5>
								<div>
									<canvas id="shipments-transaction-current-month" height="80"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			<!---------- Shipments Transactions Current Year-------------->
			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Shipment_Transaction_Chart.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<div class="card mb-4 shadow-sm">
							<div class="card-body">
								<h5 class="card-title">@lang('Current Year Shipments Transactions')</h5>
								<div>
									<canvas id="shipments-transaction-current-year" height="80"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Tickets.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<h6 class="mb-3 text-darku">@lang('Tickets')</h6>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-spinner" aria-hidden="true"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Pending Tickets')</h4>
								</div>
								<div class="card-body">
									{{ $ticketRecord['pendingTickets'] }}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-check"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Answered Tickets')</h4>
								</div>
								<div class="card-body">
									{{ $ticketRecord['answeredTickets'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-reply"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Replied Tickets')</h4>
								</div>
								<div class="card-body">
									{{ $ticketRecord['repliedTickets'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-times-circle"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Closed Tickets')</h4>
								</div>
								<div class="card-body">
									{{ $ticketRecord['closedTickets'] }}
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif


			<!---------- Withdraw & Deposit -------------->
			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Payment_Chart.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-8">
						<div class="card mb-4 shadow-sm">
							<div class="card-body">
								<h5 class="card-title">@lang('Current Year Payment Gateway Transactions')</h5>
								<div>
									<canvas id="line-chart-2" height="120"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card mb-4 shadow-sm">
							<div class="card-body">
								<h5 class="card-title">@lang('Gateway Used For Deposit')</h5>
								<div>
									<canvas id="pie-chart-2" height="255"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

		</section>
	</div>



	@if($basicControl->is_active_cron_notification)
		<div class="modal fade" id="cron-info" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							<i class="fas fa-info-circle"></i>
							@lang('Cron Job Set Up Instruction')
						</h5>
						<button type="button" class="close cron-notification-close" data-dismiss="modal"
								aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<p class="bg-orange text-white p-2">
									<i>@lang('**To sending emails and updating currency rate automatically you need to setup cron job in your server. Make sure your job is running properly. We insist to set the cron job time as minimum as possible.**')</i>
								</p>
							</div>
							<div class="col-md-12 form-group">
								<label><strong>@lang('Command for Email')</strong></label>
								<div class="input-group ">
									<input type="text" class="form-control copyText"
										   value="curl -s {{ route('queue.work') }}" disabled>
									<div class="input-group-append">
										<button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
											<i class="fas fa-copy"></i></button>
									</div>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<label><strong>@lang('Command for Currency Rate Update')</strong></label>
								<div class="input-group ">
									<input type="text" class="form-control copyText"
										   value="curl -s {{ route('schedule:run') }}"
										   disabled>
									<div class="input-group-append">
										<button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
											<i class="fas fa-copy"></i></button>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<p class="bg-dark text-white p-2">
									@lang('*To turn off this pop up go to ')
									<a href="{{route('basic.control')}}"
									   class="text-orange">@lang('Basic control')</a>
									@lang(' and disable `Cron Set Up Pop Up`.*')
								</p>
							</div>

							<div class="col-md-12">
								<p class="text-muted"><span class="text-secondary font-weight-bold">@lang('N.B'):</span>
									@lang('If you are unable to set up cron job, Here is a video tutorial for you')
									<a href="https://www.youtube.com/watch?v=wuvTRT2ety0" target="_blank"><i
											class="fab fa-youtube"></i> @lang('Click Here') </a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection

@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/Chart.min.js') }}"></script>
@endpush

@section('scripts')
	<script>
		'use strict';
		$(document).ready(function () {

			new Chart(document.getElementById("shipments-line-chart"), {
				type: 'line',
				data: {
					labels: {!! json_encode($shipmentDayLabels) !!},
					datasets: [
						{
							data: @json($dataPendingShipment),
							label: "Requested",
							borderColor: "#21130d",
							fill: false
						},
						{
							data: @json($dataInQueueShipment),
							label: "In Queue",
							borderColor: "#33d9b2",
							fill: false
						},
						{
							data: @json($dataDispatchShipment),
							label: "Dispatch",
							borderColor: "#e28743",
							fill: false
						},
						{
							data: @json($dataReceivedShipment),
							label: "Received",
							borderColor: "#005B41",
							fill: false
						},
						{
							data: @json($dataDeliveredShipment),
							label: "Delivered",
							borderColor: "#C70039",
							fill: false
						},
						{
							data: @json($dataReturnInQueueShipment),
							label: "Return In Queue",
							borderColor: "#3876BF",
							fill: false
						},
						{
							data: @json($dataReturnDispatchShipment),
							label: "Return Dispatch",
							borderColor: "#F99417",
							fill: false
						},
						{
							data: @json($dataReturnReceivedShipment),
							label: "Return Received",
							borderColor: "#219C90",
							fill: false
						},
						{
							data: @json($dataReturnDeliveredShipment),
							label: "Return Delivered",
							borderColor: "#FF3FA4",
							fill: false
						},
					]
				}
			});

			new Chart(document.getElementById("shipment-year-chart"), {
				type: 'bar',
				data: {
					labels: {!! json_encode($shipmentYearLabels) !!},
					datasets: [
						{
							data: @json($yearTotalShipments),
							label: "Total Shipments",
							borderColor: "#5272F2",
							backgroundColor: "#5272F2",
						},
						{
							data: @json($yearOperatorCountryShipments),
							label: "Operate Country",
							borderColor: "#B6FFFA",
							backgroundColor: "#B6FFFA",
						},
						{
							data: @json($yearInternationallyShipments),
							label: "Internationally",
							borderColor: "#FCE09B",
							backgroundColor: "#FCE09B",
						},
						{
							data: @json($yearDropOffShipments),
							label: "Drop Off",
							borderColor: "#FF6969",
							backgroundColor: "#FF6969",
						},
						{
							data: @json($yearPickupShipments),
							label: "Pickup",
							borderColor: "#45FFCA",
							backgroundColor: "#45FFCA",
						},
						{
							data: @json($yearConditionShipments),
							label: "Condition",
							borderColor: "#E19898",
							backgroundColor: "#E19898",
						},
						{
							data: @json($yearRequestShipments),
							label: "Requested",
							borderColor: "#191717",
							backgroundColor: "#191717",
						},

						{
							data: @json($yearDeliveredShipments),
							label: "Delivered",
							borderColor: "#A6FF96",
							backgroundColor: "#A6FF96",
						},
						{
							data: @json($yearReturnShipments),
							label: "Return Shipments",
							borderColor: "#C70039",
							backgroundColor: "#C70039",
						},
					]
				}
			});


			new Chart(document.getElementById("shipments-transaction-current-month"), {
				type: 'line',
				data: {
					labels: {!! json_encode($shipmentTransactionsDayLabels) !!},
					datasets: [
						{
							data: @json($dataDropOffTransactions),
							label: "Drop Off",
							borderColor: "#21130d",
							fill: false
						},
						{
							data: @json($dataPickupTransactions),
							label: "Pickup",
							borderColor: "#33d9b2",
							fill: false
						},
						{
							data: @json($dataConditionTransactions),
							label: "Condition / Cas On Delivery",
							borderColor: "#e28743",
							fill: false
						},
					]
				}
			});

			new Chart(document.getElementById("shipments-transaction-current-year"), {
				type: 'bar',
				data: {
					labels: {!! json_encode($yearLabels) !!},
					datasets: [
						{
							data: @json($yeartotalShipmentTransactions),
							label: "Total Transactions",
							borderColor: "#5272F2",
							backgroundColor: "#5272F2",
						},
						{
							data: @json($yeartotalDropOffTransactions),
							label: "Drop Off",
							borderColor: "#B6FFFA",
							backgroundColor: "#B6FFFA",
						},
						{
							data: @json($yeartotalPickupTransactions),
							label: "Pickup",
							borderColor: "#FCE09B",
							backgroundColor: "#FCE09B",
						},
						{
							data: @json($yeartotalConditionTransactions),
							label: "Condition",
							borderColor: "#FF6969",
							backgroundColor: "#FF6969",
						},
					]
				}
			});


			new Chart(document.getElementById("line-chart-2"), {
				type: 'bar',
				data: {
					labels: {!! json_encode($yearLabels) !!},
					datasets: [
						{
							data: {!! json_encode($yearDeposit) !!},
							label: "Deposit",
							borderColor: "#8e44ad",
							backgroundColor: "#8e44ad",
						},
						{
							data: {!! json_encode($yearPayout) !!},
							label: "Withdraw",
							borderColor: "#4455ad",
							backgroundColor: "#4455ad",
						},
					]
				}
			});

			new Chart(document.getElementById("pie-chart-2"), {
				type: 'pie',
				data: {
					labels: {!! json_encode($paymentMethodeLabel) !!},
					datasets: [{
						backgroundColor: ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
							"#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
							"#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
						],
						data: {!! json_encode($paymentMethodeData) !!},
					}]
				},
				options: {
					tooltips: {
						callbacks: {
							label: function (tooltipItems, data) {
								return data.labels[tooltipItems.index] + ': ' + data.datasets[0].data[tooltipItems.index] + " {{ __($basicControl->base_currency_code) }}";
							}
						}
					}
				}
			});
		})
		;

		$(document).ready(function () {
			let isActiveCronNotification = '{{ $basicControl->is_active_cron_notification }}';
			if (isActiveCronNotification == 1)
				$('#cron-info').modal('show');
			$(document).on('click', '.copy-btn', function () {
				var _this = $(this)[0];
				var copyText = $(this).parents('.input-group-append').siblings('input');
				$(copyText).prop('disabled', false);
				copyText.select();
				document.execCommand("copy");
				$(copyText).prop('disabled', true);
				$(this).text('Coppied');
				setTimeout(function () {
					$(_this).text('');
					$(_this).html('<i class="fas fa-copy"></i>');
				}, 500)
			});
		})
	</script>
@endsection

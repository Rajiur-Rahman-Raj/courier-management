@extends('admin.layouts.master')
@section('page_title',__('Dashboard'))

@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/daterangepicker.css') }}">
@endpush

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
									<h4>@lang('This Month Users')</h4>
								</div>
								<div class="card-body">
									{{ $userRecord['thisMonthUsers'] }}
									<small
										class="{{ $userRecord['currentMonthClass'] }} growth-calculation fw-medium float-right mt-2"><i
											class="{{ $userRecord['currentMonthArrowIcon'] }}"></i> @if($userRecord['currentMonthArrowIcon'] != null)
											{{ $userRecord['currentMonthClass'] == 'text-success' ? ' + ' :' - ' }}
										@endif{{ abs($userRecord['currentMonthPercentage']) }}%</small>
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
									<h4>@lang('This Year Users')</h4>
									<small
										class="{{ $userRecord['currentYearClass'] }} growth-calculation fw-medium float-right mt-2"><i
											class="{{ $userRecord['currentYearArrowIcon'] }}"></i> @if($userRecord['currentYearArrowIcon'] != null)
											{{ $userRecord['currentYearClass'] == 'text-success' ? ' + ' :' - ' }}
										@endif {{ abs($userRecord['currentYearPercentage']) }}%</small>
								</div>
								<div class="card-body">
									{{ $userRecord['thisYearUsers'] }}
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
								<div class="card-body ">
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
							<div class="card-body position-relative">
								<div class="d-flex justify-content-between">
									<h5 class="card-title">@lang('Current month Shipments summary')</h5>
									<div class="daterange-container">
										<div class="daterange-picker">
											<input type="text" id="dailyShipments" value=""/>
											<i class="fa fa-caret-down"></i>
										</div>
									</div>
								</div>

								<div>
									<canvas id="daily-shipments-line-chart" height="80"></canvas>
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
								<div class="d-flex justify-content-between">
									<h5 class="card-title">@lang('Current Year Shipments Summery')</h5>
								</div>

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
					<div class="col-lg-4 col-md-6 col-sm-6 col-12">
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

					<div class="col-lg-4 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-code-branch"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang(optional(basicControl()->operatorCountry)->name) @lang('Transactions')</h4>
								</div>
								<div class="card-body">
									{{trans($basic->currency_symbol)}}{{getAmount($transactionRecord['totalOperatorCountryTransactions'], config('basic.fraction_number'))}}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 col-sm-6 col-12">
						<div class="card card-statistic-1 shadow-sm">
							<div class="card-icon bg-primary">
								<i class="fas fa-code-branch"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>@lang('Internationally Transactions')</h4>
								</div>
								<div class="card-body">
									{{trans($basic->currency_symbol)}}{{getAmount($transactionRecord['totalInternationallyTransactions'], config('basic.fraction_number'))}}
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 col-sm-6 col-12">
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
					<div class="col-lg-4 col-md-6 col-sm-6 col-12">
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
					<div class="col-lg-4 col-md-6 col-sm-6 col-12">
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
								<div class="d-flex justify-content-between">
									<h5 class="card-title">@lang('Current month Shipments Transactions')</h5>
									<div class="daterange-container">
										<div class="daterange-picker">
											<input type="text" id="dailyShipmentTransactions" value=""/>
											<i class="fa fa-caret-down"></i>
										</div>
									</div>
								</div>
								<div>
									<canvas id="daily-shipment-transactions-line-chart" height="80"></canvas>
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

			@if(adminAccessRoute(array_merge(config('permissionList.Dashboard.Browser_Statistics.permission.view'))))
				<div class="row mb-3">
					<div class="col-md-12">
						<h6 class="mb-3 text-darku">@lang('Browser Statistics')</h6>
					</div>
					<div class="col-lg-4 mb-3 mb-lg-5">
						<!-- Card -->
						<div class="card h-100">
							<div class="card-header d-flex justify-content-between">
								<h4 class="card-header-title">@lang("Browser History")</h4>
								<div class="daterange-container">
									<div class="daterange-picker browser-history-date-range">
										<input type="text" id="dailyBrowserHistory" value=""/>
										<i class="fa fa-caret-down"></i>
									</div>
								</div>
							</div>
							<!-- Body -->
							<div class="card-body text-center">

								<div>
									<canvas id="browserHistory" height="255"></canvas>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-4 mb-3 mb-lg-5">
						<!-- Card -->
						<div class="card h-100">
							<div class="card-header d-flex justify-content-between">
								<h4 class="card-header-title">@lang("Operating System History")</h4>
								<div class="daterange-container">
									<div class="daterange-picker browser-history-date-range">
										<input type="text" id="dailyOperatingSystemHistory" value=""/>
										<i class="fa fa-caret-down"></i>
									</div>
								</div>
							</div>
							<!-- Body -->
							<div class="card-body text-center">
								<div>
									<canvas id="operatingSystemHistory" height="255"></canvas>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-4 mb-3 mb-lg-5">
						<!-- Card -->
						<div class="card h-100">
							<div class="card-header d-flex justify-content-between">
								<h4 class="card-header-title">@lang("Device History")</h4>
								<div class="daterange-container">
									<div class="daterange-picker browser-history-date-range">
										<input type="text" id="dailyDeviceHistory" value=""/>
										<i class="fa fa-caret-down"></i>
									</div>
								</div>
							</div>
							<!-- Body -->
							<div class="card-body text-center">
								<div>
									<canvas id="deviceHistory" height="255"></canvas>
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
	<script src="{{ asset('assets/dashboard/js/moment.min.js') }}"></script>
	<script src="{{ asset('assets/dashboard/js/daterangepicker.min.js') }}"></script>
@endpush

@section('scripts')
	<script>
		'use strict';
		$(document).ready(function () {

			// daily shipment analytics
			$('#dailyShipments').daterangepicker({
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month'),
				locale: {
					format: 'DD/MM/YYYY'
				},
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				opens: 'right', // Set the position to top right
			}, function (start, end, label) {
				getDailyShipmentAnalytics(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
			});

			function getDailyShipmentAnalytics(start, end) {
				$.ajax({
					method: "GET",
					url: "{{ route('get.daily.shipment.analytics') }}",
					dataType: "json",
					data: {
						'start': start,
						'end': end,
					}
				}).done(function (response) {
					new Chart(document.getElementById("daily-shipments-line-chart"), {
						type: 'line',
						data: {
							labels: response.labels,
							datasets: [

								{
									data: response.dataPendingShipment,
									label: "Requested",
									borderColor: "#0F0F0F",
									fill: false
								},
								{
									data: response.dataInQueueShipment,
									label: "In Queue",
									borderColor: "#39A7FF",
									fill: false
								},
								{
									data: response.dataDispatchShipment,
									label: "Dispatch",
									borderColor: "#FF6C22",
									fill: false
								},
								{
									data: response.dataReceivedShipment,
									label: "Received",
									borderColor: "#005B41",
									fill: false
								},
								{
									data: response.dataDeliveredShipment,
									label: "Delivered",
									borderColor: "#C70039",
									fill: false
								},
								{
									data: response.dataReturnInQueueShipment,
									label: "Return In Queue",
									borderColor: "#3085C3",
									fill: false
								},
								{
									data: response.dataReturnDispatchShipment,
									label: "Return Dispatch",
									borderColor: "#862B0D",
									fill: false
								},
								{
									data: response.dataReturnReceivedShipment,
									label: "Return Received",
									borderColor: "#00DFA2",
									fill: false
								},
								{
									data: response.dataReturnDeliveredShipment,
									label: "Return Delivered",
									borderColor: "#E11299",
									fill: false
								},
							]
						}
					});
				});
			}

			getDailyShipmentAnalytics(moment().startOf('month').format('DD/MM/YYYY'), moment().endOf('month').format('DD/MM/YYYY'));


			// daily shipment transactions analytics
			$('#dailyShipmentTransactions').daterangepicker({
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month'),
				locale: {
					format: 'DD/MM/YYYY'
				},
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				opens: 'right', // Set the position to top right
			}, function (start, end, label) {
				getDailyShipmentTransactionsAnalytics(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
			});

			function getDailyShipmentTransactionsAnalytics(start, end) {
				$.ajax({
					method: "GET",
					url: "{{ route('get.daily.shipment.transactions.analytics') }}",
					dataType: "json",
					data: {
						'start': start,
						'end': end,
					}
				}).done(function (response) {
					new Chart(document.getElementById("daily-shipment-transactions-line-chart"), {
						type: 'line',
						data: {
							labels: response.labels,
							datasets: [
								{
									data: response.dataTotalShipmentTransactions,
									label: "Total Transactions",
									borderColor: "#4E4FEB",
									fill: false
								},
								{
									data: response.dataTotalOperatorCountryTransactions,
									label: "Operator Country",
									borderColor: "#1A5D1A",
									fill: false
								},
								{
									data: response.dataTotalInternationallyTransactions,
									label: "Internationally",
									borderColor: "#F94C10",
									fill: false
								},
								{
									data: response.dataDropOffTransactions,
									label: "Drop Off",
									borderColor: "#009FBD",
									fill: false
								},

								{
									data: response.dataPickupTransactions,
									label: "Pickup",
									borderColor: "#E11299",
									fill: false
								},

								{
									data: response.dataConditionTransactions,
									label: "Condition",
									borderColor: "#E21818",
									fill: false
								},
							]
						}
					});
				});
			}


			getDailyShipmentTransactionsAnalytics(moment().startOf('month').format('DD/MM/YYYY'), moment().endOf('month').format('DD/MM/YYYY'));


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
							borderColor: "#005B41",
							backgroundColor: "#005B41",
						},
						{
							data: @json($yearInternationallyShipments),
							label: "Internationally",
							borderColor: "#FF6C22",
							backgroundColor: "#FF6C22",
						},
						{
							data: @json($yearDropOffShipments),
							label: "Drop Off",
							borderColor: "#0174BE",
							backgroundColor: "#0174BE",
						},
						{
							data: @json($yearPickupShipments),
							label: "Pickup",
							borderColor: "#CE5A67",
							backgroundColor: "#CE5A67",
						},
						{
							data: @json($yearConditionShipments),
							label: "Condition",
							borderColor: "#F4CE14",
							backgroundColor: "#F4CE14",
						},
						{
							data: @json($yearRequestShipments),
							label: "Requested",
							borderColor: "#0F0F0F",
							backgroundColor: "#0F0F0F",
						},

						{
							data: @json($yearDeliveredShipments),
							label: "Delivered",
							borderColor: "#0174BE",
							backgroundColor: "#0174BE",
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


			new Chart(document.getElementById("shipments-transaction-current-year"), {
				type: 'bar',
				data: {
					labels: {!! json_encode($yearLabels) !!},
					datasets: [
						{
							data: @json($yearTotalShipmentTransactions),
							label: "Total Transactions",
							borderColor: "#5272F2",
							backgroundColor: "#5272F2",
						},
						{
							data: @json($yearTotalOperatorCountryTransactions),
							label: "Operator Country",
							borderColor: "#005B41",
							backgroundColor: "#005B41",
						},
						{
							data: @json($yearTotalInternationallyTransactions),
							label: "Internationally",
							borderColor: "#FF6C22",
							backgroundColor: "#FF6C22",
						},
						{
							data: @json($yearTotalDropOffTransactions),
							label: "Drop Off",
							borderColor: "#0174BE",
							backgroundColor: "#0174BE",
						},
						{
							data: @json($yearTotalPickupTransactions),
							label: "Pickup",
							borderColor: "#CE5A67",
							backgroundColor: "#CE5A67",
						},
						{
							data: @json($yearTotalConditionTransactions),
							label: "Condition",
							borderColor: "#F4CE14",
							backgroundColor: "#F4CE14",
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


			// Daily browser history analytics
			$('#dailyBrowserHistory').daterangepicker({
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month'),
				locale: {
					format: 'DD/MM/YYYY'
				},
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				opens: 'right', // Set the position to top right
			}, function (start, end, label) {
				getDailyBrowserHistoryAnalytics(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
			});

			function getDailyBrowserHistoryAnalytics(start, end) {
				$.ajax({
					method: "GET",
					url: "{{ route('get.daily.browser.history.analytics') }}",
					dataType: "json",
					data: {
						'start': start,
						'end': end,
					}
				}).done(function (response) {


					const browserCounts = response.userCreationBrowserData;
					const keys = Object.keys(browserCounts);
					const values = Object.values(browserCounts);
					new Chart(document.getElementById("browserHistory"), {
						type: 'doughnut',
						data: {
							labels: keys,
							datasets: [{
								backgroundColor: ['#259645', '#E66000', '#006CFF', "#1EBBEE", "#B15EFF", "#FFA33C", "#CE5A67", "#610C9F", "#FF4B91", "#2c3e50",
									"#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
									"#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
								],
								data: values
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

				});
			}

			getDailyBrowserHistoryAnalytics(moment().startOf('month').format('DD/MM/YYYY'), moment().endOf('month').format('DD/MM/YYYY'));


			// Daily Operating System History Analytics
			$('#dailyOperatingSystemHistory').daterangepicker({
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month'),
				locale: {
					format: 'DD/MM/YYYY'
				},
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				opens: 'right', // Set the position to top right
			}, function (start, end, label) {
				getDailyOperatingSystemHistoryAnalytics(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
			});

			function getDailyOperatingSystemHistoryAnalytics(start, end) {
				$.ajax({
					method: "GET",
					url: "{{ route('get.daily.operating.system.history.analytics') }}",
					dataType: "json",
					data: {
						'start': start,
						'end': end,
					}
				}).done(function (response) {
					const browserCounts = response.userCreationOSData;
					const keys = Object.keys(browserCounts);
					const values = Object.values(browserCounts);

					new Chart(document.getElementById("operatingSystemHistory"), {
						type: 'doughnut',
						data: {
							labels: keys,
							datasets: [{
								backgroundColor: ['#F25022', '#a4c639', '#77216f', "#B15EFF", "#B15EFF", "#FFA33C", "#CE5A67", "#610C9F", "#FF4B91", "#2c3e50",
									"#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
									"#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
								],
								data: values
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
				});
			}


			getDailyOperatingSystemHistoryAnalytics(moment().startOf('month').format('DD/MM/YYYY'), moment().endOf('month').format('DD/MM/YYYY'));


			// Daily Device History Analytics
			$('#dailyDeviceHistory').daterangepicker({
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month'),
				locale: {
					format: 'DD/MM/YYYY'
				},
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				opens: 'right', // Set the position to top right
			}, function (start, end, label) {
				getDailyDeviceHistoryAnalytics(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
			});

			function getDailyDeviceHistoryAnalytics(start, end) {
				$.ajax({
					method: "GET",
					url: "{{ route('get.daily.device.history.analytics') }}",
					dataType: "json",
					data: {
						'start': start,
						'end': end,
					}
				}).done(function (response) {
					const browserCounts = response.userCreationDeviceData;
					const keys = Object.keys(browserCounts);
					const values = Object.values(browserCounts);

					new Chart(document.getElementById("deviceHistory"), {
						type: 'doughnut',
						data: {
							labels: keys,
							datasets: [{
								backgroundColor: ['#2B3499', '#706233', '#77216f', "#B15EFF", "#B15EFF", "#FFA33C", "#CE5A67", "#610C9F", "#FF4B91", "#2c3e50",
									"#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
									"#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
								],
								data: values
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
				});
			}

			getDailyDeviceHistoryAnalytics(moment().startOf('month').format('DD/MM/YYYY'), moment().endOf('month').format('DD/MM/YYYY'));


		});

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

@extends($theme.'layouts.user')
@section('page_title',__('Transaction List'))

@push('extra_styles')
	<link href="{{ asset('assets/dashboard/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
	<div class="container-fluid">
		<div class="main row">
			<div class="col-12">
				<div class="dashboard-heading">
					<div class="">
						<h2 class="mb-0">@lang('Transaction List')</h2>
						<nav aria-label="breadcrumb" class="ms-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a
										href="{{ route('user.dashboard') }}">@lang('Dashboard')</a></li>
								<li class="breadcrumb-item"><a href="#">@lang('Transaction')</a></li>
							</ol>
						</nav>
					</div>
				</div>

				<div class="search-bar profile-setting">
					<form action="{{ route('user.transaction.search') }}" method="get">
						@include($theme.'user.transaction.searchForm')
					</form>
				</div>
				<div class="table-parent table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>@lang('SL No.')</th>
							<th>@lang('Transaction ID')</th>
							<th>@lang('Amount')</th>
							<th>@lang('Remarks')</th>
							<th>@lang('Time')</th>
						</tr>
						</thead>
						<tbody>
						@forelse($transactions as $key => $transaction)
							<tr>
								<td data-label="SL.">{{loopIndex($transactions) + $loop->index}}</td>
								<td data-label="@lang('Transaction Id')">@lang($transaction->trx_id)</td>
								<td data-label="@lang('Amount')">
									<span
										class="fontBold text-{{($transaction->trx_type == "+") ? 'success': 'danger'}}">{{($transaction->trx_type == "+") ? '+': '-'}}{{getAmount($transaction->amount, config('basic.fraction_number')). ' ' . trans(config('basic.base_currency'))}}</span>
								</td>

								<td>@lang($transaction->remarks)</td>

								<td>{{ dateTime($transaction->created_at, 'd M Y h:i A') }}</td>
							</tr>
						@empty
							<tr>
								<th colspan="100%" class="text-center">@lang('No data found')</th>
							</tr>
						@endforelse
						</tbody>
					</table>
				</div>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						{{ $transactions->appends($_GET)->links() }}
					</ul>
				</nav>
			</div>
		</div>
	</div>
@endsection

@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/flatpickr.js') }}"></script>
@endpush

@section('scripts')
	<script>
		'use strict'
		$('.from_date').on('change', function () {
			$('.to_date').removeAttr('disabled');
		});

		$(document).ready(function () {
			$(".flatpickr").flatpickr({
				wrap: true,
				altInput: true,
				dateFormat: "Y-m-d H:i",
			});
		})

	</script>
@endsection

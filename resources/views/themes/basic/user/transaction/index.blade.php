@extends($theme.'layouts.user')
@section('page_title',__('Transaction List'))

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
							<th scope="col">@lang('Sender')</th>
							<th scope="col">@lang('Receiver')</th>
							<th scope="col">@lang('Receiver E-Mail')</th>
							<th scope="col">@lang('Transaction ID')</th>
							<th scope="col">@lang('Requested Amount')</th>
							<th scope="col">@lang('Type')</th>
							<th scope="col">@lang('Status')</th>
							<th scope="col">@lang('Created time')</th>
						</tr>
						</thead>
						<tbody>
						@forelse($transactions as $key => $value)
							<tr>
								<td data-label="@lang('Sender')">
									@if($value->transactional_type == \App\Models\Order::class)
										@lang('N/A')
									@else
										{{ __(optional(optional($value->transactional)->user)->name ?? __('N/A')) }}
									@endif
								</td>
								<td data-label="@lang('Receiver')">
									@if($value->transactional_type == \App\Models\Order::class)
										{{ __(optional(optional($value->transactional)->user)->name ?? __('N/A')) }}
									@else
										{{ __(optional(optional($value->transactional)->receiver)->name ?? __('N/A')) }}
									@endif
								</td>
								<td data-label="@lang('Receiver E-Mail')">
									@if($value->transactional_type == \App\Models\Order::class)
										{{ __(optional(optional($value->transactional)->user)->email ?? __('N/A')) }}
									@else
										{{ __($value->transactional->email)??__('N/A') }}
									@endif
								</td>
								<td data-label="@lang('Transaction ID')">{{ __($value->utr) }}</td>
								<td data-label="@lang('Requested Amount')">{{ getAmount($value->amount,config('basic.fraction_number')) .' '. config('basic.base_currency') }}</td>
								<td data-label="@lang('Type')">
									{{ __(str_replace('App\Models\\', '', $value->transactional_type)) }}
								</td>
								<td data-label="@lang('Status')">
									@if($value->transactional->status)
										<span class="badge bg-success">@lang('Success')</span>
									@else
										<span class="badge bg-warning">@lang('Pending')</span>
									@endif
								</td>
								<td data-label="@lang('Created time')"> {{ dateTime($value->created_at)}} </td>
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


















{{--@extends($theme.'layouts.user')--}}
{{--@section('page_title',__('Transaction List'))--}}

{{--@section('content')--}}
{{--	<div class="main-content">--}}
{{--		<section class="section">--}}
{{--			<div class="section-header">--}}
{{--				<h1>@lang('Transaction List')</h1>--}}
{{--				<div class="section-header-breadcrumb">--}}
{{--					<div class="breadcrumb-item active">--}}
{{--						<a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>--}}
{{--					</div>--}}
{{--					<div class="breadcrumb-item">@lang('Transaction List')</div>--}}
{{--				</div>--}}
{{--			</div>--}}

{{--			<div class="row mb-3">--}}
{{--				<div class="container-fluid" id="container-wrapper">--}}
{{--					<div class="row">--}}
{{--						<div class="col-lg-12">--}}
{{--							<div class="card mb-4 card-primary shadow-sm">--}}
{{--								<div--}}
{{--									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">--}}
{{--									<h6 class="m-0 font-weight-bold text-primary">@lang('Search')</h6>--}}
{{--								</div>--}}
{{--								<div class="card-body">--}}
{{--									<form action="{{ route('user.transaction.search') }}" method="get">--}}
{{--										@include($theme.'user.transaction.searchForm')--}}
{{--									</form>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="row">--}}
{{--						<div class="col-lg-12">--}}
{{--							<div class="card mb-4 card-primary shadow">--}}
{{--								<div--}}
{{--									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">--}}
{{--									<h6 class="m-0 font-weight-bold text-primary">@lang('Transaction List')</h6>--}}
{{--								</div>--}}
{{--								<div class="card-body">--}}
{{--									<div class="table-responsive">--}}
{{--										<table--}}
{{--											class="table table-striped table-hover align-items-center table-borderless">--}}
{{--											<thead class="thead-light">--}}
{{--											<tr>--}}
{{--												<th>@lang('Sender')</th>--}}
{{--												<th>@lang('Receiver')</th>--}}
{{--												<th>@lang('Receiver E-Mail')</th>--}}
{{--												<th>@lang('Transaction ID')</th>--}}
{{--												<th>@lang('Requested Amount')</th>--}}
{{--												<th>@lang('Type')</th>--}}
{{--												<th>@lang('Status')</th>--}}
{{--												<th>@lang('Created time')</th>--}}
{{--											</tr>--}}
{{--											</thead>--}}
{{--											<tbody>--}}
{{--											@forelse($transactions as $key => $value)--}}
{{--												<tr>--}}
{{--													<td data-label="@lang('Sender')">--}}
{{--														{{ __(optional(optional($value->transactional)->sender)->name) ?? __('N/A') }}--}}
{{--													</td>--}}
{{--													<td data-label="@lang('Receiver')">--}}
{{--														{{ __(optional(optional($value->transactional)->receiver)->name) ?? __('N/A') }}--}}
{{--													</td>--}}
{{--													<td data-label="@lang('Receiver E-Mail')">{{ __(optional($value->transactional)->email) }}</td>--}}
{{--													<td data-label="@lang('Transaction ID')">{{ __(optional($value->transactional)->utr) }}</td>--}}
{{--													<td data-label="@lang('Requested Amount')">{{ (getAmount(optional($value->transactional)->amount)) .' '. config('basic.base_currency') }}</td>--}}
{{--													<td data-label="@lang('Type')">--}}
{{--														{{ __(str_replace('App\Models\\', '', $value->transactional_type)) }}--}}
{{--													</td>--}}
{{--													<td data-label="@lang('Status')">--}}
{{--														@if($value->transactional->status)--}}
{{--															<span class="badge badge-success">@lang('Success')</span>--}}
{{--														@else--}}
{{--															<span class="badge badge-warning">@lang('Pending')</span>--}}
{{--														@endif--}}
{{--													</td>--}}
{{--													<td data-label="@lang('Created time')"> {{ dateTime($value->created_at)}} </td>--}}
{{--												</tr>--}}
{{--											@empty--}}
{{--												<tr>--}}
{{--													<th colspan="100%" class="text-center">@lang('No data found')</th>--}}
{{--												</tr>--}}
{{--											@endforelse--}}
{{--											</tbody>--}}
{{--										</table>--}}
{{--									</div>--}}
{{--									<div class="card-footer">--}}
{{--										{{ $transactions->links() }}--}}
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

@extends($theme.'layouts.user')
@section('page_title',__('Tickets Log'))

@section('content')
	<div class="container-fluid">
		<div class="main row">
			<div class="col-12">
				<div class="dashboard-heading d-flex justify-content-between">
					<div class="">
						<h2 class="mb-0">@lang('Tickets Log')</h2>
						<nav aria-label="breadcrumb"  class="ms-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a
										href="{{ route('user.dashboard') }}">@lang('Dashboard')</a></li>
								<li class="breadcrumb-item"><a href="#">@lang('Tickets Log')</a></li>
							</ol>
						</nav>
					</div>
					<div class="">
						<a href="{{ route('user.ticket.create') }}" class="cmn_btn">
							@lang('Create new ticket')
						</a>
					</div>

				</div>

				<div class="table-parent table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th scope="col">@lang('Subject')</th>
							<th scope="col">@lang('Status')</th>
							<th scope="col">@lang('Last Reply')</th>
							<th scope="col">@lang('Action')</th>
						</tr>
						</thead>
						<tbody>
						@forelse($tickets as $key => $ticket)
							<tr>
								<td data-label="@lang('Subject')">
									[{{ trans('Ticket# ').__($ticket->ticket) }}
									] {{ __($ticket->subject) }}
								</td>
								<td data-label="@lang('Status')">
									@if($ticket->status == 0)
										<span class="badge text-bg-primary">@lang('Open')</span>
									@elseif($ticket->status == 1)
										<span class="badge text-bg-success">@lang('Answered')</span>
									@elseif($ticket->status == 2)
										<span
											class="badge text-bg-secondary">@lang('Replied')</span>
									@elseif($ticket->status == 3)
										<span
											class="badge text-bg-danger">@lang('Closed')</span>
									@endif
								</td>
								<td data-label="@lang('Last Reply')">
									{{ __($ticket->last_reply->diffForHumans()) }}
								</td>
								<td data-label="@lang('Action')">
									<a href="{{ route('user.ticket.view', $ticket->ticket) }}"
									   class="view_cmn_btn">
										@lang('View')
									</a>
								</td>
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
						{{ $tickets->appends($_GET)->links() }}
					</ul>
				</nav>
			</div>
		</div>
	</div>
@endsection





















{{--@extends($theme.'layouts.user')--}}
{{--@section('page_title',__('Tickets Log'))--}}

{{--@section('content')--}}
{{--<div class="main-content">--}}
{{--	<section class="section pt-4 p-5">--}}
{{--		<div class="section-header">--}}
{{--			<h3>@lang('Tickets Log')</h3>--}}
{{--			<nav aria-label="breadcrumb">--}}
{{--				<ol class="breadcrumb">--}}
{{--					<li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a></li>--}}
{{--					<li class="breadcrumb-item active" aria-current="page">@lang('Tickets Log')</li>--}}
{{--				</ol>--}}
{{--			</nav>--}}
{{--		</div>--}}

{{--		<div class="row mb-3">--}}
{{--			<div class="container-fluid" id="container-wrapper">--}}
{{--				<div class="row">--}}
{{--					<div class="col-sm-12">--}}
{{--						<div class="card mb-4 card-primary shadow">--}}
{{--							<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">--}}
{{--								<h6 class="m-0 font-weight-bold text-dark">@lang('Tickets Log')</h6>--}}
{{--								<a href="{{ route('user.ticket.create') }}" class="btn btn-sm btn-outline-warning text-dark"><i--}}
{{--											class="fas fa-plus text-warning"></i> @lang('Create new ticket')</a>--}}
{{--							</div>--}}
{{--							<div class="card-body">--}}
{{--								<div class="table-responsive">--}}
{{--									<table class="table table-striped table-hover align-items-center table-borderless">--}}
{{--										<thead class="thead-light">--}}
{{--										<tr>--}}
{{--											<th>@lang('Subject')</th>--}}
{{--											<th>@lang('Status')</th>--}}
{{--											<th>@lang('Last Reply')</th>--}}
{{--											<th>@lang('Action')</th>--}}
{{--										</tr>--}}
{{--										</thead>--}}
{{--										<tbody>--}}
{{--										@forelse($tickets as $key => $ticket)--}}
{{--											<tr>--}}
{{--												<td data-label="@lang('Subject')">--}}
{{--													[{{ trans('Ticket# ').__($ticket->ticket) }}] {{ __($ticket->subject) }}--}}
{{--												</td>--}}
{{--												<td data-label="@lang('Status')">--}}
{{--													@if($ticket->status == 0)--}}
{{--														<span class="badge badge-pill badge-success">@lang('Open')</span>--}}
{{--													@elseif($ticket->status == 1)--}}
{{--														<span class="badge badge-pill badge-primary">@lang('Answered')</span>--}}
{{--													@elseif($ticket->status == 2)--}}
{{--														<span class="badge badge-pill badge-warning">@lang('Replied')</span>--}}
{{--													@elseif($ticket->status == 3)--}}
{{--														<span class="badge badge-pill badge-dark">@lang('Closed')</span>--}}
{{--													@endif--}}
{{--												</td>--}}
{{--												<td data-label="@lang('Last Reply')">--}}
{{--													{{ __($ticket->last_reply->diffForHumans()) }}--}}
{{--												</td>--}}
{{--												<td data-label="@lang('Action')">--}}
{{--													<a href="{{ route('user.ticket.view', $ticket->ticket) }}" class="btn btn-sm btn-outline-warning text-dark">--}}
{{--														@lang('View')--}}
{{--													</a>--}}
{{--												</td>--}}
{{--											</tr>--}}
{{--										@empty--}}
{{--											<tr>--}}
{{--												<th colspan="100%" class="text-center">@lang('No data found')</th>--}}
{{--											</tr>--}}
{{--										@endforelse--}}
{{--										</tbody>--}}
{{--									</table>--}}
{{--									{{ $tickets->appends($_GET)->links() }}--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}

{{--	</section>--}}
{{--</div>--}}
{{--@endsection--}}

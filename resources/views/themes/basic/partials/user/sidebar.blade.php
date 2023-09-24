<!-- sidebar -->
<div id="sidebar" class="">
	<div class="sidebar-top">
		<a class="navbar-brand" href="{{url('/')}}"> <img
				src="{{ getFile(config('basic.default_file_driver'),config('basic.logo_image')) }}"
				alt="@lang('logo image')"/></a>
		<button class="sidebar-toggler d-md-none" onclick="toggleSideMenu()">
			<i class="fal fa-times"></i>
		</button>
	</div>

	<div class="search_area">
		<input type="text" class="form-control" placeholder="Tracking number">
		<div class="icon_area">
			<i class="far fa-search"></i>
		</div>
	</div>

	<ul class="main">
		<li>
			<a class="{{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}"><i
					class="fal fa-th-large"></i>@lang('Dashboard')</a>
		</li>

		<li>
			<a class="dropdown-toggle" data-bs-toggle="collapse" href="#dropdownCollapsible" role="button"
			   aria-expanded="false" aria-controls="collapseExample">
				<i class="fal fa-truck text-info"></i>@lang('Shipments')
			</a>
			<div class="collapse" id="dropdownCollapsible">
				<ul class="">
					<li>
						<a href="#"><i class="fal fa-th-large"></i>Dropdown 1</a>
					</li>
					<li>
						<a href="#"><i class="fal fa-th-large"></i>Dropdown 2</a>
					</li>
					<li>
						<a href="#"><i class="fal fa-th-large"></i>Dropdown 3</a>
					</li>
				</ul>
			</div>
		</li>

		<li>
			<a href="{{ route('addFund') }}"><i class="fal fa-funnel-dollar text-primary"
												aria-hidden="true"></i>@lang('Add Fund')</a>
		</li>

		<li>
			<a href="#"><i class="fal fa-file-invoice-dollar text-warning" aria-hidden="true"></i>@lang('Fund History')
			</a>
		</li>

		<li>
			<a class="{{menuActive(['payout.request'])}}" href="{{route('payout.request')}}"><i class="fal fa-credit-card text-danger" aria-hidden="true"></i>@lang('Payout')</a>
		</li>

		<li>
			<a href="#"><i class="fal fa-usd-square text-purple" aria-hidden="true"></i>@lang('Payout History')</a>
		</li>

		<li>
			<a class="{{menuActive(['user.money-transfer'])}}" href="{{route('user.money-transfer')}}"><i
					class="fal fa-exchange-alt text-orange" aria-hidden="true"></i>@lang('Money Transfer')</a>
		</li>

		<li>
			<a class="{{menuActive(['user.transaction','user.transaction.search'])}}" href="{{ route('user.transaction') }}"><i
					class="fal fa-money-check-alt text-indigo" aria-hidden="true"></i>@lang('Transaction')</a>
		</li>

		<li>
			<a class="{{menuActive(['user.ticket.list', 'user.ticket.view', 'user.ticket.create'])}}" href="{{route('user.ticket.list')}}"><i
					class="fal fa-ticket text-success" aria-hidden="true"></i>@lang('Support Ticket')</a>
		</li>

	</ul>
</div>

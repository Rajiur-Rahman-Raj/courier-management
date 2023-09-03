<!-- Sidebar -->
<div class="main-sidebar sidebar-style-2 shadow-sm">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<a href="{{ route('admin.home') }}">
				<img src="{{ getFile(config('basic.default_file_driver'),config('basic.admin_logo')) }}"
					 class="dashboard-logo"
					 alt="@lang('Logo')">
			</a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="{{ route('admin.home') }}">
				<img src="{{ getFile(config('basic.default_file_driver'),config('basic.favicon_image')) }}" class="dashboard-logo-sm" alt="@lang('Logo')">
			</a>
		</div>

		<ul class="sidebar-menu">
			<li class="menu-header">@lang('Dashboard')</li>
			<li class="dropdown {{ activeMenu(['admin.home']) }}">
				<a href="{{ route('admin.home') }}" class="nav-link"><i
						class="fas fa-tachometer-alt text-primary"></i><span>@lang('Dashboard')</span></a>
			</li>

			@if(checkPermission('manage_shipments') == true)
				<li class="menu-header">@lang('Manage Shipments')</li>
				<li class="dropdown {{ activeMenu(['shipmentList', 'createShipment', 'editShipment', 'viewShipment']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-code-branch text-purple"></i> <span>@lang('Manage Shipments')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['shipmentList', 'createShipment', 'editShipment', 'viewShipment']) }}">
							<a class="nav-link " href="{{ route('shipmentList', ['shipment_status' => 'all', 'shipment_type' => 'operator-country']) }}">
								@lang('All Shipments')
							</a>
						</li>

						<li class="{{ activeMenu(['shipmentList', 'createShipment', 'editShipment', 'viewShipment']) }}">
							<a class="nav-link " href="{{ route('shipmentList', ['shipment_status' => 'in_queue', 'shipment_type' => 'operator-country']) }}">
								@lang('In Queue')
							</a>
						</li>

					</ul>
				</li>
			@endif


			@if(checkPermission('manage_shipment_types') == true)
				<li class="menu-header">@lang('Manage Shipment Types')</li>
				<li class="dropdown {{ activeMenu(['shipmentTypeList']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-building text-primary"></i> <span>@lang('Shipment Types')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['shipmentTypeList']) }}">
							<a class="nav-link " href="{{ route('shipmentTypeList') }}">
								@lang('Shipment Type List')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('manage_shipping_rates') == true)
				<li class="menu-header">@lang('Manage Shipping Rates')</li>
				<li class="dropdown {{ activeMenu(['defaultRate', 'operatorCountryRate', 'internationallyRate', 'createShippingRateOperatorCountry', 'operatorCountryShowRate', 'internationallyShowRate', 'createShippingRateInternationally']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-building text-primary"></i> <span>@lang('Shipping Rates')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['defaultRate']) }}">
							<a class="nav-link " href="{{ route('defaultRate') }}">
								@lang('Default Rate')
							</a>
						</li>

						<li class="{{ activeMenu(['operatorCountryRate', 'createShippingRateOperatorCountry', 'operatorCountryShowRate']) }}">
							<a class="nav-link " href="{{ route('operatorCountryRate', 'state') }}">
								@lang('Operator Country Rate')
							</a>
						</li>

						<li class="{{ activeMenu(['internationallyRate', 'internationallyShowRate', 'createShippingRateInternationally']) }}">
							<a class="nav-link " href="{{ route('internationallyRate', 'country') }}">
								@lang('Internationally Rate')
							</a>
						</li>

					</ul>
				</li>
			@endif

			@if(checkPermission('manage_packing_service') == true)
				<li class="menu-header">@lang('Manage Packing Service')</li>
				<li class="dropdown {{ activeMenu(['packingServiceList']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-code-branch text-purple"></i> <span>@lang('Packing Service')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['packingServiceList']) }}">
							<a class="nav-link" href="{{ route('packingServiceList') }}">
								@lang('Service List')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('manage_parcel_service') == true)
				<li class="menu-header">@lang('Manage Parcel Service')</li>
				<li class="dropdown {{ activeMenu(['parcelServiceList']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-code-branch text-purple"></i> <span>@lang('Parcel Service')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['packingServiceList']) }}">
							<a class="nav-link" href="{{ route('parcelServiceList') }}">
								@lang('Service List')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('manage_branch') == true)
				<li class="menu-header">@lang('Manage Branch')</li>
				<li class="dropdown {{ activeMenu(['branchList', 'branchManagerList', 'branchEmployeeList', 'createEmployee', 'branchEmployeeEdit', 'createBranchManager', 'branchManagerEdit', 'createBranch', 'branchEdit', 'showBranchProfile']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-code-branch text-purple"></i> <span>@lang('Manage Branch')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['branchList']) }}">
							<a class="nav-link " href="{{ route('branchList') }}">
								@lang('Branch List')
							</a>
						</li>

						<li class="{{ activeMenu(['branchManagerList']) }}">
							<a class="nav-link " href="{{ route('branchManagerList') }}">
								@lang('Branch Manager')
							</a>
						</li>

						<li class="{{ activeMenu(['branchEmployeeList']) }}">
							<a class="nav-link " href="{{ route('branchEmployeeList') }}">
								@lang('Employee List')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('manage_department') == true)
				<li class="menu-header">@lang('Manage Departments')</li>
				<li class="dropdown {{ activeMenu(['departmentList', 'createDepartment', 'editDepartment']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-building text-primary"></i> <span>@lang('Manage Department')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['departmentList']) }}">
							<a class="nav-link " href="{{ route('departmentList') }}">
								@lang('Department List')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('manage_location') == true)
				<li class="menu-header">@lang('Manage Locations')</li>
				<li class="dropdown {{ activeMenu(['areaList', 'countryList', 'stateList', 'cityList']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-map-marker-alt"></i> <span>@lang('Manage Locations')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['countryList']) }}">
							<a class="nav-link " href="{{ route('countryList') }}">
								@lang('Country List')
							</a>
						</li>

						<li class="{{ activeMenu(['stateList']) }}">
							<a class="nav-link " href="{{ route('stateList', ['state-list']) }}">
								@lang('State List')
							</a>
						</li>

						<li class="{{ activeMenu(['cityList']) }}">
							<a class="nav-link" href="{{ route('cityList', ['city-list']) }}">
								@lang('City List')
							</a>
						</li>

						<li class="{{ activeMenu(['areaList']) }}">
							<a class="nav-link " href="{{ route('areaList', ['area-list']) }}">
								@lang('Area List')
							</a>
						</li>

					</ul>
				</li>
			@endif

			@if(checkPermission('manage_clients') == true)
				<li class="menu-header">@lang('Manage Clients')</li>
				<li class="dropdown {{ activeMenu(['clientList', 'createClient', 'clientStore']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-map-marker-alt"></i> <span>@lang('Manage Clients')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['clientList']) }}">
							<a class="nav-link " href="{{ route('clientList') }}">
								@lang('Client List')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('user_management') == true)
				<li class="menu-header">@lang('User Panel')</li>
				<li class="dropdown {{ activeMenu(['user-list','user.search','inactive.user.search','send.mail.user','inactive.user.list']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-users text-dark"></i> <span>@lang('User Management')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['user-list','user.search']) }}">
							<a class="nav-link " href="{{ route('user-list') }}">
								@lang('All User')
							</a>
						</li>
						<li class="{{ activeMenu(['inactive.user.list','inactive.user.search']) }}">
							<a class="nav-link" href="{{ route('inactive.user.list') }}">
								@lang('Inactive User')
							</a>
						</li>
						<li class="{{ activeMenu(['send.mail.user']) }}">
							<a class="nav-link" href="{{ route('send.mail.user') }}">
								@lang('Send Mail All User')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('tickets') == true)
				<li class="menu-header">@lang('Support Tickets')</li>
				<li class="dropdown {{ activeMenu(['admin.ticket','admin.ticket.view','admin.ticket.search']) }}">
					<a href="{{ route('admin.ticket') }}" class="nav-link"><i
							class="fas fa-headset text-info"></i><span>@lang('Tickets')</span></a>
				</li>
			@endif

			@if(checkPermission('transaction') == true)
				<li class="menu-header">@lang('Transactions')</li>
				<li class="dropdown {{ activeMenu(['admin.fund.add.index','admin.fund.add.search']) }}">
					<a href="{{ route('admin.fund.add.index') }}" class="nav-link"><i
							class="fas fa-money-check-alt text-green"></i><span>@lang('Add Fund List')</span></a>
				</li>

				<li class="dropdown {{ activeMenu(['admin.payout.index','admin.payout.search','payout.details']) }}">
					<a href="{{ route('admin.payout.index') }}" class="nav-link"><i
							class="far fa-money-bill-alt text-primary"></i><span>@lang('Payout List')</span></a>
				</li>

				<li class="dropdown {{ activeMenu(['admin.transaction.index','admin.transaction.search']) }}">
					<a href="{{ route('admin.transaction.index') }}" class="nav-link"><i
							class="fas fa-chart-line text-success"></i><span>@lang('Transaction List')</span></a>
				</li>
			@endif


			<li class="menu-header">@lang('Settings Panel')</li>

			@if(checkPermission('control_panel') == true)
				<li class="dropdown {{ activeMenu(['settings','seo.update','plugin.config','tawk.control','google.analytics.control','google.recaptcha.control','fb.messenger.control','service.control','logo.update','breadcrumb.update','seo.update','currency.exchange.api.config','sms.config', 'sms.template.index','sms.template.edit','voucher.settings','basic.control','securityQuestion.index','securityQuestion.create','securityQuestion.edit','pusher.config','notify.template.index','notify.template.edit','language.index','language.create', 'language.edit','language.keyword.edit', 'email.config','email.template.index','email.template.default', 'email.template.edit', 'charge.index', 'charge.edit', 'currency.index', 'currency.create', 'currency.edit', 'charge.chargeEdit' ]) }}">
					<a href="{{ route('settings') }}" class="nav-link"><i
							class="fas fa-cog text-primary"></i><span>@lang('Control Panel')</span></a>
				</li>
			@endif

			@if(checkPermission('payment_settings') == true)
				<li class="dropdown {{ activeMenu(['payment.methods','edit.payment.methods','admin.deposit.manual.index','admin.deposit.manual.create','admin.deposit.manual.edit']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-money-check-alt text-success"></i> <span>@lang('Payment Settings')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['payment.methods','edit.payment.methods']) }}">
							<a class="nav-link" href="{{ route('payment.methods') }}">
								@lang('Payment Methods')
							</a>
						</li>

						<li class="{{ activeMenu(['admin.deposit.manual.index','admin.deposit.manual.create','admin.deposit.manual.edit']) }}">
							<a class="nav-link" href="{{route('admin.deposit.manual.index')}}">
								@lang('Manual Gateway')
							</a>
						</li>
						<li class="{{ activeMenu(['admin.payment.pending']) }}">
							<a class="nav-link" href="{{route('admin.payment.pending')}}">
								@lang('Payment Request')
							</a>
						</li>
						<li class="{{ activeMenu(['admin.payment.log','admin.payment.search']) }}">
							<a class="nav-link" href="{{route('admin.payment.log')}}">
								@lang('Payment Log')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('payout_settings') == true)
				<li class="dropdown {{ activeMenu(['payout.method.list','payout.method.add','payout.method.edit']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-users-cog text-danger"></i> <span>@lang('Payout Settings')</span>
					</a>
					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['payout.method.list','payout.method.edit']) }}">
							<a class="nav-link" href="{{ route('payout.method.list') }}">
								@lang('Available Methods')
							</a>
						</li>
						<li class="{{ activeMenu(['payout.method.add']) }}">
							<a class="nav-link" href="{{ route('payout.method.add') }}">
								@lang('Add Method')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('role_permissions') == true)
				<li class="dropdown {{ activeMenu(['admin.role','admin.role.staff']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-user-friends text-success"></i> <span>@lang('Roles and Permission')</span>
					</a>

					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['admin.role']) }}">
							<a class="nav-link" href="{{ route('admin.role') }}">
								@lang('Available Roles')
							</a>
						</li>
						<li class="{{ activeMenu(['admin.role.staff']) }}">
							<a class="nav-link" href="{{ route('admin.role.staff') }}">
								@lang('Manage Staffs')
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(checkPermission('ui_settings') == true)
				<li class="dropdown {{ activeMenu(['template.show']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-users text-info"></i> <span>@lang('UI Settings')</span>
					</a>
					<ul class="dropdown-menu">
						@foreach(array_diff(array_keys(config('templates')),['message','template_media']) as $name)
							<li class="{{ activeMenu(['template.show'],$name) }}">
								<a class="nav-link" href="{{ route('template.show',$name) }}">
									@lang(ucfirst(kebab2Title($name)))
								</a>
							</li>
						@endforeach
					</ul>
				</li>
			@endif

			@if(checkPermission('content_settings') == true)
				<li class="dropdown {{ activeMenu(['content.index','content.create','content.show']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-cogs text-dark"></i> <span>@lang('Content Settings')</span>
					</a>
					<ul class="dropdown-menu">
						@foreach(array_diff(array_keys(config('contents')),['message','content_media']) as $name)
							<li class="{{ activeMenu(['content.index','content.create','content.show'],$name) }}">
								<a class="nav-link" href="{{ route('content.index',$name) }}">
									@lang(ucfirst(kebab2Title($name)))
								</a>
							</li>
						@endforeach
					</ul>
				</li>
			@endif

			@if(checkPermission('blog_settings') == true)
				<li class="dropdown {{ activeMenu(['blogCategory','blogCategoryEdit','blogCategoryCreate', 'blogList', 'blogCreate', 'blogEdit']) }}">
					<a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-cogs text-dark"></i> <span>@lang('Blog Settings')</span>
					</a>

					<ul class="dropdown-menu">
						<li class="{{ activeMenu(['blogCategory','blogCategoryCreate', 'blogCategoryEdit']) }}">
							<a class="nav-link " href="{{route('blogCategory')}}">
								@lang('Category List')
							</a>
						</li>
						<li class="{{ activeMenu(['blogList','blogCreate', 'blogEdit']) }}">
							<a class="nav-link" href="{{ route('blogList') }}">
								@lang('Blog List')
							</a>
						</li>
					</ul>
				</li>
			@endif
		</ul>

		<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
		</div>

	</aside>
</div>

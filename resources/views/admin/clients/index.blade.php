@extends('admin.layouts.master')
@section('page_title',__('Client List'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Client List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Client List')</div>
				</div>
			</div>

			<div class="row mb-3">
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
													<input placeholder="@lang('Name')" name="name"
														   value="{{ old('name',request()->name) }}"
														   type="text"
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
													<select name="client_type" class="form-control form-control-sm">
														<option value="all">@lang('All Types')</option>
														<option
															value="1" {{  request()->client_type == 1 ? 'selected' : '' }}>@lang('Sender/Customer')</option>
														<option
															value="2" {{  request()->client_type == 2 ? 'selected' : '' }}>@lang('Receiver')</option>
													</select>
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
												<div class="form-group">
													<button type="submit" class="btn btn-primary btn-sm btn-block"><i
															class="fas fa-search"></i> @lang('Search')</button>
												</div>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="card mb-4 card-primary shadow">
								<div
									class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">@lang('Client List')</h6>
									@if(adminAccessRoute(config('permissionList.Manage_Clients.Client_List.permission.add')))
										<a href="{{ route('createClient') }}" class="btn btn-sm btn-outline-primary"><i
												class="fas fa-plus-circle"></i> @lang('Create New Client')</a>
									@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table
											class="table table-striped table-hover align-items-center table-borderless">
											<thead class="thead-light">
											<tr>
												<th>@lang('Name')</th>
												<th>@lang('Phone')</th>
												<th>@lang('Email')</th>
												<th>@lang('Join date')</th>
												<th>@lang('User Type')</th>
												<th>@lang('Status')</th>
												@if(adminAccessRoute(array_merge(config('permissionList.Manage_Clients.Client_List.permission.edit'), config('permissionList.Manage_Clients.Client_List.permission.delete'), config('permissionList.Manage_Clients.Client_List.permission.show_profile'), config('permissionList.Manage_Clients.Client_List.permission.login_as'))))
													<th>@lang('Action')</th>
												@endif
											</tr>
											</thead>
											<tbody>
											@forelse($allClients as $key => $value)
												<tr>
													<td data-label="@lang('Name')">
														<div
															class="d-lg-flex d-block align-items-center branch-list-img">
															<div class="mr-3"><img
																	src="{{ getFile(optional($value->profile)->driver, optional($value->profile)->profile_picture) }}"
																	alt="user" class="rounded-circle"
																	width="40" height="40"
																	data-toggle="tooltip"
																	title=""
																	data-original-title="{{$value->name}}">
															</div>

															<div
																class="d-inline-flex d-lg-block align-items-center ms-2">
																<p class="text-dark mb-0 font-16 font-weight-medium">
																	{{$value->name}}</p>
																<span
																	class="text-dark font-weight-bold font-14 ml-1">{{ '@'.$value->username}}</span>
															</div>
														</div>

													</td>
													<td data-label="@lang('Phone')">{{ __(optional($value->profile)->phone ?? __('N/A')) }}</td>
													<td data-label="@lang('Email')">{{ __($value->email) }}</td>
													<td data-label="@lang('Join date')">{{ __(date('d M,Y - H:i',strtotime($value->created_at))) }}</td>
													<td data-label="@lang('Status')">
														@if($value->user_type == 1)
															<span
																class="badge badge-primary">@lang('Sender/Customer')</span>
														@else
															<span class="badge badge-info">@lang('Receiver')</span>
														@endif
													</td>
													<td data-label="@lang('Status')">
														@if($value->status)
															<span class="badge badge-success">@lang('Active')</span>
														@else
															<span class="badge badge-warning">@lang('Inactive')</span>
														@endif
													</td>
													@if(adminAccessRoute(array_merge(config('permissionList.Manage_Clients.Client_List.permission.edit'), config('permissionList.Manage_Clients.Client_List.permission.delete'), config('permissionList.Manage_Clients.Client_List.permission.show_profile'), config('permissionList.Manage_Clients.Client_List.permission.login_as'))))
														<td data-label="@lang('Action')">
															@if(adminAccessRoute(config('permissionList.Manage_Clients.Client_List.permission.edit')))
																<a href="{{ route('clientEdit',$value->id) }}"
																   class="btn btn-sm btn-outline-primary mb-1"><i
																		class="fas fa-edit"></i> @lang('Edit')</a>
															@endif
															@if(adminAccessRoute(config('permissionList.Manage_Clients.Client_List.permission.show_profile')))
																<a href="{{ route('client.edit',$value) }}"
																   class="btn btn-sm btn-outline-primary mb-1"><i
																		class="fas fa-user"></i> @lang('Profile')</a>
															@endif

															@if(adminAccessRoute(config('permissionList.Manage_Clients.Client_List.permission.login_as')))
																<a href="{{ route('user.clientLogin',$value) }}"
																   class="btn btn-sm btn-outline-dark mb-1"><i
																		class="fas fa-sign-in-alt"></i> @lang('Login')
																</a>
															@endif
														</td>
													@endif
												</tr>
											@empty
												<tr>
													<th colspan="100%" class="text-center">@lang('No data found')</th>
												</tr>
											@endforelse
											</tbody>
										</table>
									</div>
									<div class="card-footer">{{ $allClients->links() }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>

@endsection

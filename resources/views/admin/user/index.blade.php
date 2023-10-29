@extends('admin.layouts.master')
@section('page_title',__('User List'))

@push('extra_styles')
	<link href="{{ asset('assets/dashboard/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('User List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('User List')</div>
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
									<form action="{{ route('user.search') }}" method="get">
										@include('admin.user.searchForm')
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
									<h6 class="m-0 font-weight-bold text-primary">@lang('User List')</h6>
									@if(adminAccessRoute(config('permissionList.User_Panel.Manage_Users.permission.send_mail')))
										<a href="{{ route('send.mail.user') }}"
										   class="btn btn-sm btn-outline-primary"><i
												class="fas fa-envelope"></i> @lang('Send Mail to All')</a>
									@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table
											class="table table-striped table-hover align-items-center table-borderless">
											<thead class="thead-light">
											<tr>
												<th>@lang('SL')</th>
												<th>@lang('Name')</th>
												<th>@lang('Phone')</th>
												<th>@lang('Email')</th>
												<th>@lang('Join date')</th>
												<th>@lang('Status')</th>
												<th>@lang('Last login')</th>
												@if(adminAccessRoute(array_merge(config('permissionList.User_Panel.Manage_Users.permission.edit'), config('permissionList.User_Panel.Manage_Users.permission.delete'), config('permissionList.User_Panel.Manage_Users.permission.send_mail'), config('permissionList.User_Panel.Manage_Users.permission.login_as'))))
													<th>@lang('Action')</th>
												@endif
											</tr>
											</thead>
											<tbody>
											@forelse($users as $key => $value)
												<tr>
													<td data-label="SL">
														{{loopIndex($users) + $key}}
													</td>

													<td data-label="@lang('Name')">
														<div class="d-lg-flex d-block align-items-center ">
															<div class="mr-3"><img src="{{ $value->profilePicture() }}"
																				   alt="user"
																				   class="rounded-circle" width="35"
																				   data-toggle="tooltip" title=""
																				   data-original-title="{{$value->name}}">
															</div>
															<div class="d-inline-flex d-lg-block align-items-center">
																<p class="text-dark mb-0 font-16 font-weight-medium">{{$value->name}}</p>
																<span
																	class="text-muted font-14 ml-1">{{ '@'.$value->username}}</span>
															</div>
														</div>
													</td>
													<td data-label="@lang('Phone')">{{ __(optional($value->profile)->phone ?? __('N/A')) }}</td>
													<td data-label="@lang('Email')">{{ __($value->email) }}</td>
													<td data-label="@lang('Join date')">{{ __(date('d M,Y - H:i',strtotime($value->created_at))) }}</td>
													<td data-label="@lang('Status')">
														@if($value->status)
															<span class="badge badge-light">
																<i class="fa fa-circle text-success font-12"></i> @lang('Active')
															</span>
														@else
															<span class="badge badge-light">
																<i class="fa fa-circle text-danger font-12"></i> @lang('Inactive')
															</span>
														@endif
													</td>
													<td data-label="@lang('Last login')">{{ (optional($value->profile)->last_login_at) ? __(date('d/m/Y - H:i',strtotime($value->profile->last_login_at))) : __('N/A') }}</td>

													@if(adminAccessRoute(array_merge(config('permissionList.User_Panel.Manage_Users.permission.edit'), config('permissionList.User_Panel.Manage_Users.permission.delete'), config('permissionList.User_Panel.Manage_Users.permission.send_mail'), config('permissionList.User_Panel.Manage_Users.permission.login_as'))))
														<td data-label="@lang('Action')">
															@if(adminAccessRoute(config('permissionList.User_Panel.Manage_Users.permission.edit')))
																<a href="{{ route('user.edit',$value) }}"
																   class="btn btn-sm btn-outline-primary mb-1"><i
																		class="fas fa-user-edit"></i> @lang('Edit')</a>
															@endif
															@if(adminAccessRoute(config('permissionList.User_Panel.Manage_Users.permission.send_mail')))
																<a href="{{ route('send.mail.user',$value) }}"
																   class="btn btn-sm btn-outline-primary mb-1"><i
																		class="fas fa-envelope"></i> @lang('Send mail')
																</a>
															@endif
															@if(adminAccessRoute(config('permissionList.User_Panel.Manage_Users.permission.login_as')))
																<a href="{{ route('user.asLogin',$value) }}"
																   class="btn btn-sm btn-outline-dark mb-1"><i
																		class="fas fa-sign-in-alt"></i> @lang('Login')
																</a>
															@endif
														</td>
													@endif
												</tr>
											@empty
												<tr>
													<td colspan="100%" class="text-center p-2">
														<img class="not-found-img"
															 src="{{ asset('assets/dashboard/images/empty-state.png') }}"
															 alt="">

													</td>
												</tr>
											@endforelse
											</tbody>
										</table>
									</div>
									<div class="card-footer">{{ $users->links() }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>

@endsection
@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/flatpickr.js') }}"></script>
@endpush

@section('scripts')
	<script>
		'use strict'
		$(document).ready(function () {
			$(".flatpickr").flatpickr({
				wrap: true,
				altInput: true,
				dateFormat: "Y-m-d H:i",
			});
		})
	</script>
@endsection

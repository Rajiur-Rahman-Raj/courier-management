@extends('admin.layouts.master')
@section('page_title', __('Branch Driver List'))
@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Branch Driver List')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Branch Driver List')</div>
				</div>
			</div>

			<div class="section-body">
				<div class="row mt-sm-4">
					<div class="col-12 col-md-12 col-lg-12">
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
													<div class="col-md-3">
														<div class="form-group">
															<input placeholder="@lang('Branch')" name="branch"
																   value="{{ old('branch',request()->branch) }}"
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

													<div class="col-md-3">
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
															<button type="submit"
																	class="btn btn-primary btn-sm btn-block"><i
																	class="fas fa-search"></i> @lang('Search')</button>
														</div>
													</div>
												</div>

											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="row justify-content-md-center">
								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang('Branch Driver List')</h6>
											@if(adminAccessRoute(config('permissionList.Manage_Branch.Driver_List.permission.add')))
												@if($authenticateUser->branch != null || $authenticateUser->role_id == null)
													<a href="{{route('createDriver')}}"
													   class="btn btn-sm btn-outline-primary add"><i
															class="fas fa-plus-circle"></i> @lang('Create Driver')</a>
												@endif
											@endif
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col">@lang('Driver')</th>
														<th scope="col">@lang('Branch')</th>
														<th scope="col">@lang('Phone')</th>
														<th scope="col">@lang('Email')</th>
														<th scope="col">@lang('Status')</th>
														@if(adminAccessRoute(array_merge(config('permissionList.Manage_Branch.Driver_List.permission.edit'), config('permissionList.Manage_Branch.Driver_List.permission.login_as'), config('permissionList.Manage_Branch.Driver_List.permission.delete'))))
															<th scope="col">@lang('Action')</th>
														@endif
													</tr>
													</thead>

													<tbody>
													@forelse($branchDrivers as $key => $driver)
														<tr>
															<td data-label="@lang('Driver')">
																<a href="javascript:void(0)"
																   class="text-decoration-none">
																	<div
																		class="d-lg-flex d-block align-items-center branch-list-img">
																		<div class="mr-3"><img
																				src="{{getFile($driver->driver,$driver->image) }}"
																				alt="user" class="rounded-circle"
																				width="40" height="40"
																				data-toggle="tooltip"
																				title=""
																				data-original-title="{{ __(optional($driver->admin)->name) }}">
																		</div>
																		<div
																			class="d-inline-flex d-lg-block align-items-center ms-2">
																			<p class="text-dark mb-0 font-16 font-weight-medium">
																				{{ __(optional($driver->admin)->name) }}</p>
																			<span
																				class="text-dark font-weight-bold font-14 ml-1">{{$driver->email}}</span>
																		</div>
																	</div>
																</a>
															</td>

															<td data-label="@lang('Branch')">
																<a href="javascript:void(0)"
																   class="text-decoration-none">
																	<div
																		class="d-lg-flex d-block align-items-center branch-list-img">
																		<div class="mr-3"><img
																				src="{{getFile(optional($driver->branch)->driver,optional($driver->branch)->image) }}"
																				alt="user" class="rounded-circle"
																				width="40" height="40"
																				data-toggle="tooltip"
																				title=""
																				data-original-title="{{ __(optional($driver->branch)->branch_name) }}">
																		</div>
																		<div
																			class="d-inline-flex d-lg-block align-items-center ms-2">
																			<p class="text-dark mb-0 font-16 font-weight-medium">
																				{{ __(optional($driver->branch)->branch_name) }}</p>
																			<span
																				class="text-dark font-weight-bold font-14 ml-1">{{ __(optional($driver->branch)->email) }}</span>
																		</div>
																	</div>
																</a>
															</td>


															<td data-label="@lang('Phone')">
																{{ $driver->phone }}
															</td>

															<td data-label="@lang('Email')">
																@lang($driver->email)
															</td>

															<td data-label="@lang('Status')"
																class="font-weight-bold text-dark">
																@if($driver->status == 1)
																	<span
																		class="badge badge-success rounded">@lang('Active')</span>
																@else
																	<span
																		class="badge badge-danger">@lang('Deactive')</span>
																@endif
															</td>

															@if(adminAccessRoute(array_merge(config('permissionList.Manage_Branch.Driver_List.permission.edit'), config('permissionList.Manage_Branch.Driver_List.permission.login_as'), config('permissionList.Manage_Branch.Driver_List.permission.delete'))))
																<td data-label="@lang('Action')">
																	@if(adminAccessRoute(config('permissionList.Manage_Branch.Driver_List.permission.edit')))
																		<a href="{{ route('branchDriverEdit', $driver->id) }}"
																		   class="btn btn-outline-primary btn-sm"
																		   title="@lang('Edit')"><i
																				class="fa fa-edit"
																				aria-hidden="true"></i> @lang('Edit')
																		</a>
																	@endif
																	@if(adminAccessRoute(config('permissionList.Manage_Branch.Driver_List.permission.login_as')))
																		<button data-target="#login_as"
																				data-toggle="modal"
																				data-route="{{route('admin.role.driverLogin',optional($driver->admin)->id)}}"
																				class="btn btn-sm btn-outline-success loginUser">
																			<i
																				class="fas fa-sign-in-alt"></i> @lang(' Login As Driver')
																		</button>
																	@endif
																</td>
															@endif
														</tr>
													@empty
														<tr>
															<th colspan="100%"
																class="text-center">@lang('No data found')</th>
														</tr>
													@endforelse
													</tbody>
												</table>
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

	{{-- Login as --}}
	<div id="login_as" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Login as driver')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" class="loginRoute">
					@csrf
					<div class="modal-body">
						<p>@lang('Are you sure want to login as driver')</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
						<button type="submit" class="btn btn-primary">@lang('Submit')</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	@if ($errors->any())
		@php
			$collection = collect($errors->all());
			$errors = $collection->unique();
		@endphp
		<script>
			"use strict";
			@foreach ($errors as $error)
			Notiflix.Notify.Failure("{{ trans($error) }}");
			@endforeach
		</script>
	@endif

	<script>
		'use strict'
		$(document).on('click', '.loginUser', function () {
			var route = $(this).data('route');
			$('.loginRoute').attr('action', route)
		});
	</script>
@endsection
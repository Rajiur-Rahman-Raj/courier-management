@extends('admin.layouts.master')

@section('page_title')
	@lang('Edit Role')
@endsection


@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Edit Role")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('admin.role')}}">@lang("Role List")</a></div>
					<div class="breadcrumb-item">@lang("Edit Role")</div>
				</div>
			</div>
		</section>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h5>@lang("Edit Role")</h5>

							<a href="{{route('admin.role')}}" class="btn btn-sm  btn-primary mr-2">
								<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
							</a>
						</div>
						<div class="card-body">
							<form method="post" action="{{ route('roleUpdate', $singleRole->id) }}"
								  class="mt-4" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-sm-12 col-md-12 mb-3">
										<label for="name" class="font-weight-bold text-dark"> @lang('Role Name') <span
												class="text-danger">*</span></label>
										<input type="text" name="name"
											   placeholder="@lang('write role name')"
											   class="form-control @error('name') is-invalid @enderror"
											   value="{{ old('name', $singleRole->name) }}">
										<div class="invalid-feedback">
											@error('name') @lang($message) @enderror
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="card mb-4 card-primary ">
											<div class="card-header">
												<div class="title">
													<h5>@lang('Accessibility')</h5>
												</div>
											</div>
											<div class="card-body">
												@if(config('permissionList'))
													@foreach(config('permissionList') as $key => $sidebarMenus)
														<div class="title">
															<h6 class="text-dark">@lang(str_replace('_', ' ', $key))</h6>
														</div>

														<table
															class=" table table-hover table-striped table-bordered text-center">
															<thead class="thead-dark">
															<tr>
																<th class="text-left">@lang('Permissions')</th>
																<th>@lang('View')</th>
																<th>@lang('Add')</th>
																<th>@lang('Edit')</th>
																<th>@lang('Delete')</th>
															</tr>
															</thead>
															<tbody>
															@foreach($sidebarMenus as $key => $subMenu)
																<tr>
																	<td class="text-left">@lang($subMenu['label'])</td>
																	<td data-label="View">
																		@if(!empty($subMenu['permission']['view']))
																			<input type="checkbox"
																				   value="{{join(",",$subMenu['permission']['view'])}}"
																				   class="cursor-pointer"
																				   name="permissions[]"
																				   @if(in_array_any( $subMenu['permission']['view'], $singleRole->permission??[] ))
																					   checked
																				@endif/>
																		@else
																			<span>-</span>
																		@endif
																	</td>
																	<td data-label="Add">
																		@if(!empty($subMenu['permission']['add']))
																			<input type="checkbox"
																				   value="{{join(",",$subMenu['permission']['add'])}}"
																				   class="cursor-pointer"
																				   name="permissions[]"
																				   @if(in_array_any( $subMenu['permission']['add'], $singleRole->permission??[] ))
																					   checked
																				@endif/>
																		@else
																			<span>-</span>
																		@endif
																	</td>
																	<td data-label="Edit">
																		@if(!empty($subMenu['permission']['edit']))
																			<input type="checkbox"
																				   value="{{join(",",$subMenu['permission']['edit'])}}"
																				   class="cursor-pointer"
																				   name="permissions[]"
																				   @if(in_array_any( $subMenu['permission']['edit'], $singleRole->permission??[] ))
																					   checked
																				@endif/>
																		@else
																			<span>-</span>
																		@endif
																	</td>
																	<td data-label="Delete">
																		@if(!empty($subMenu['permission']['delete']))
																			<input type="checkbox"
																				   value="{{join(",",$subMenu['permission']['delete'])}}"
																				   class="cursor-pointer"
																				   name="permissions[]"
																				   @if(in_array_any( $subMenu['permission']['delete'], $singleRole->permission??[] ))
																					   checked
																				@endif/>
																		@else
																			<span>-</span>
																		@endif
																	</td>
																</tr>
															@endforeach
															</tbody>
														</table>
													@endforeach
												@endif
											</div>
											<div class="invalid-feedback d-block">
												@error('permissions') @lang($message) @enderror
											</div>
										</div>
									</div>

								</div>

								<div class="row">
									<div class="col-md-5 form-group">
										<label class="font-weight-bold text-dark">@lang('Status')</label>
										<div class="selectgroup w-100">
											<label class="selectgroup-item">
												<input type="radio" name="status" value="0"
													   class="selectgroup-input" {{ old('status', $singleRole->status) == 0 ? 'checked' : ''}}>
												<span class="selectgroup-button">@lang('OFF')</span>
											</label>
											<label class="selectgroup-item">
												<input type="radio" name="status" value="1"
													   class="selectgroup-input" {{ old('status', $singleRole->status) == 1 ? 'checked' : ''}}>
												<span class="selectgroup-button">@lang('ON')</span>
											</label>
										</div>
									</div>
								</div>

								<button type="submit"
										class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Update Role')</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection


@extends('admin.layouts.master')
@section('page_title', sizeof($allCities) ? optional($allCities[0]->state)->name.' '.$title : $title)
@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang(sizeof($allCities) ? optional($allCities[0]->state)->name.' '.$title : $title)</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('admin.home') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang(sizeof($allCities) ? optional($allCities[0]->state)->name.' '.$title : $title)</div>
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
													<div class="col-md-4">
														<div class="form-group">
															<input placeholder="@lang('City')" name="name"
																   value="{{ old('name',request()->name) }}"
																   type="text"
																   class="form-control form-control-sm">
														</div>
													</div>

													<div class="col-md-4">
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

													<div class="col-md-4">
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
											<h6 class="m-0 font-weight-bold text-primary">@lang('All List')</h6>

											<a href="{{route('cityList', ['city-list'])}}" class="btn btn-sm  btn-primary mr-2">
												<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
											</a>
										</div>

										<div class="card-body">
											@include('errors.error')
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col">@lang('City')</th>
														<th scope="col">@lang('Status')</th>
														<th scope="col">@lang('Action')</th>
													</tr>
													</thead>

													<tbody>
													@forelse($allCities as $key => $city)
														<tr>

															<td data-label="@lang('City')">
																@lang($city->name)
															</td>

															<td data-label="@lang('Status')"
																class="font-weight-bold text-dark">
																@if($city->status == 1)
																	<span
																		class="badge badge-success rounded">@lang('Active')</span>
																@else
																	<span
																		class="badge badge-danger">@lang('Deactive')</span>
																@endif
															</td>

															<td data-label="@lang('Action')">
																<button data-target="#editCityModal"
																		data-toggle="modal"
																		data-route="{{route('cityUpdate', $city->id)}}"
																		data-property="{{ $city }}"
																		data-countries="{{ $allCountires }}"
																		data-states="{{ $allStates }}"
																		class="btn btn-sm btn-outline-primary editCity">
																	<i class="fas fa-edit"></i> @lang(' Edit')</button>
															</td>
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
											<div class="card-footer d-flex justify-content-center">{{ $allCities->links() }}</div>
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

	{{-- Edit City Modal --}}
	<div id="editCityModal" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="primary-header-modalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-dark font-weight-bold"
						id="primary-header-modalLabel">@lang('Edit City')</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="" method="post" id="editCityForm">
					@csrf
					@method('put')
					<div class="modal-body">

						<div class="col-12 mt-3">
							<label for="">@lang('Select Country')</label>
							<select name="country_id" class="form-control @error('country_id') is-invalid @enderror selectedCountry" id="countryId">
								@foreach($allCountires as $country)
									<option value="{{ $country->id }}">@lang($country->name)</option>
								@endforeach
							</select>
							<div class="invalid-feedback">
								@error('country_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('Select State')</label>
							<select name="state_id" class="form-control @error('state_id') is-invalid @enderror selectedState" id="stateId">
								@foreach($allStates as $state)
									<option value="{{ $state->id }}">@lang($state->name)</option>
								@endforeach
							</select>
							<div class="invalid-feedback">
								@error('state_id') @lang($message) @enderror
							</div>
						</div>

						<div class="col-12 mt-3">
							<label for="">@lang('City Name')</label>
							<input
								type="text"
								class="form-control cityName" name="name"
								placeholder="@lang('Name')" required/>
						</div>

						<div class="col-md-12 my-3">
							<label for="">@lang('Status') </label>
							<div class="selectgroup w-100">
								<label class="selectgroup-item">
									<input type="radio" name="status" value="0"
										   class="selectgroup-input status_disabled">
									<span class="selectgroup-button">@lang('OFF')</span>
								</label>
								<label class="selectgroup-item">
									<input type="radio" name="status" value="1"
										   class="selectgroup-input status_enabled">
									<span class="selectgroup-button">@lang('ON')</span>
								</label>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
						<button type="submit" class="btn btn-primary">@lang('Update')</button>
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

		$(document).ready(function () {
			$(document).on('click', '.editCity', function () {

				let dataRoute = $(this).data('route');
				$('#editCityForm').attr('action', dataRoute)

				let dataProperty = $(this).data('property');
				let countries = $(this).data('countries');
				let states = $(this).data('states');

				$('#countryId').val(dataProperty.country_id);
				$('#stateId').val(dataProperty.state_id);
				$('.cityName').val(dataProperty.name);

				let change = false;
				let stateId = dataProperty.state_id;

				getSeletedCountryState(dataProperty.country_id, change, stateId);

				$(dataProperty.status == 0 ? '.status_disabled' : '.status_enabled').prop('checked', true);

			});

			$('.selectedCountry').on('change', function (){
				let selectedValue = $(this).val();
				let change = true;
				getSeletedCountryState(selectedValue, change);
			})

			function getSeletedCountryState(value, change, stateId=null) {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				$.ajax({
					url: '{{ route('getSeletedCountryState') }}',
					method: 'POST',
					data: {
						id: value,
					},
					success: function (response) {
						$('.selectedState').empty();
						let responseData = response;
						responseData.forEach(res => {
							$('.selectedState').append(`<option value="${res.id}">${res.name}</option>`)
						})
						if(change == true){
							$('.selectedState').prepend(`<option value="" selected disabled>@lang('Select State')</option>`)
						}
						$('#stateId').val(stateId);
					},
					error: function (xhr, status, error) {
						console.log(error)
					}
				});
			}
		})
	</script>
@endsection

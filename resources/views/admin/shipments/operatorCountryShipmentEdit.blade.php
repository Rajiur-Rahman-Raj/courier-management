@extends('admin.layouts.master')

@section('page_title')
	@lang('Edit Shipment')
@endsection

@push('extra_styles')
	<link rel="stylesheet" href="{{ asset('assets/dashboard/css/image-uploader.css') }}"/>
	<link href="{{ asset('assets/dashboard/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang("Edit Shipment")</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item"><a href="{{route('shipmentList', 'operator-country')}}">@lang("Shipments List")</a></div>
					<div class="breadcrumb-item">@lang("Edit Shipment")</div>
				</div>
			</div>
		</section>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h5>@lang("Update Shipment")</h5>

							<a href="{{route('shipmentList', 'operator-country')}}"
							   class="btn btn-sm  btn-primary mr-2">
								<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
							</a>
						</div>

						<div class="card-body">
							@include('errors.error')
							<div class="">
								@include('partials.OCEShipmentForm')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@php
			$oldPackingCounts = old('variant_price') ? count(old('variant_price')) : 0;
            $oldParcelCounts = old('parcel_name') ? count(old('parcel_name')) : 0;

            $oldFromStateIdPresent = 0;
            $oldFromCityIdPresent = old('from_city_id') ? 1 : 0;
            $oldFromAreaIdPresent = old('from_area_id') ? 1 : 0;

			$oldToStateIdPresent = 0;
            $oldToCityIdPresent = old('to_city_id') ? 1 : 0;
            $oldToAreaIdPresent = old('to_area_id') ? 1 : 0;
		@endphp

		@endsection

		@push('extra_scripts')
			<script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
			<script src="{{ asset('assets/dashboard/js/image-uploader.js') }}"></script>
			<script src="{{ asset('assets/dashboard/js/flatpickr.js') }}"></script>
		@endpush

		@section('scripts')
			@include('partials.getParcelUnit')
			@include('partials.locationJs')
			@include('partials.select2Create')
			@include('partials.packageVariant')
			@include('partials.createShipmentJs')
			@include('partials.editShipmentJs')
@endsection
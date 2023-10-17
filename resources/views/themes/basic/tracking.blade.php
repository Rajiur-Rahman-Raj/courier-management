@extends($theme.'layouts.app')
@section('title', trans('Tracking'))

@section('banner_main_heading')
	@lang('Tracking Order')
@endsection

@section('banner_heading')
	@lang('Tracking')
@endsection

@section('content')
	<!-- tracking_id_area_start -->
	<section class="{{ $shipment == null && $initial != true ? 'tracking_id_area_padding' : '' }}  tracking_id_area">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<div class="tracking_inner text-center">
						<div class="icon_area">
							<i class="fad fa-search-location"></i>
						</div>
						<h3 class="mb-15">@lang('Tracking Shipment')</h3>

						<form action="" method="get" enctype="multipart/form-data">
							@csrf
							<label for="exampleInputEmail1" class="form-label">
								<h5>@lang('Enter your tracking code')</h5></label>
							<div class="mb-3 position-relative d-flex align-items-center">
								<input type="text" name="shipment_id" class="form-control" id="exampleInputEmail1"
									   aria-describedby="emailHelp" placeholder="@lang('Type Shipment Id')"
									   value="{{ old('shipment_id', request()->shipment_id) }}">
								<button type="submit" class="cmn_btn">@lang('Search')</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>


	@if($shipment && $initial == false)
		@php
			$shipment_status = $shipment->status;
            $shipment_by = $shipment->shipment_by;
		@endphp

			<!--shipment tracking_area_start -->
		@if($shipment_status == 0 || $shipment_status == 6 || $shipment_status == 1 || $shipment_status == 2 || $shipment_status == 3 || $shipment_status == 4 || $shipment_status == 5)

			<section class="tracking_area">

				<div class="container-fluid">
					<div class="row justify-content-center">
						@if($shipment_by == 1)
							<div class="col-md-2 col-sm-7 col-10 box">
								<div class="cmn_box3 text-center mx-auto">
									<div
										class="icon_area mx-auto {{ ($shipment_status == 0 || $shipment_status == 6 || $shipment_status == 5 || $shipment_status == 1 || $shipment_status == 2 || $shipment_status == 3 || $shipment_status == 4 ? 'active-tracking' : 'inactive-tracking') }} ">
										<i class="fas fa-registered"></i>
									</div>

									<div class="text_area">
										<h5>@lang('Requested')</h5>
									</div>
								</div>
							</div>
						@endif
						@if($shipment_by == 1 && $shipment_status == 6)
							<div class="col-md-2 col-sm-7 col-10 box">
								<div class="cmn_box3 text-center mx-auto">
									<div
										class="icon_area mx-auto {{ ($shipment_status == 0 || $shipment_status == 6 ? 'active-tracking' : 'inactive-tracking') }} ">
										<i class="fas fa-times-circle"></i>
									</div>

									<div class="text_area">
										<h5>@lang('Cancel Shipment')</h5>
									</div>
								</div>
							</div>
						@endif
						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 1 || ($shipment_status == 6 && $shipment_by == null) || $shipment_status == 2 || $shipment_status == 3 || $shipment_status == 4 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="fas fa-spinner"></i>
								</div>
								<div class="text_area">
									<h5>@lang('In Queue')</h5>
								</div>
							</div>
						</div>

						@if($shipment_by == null && $shipment_status == 6)
							<div class="col-md-2 col-sm-7 col-10 box">
								<div class="cmn_box3 text-center mx-auto">
									<div
										class="icon_area mx-auto {{ ($shipment_status == 1 || $shipment_status == 6 ? 'active-tracking' : 'inactive-tracking') }} ">
										<i class="far fa-shopping-cart"></i>
									</div>

									<div class="text_area">
										<h5>@lang('Cancel Shipment')</h5>
									</div>
								</div>
							</div>
						@endif

						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 2 || $shipment_status == 3 || $shipment_status == 4 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="fal fa-truck"></i>
								</div>
								<div class="text_area">
									<h5>@lang('Order Shipped')</h5>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 3 || $shipment_status == 4 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="fal fa-hand-receiving"></i>
								</div>
								<div class="text_area">
									<h5>@lang('Order Received')</h5>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 4 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="far fa-check"></i>
								</div>
								<div class="text_area">
									<h5>@lang('Order Delivered')</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- shipment_info_area_start -->
			<section class="shipment_info_area">
				<div class="container">
					<div class="row gy-5">
{{--																		<div class="col-md-5">--}}
{{--																			<div class="estmated_delivery shadow3 text-center">--}}
{{--																				<div class="icon_area">--}}
{{--																					<i class="fal fa-check-circle"></i>--}}
{{--																				</div>--}}
{{--																				<h5>Estmate Delivery</h5>--}}
{{--																				<h5>August 15, 2023</h5>--}}
{{--																				<div class="btn_area mt-25">--}}
{{--																					<a href="" class="cmn_btn">Ready For Pickup</a>--}}
{{--																				</div>--}}
{{--																			</div>--}}
{{--																		</div>--}}
						<div class="col-md-12">
							<div class="shipment_details_area shadow3 text-center">
								<div class="section_subtitle mb-50">
									<h4>@lang('Shipment Details')</h4>
								</div>
								<div class="table_area d-flex text-start">
									<ul>
										<li><h5>@lang('Shipment Tracking Number')</h5></li>
										<li><h5>@lang('Shipment Type')</h5></li>
										<li><h5>@lang('Shipment Date')</h5></li>
										<li><h5>@lang('Sender Branch')</h5></li>
										<li><h5>@lang('Receiver Branch')</h5></li>
										<li><h5>@lang('Shipment Status')</h5></li>
										@if($shipment->dispatch_time != null)
											<li><h5>@lang('Dispatch Time')</h5></li>
										@endif
										@if($shipment->receive_time != null)
											<li><h5>@lang('Received Time')</h5></li>
										@endif
										@if($shipment->status == 5 && $shipment->assign_to_collect != null)
											<li><h5>@lang('Assign To Driver')</h5></li>
										@endif
									</ul>
									<ul>
										<li><h5>: {{ $shipment->shipment_id }}</h5></li>
										<li><h5>: {{ $shipment->shipment_type }}</h5></li>
										<li><h5>: {{ customDate($shipment->shipment_date) }}</h5></li>
										<li><h5>: @lang(optional($shipment->senderBranch)->branch_name)</h5></li>
										<li><h5>: @lang(optional($shipment->receiverBranch)->branch_name) </h5></li>

										<li>
											<h5>:
												@if($shipment->status == 0 || $shipment->status == 5)
													<p class="badge f_text-bg-dark">@lang('Requested')</p>
												@elseif($shipment->status == 6)
													<p class="badge f_text-bg-danger">@lang('Canceled')</p>
												@elseif($shipment->status == 1)
													<p class="badge f_text-bg-info">@lang('In Queue')</p>
												@elseif($shipment->status == 2)
													<p class="badge f_text-bg-warning">@lang('Dispatch')</p>
												@elseif($shipment->status == 3)
													<p class="badge f_text-bg-success">@lang('Received')</p>
												@elseif($shipment->status == 7 && $shipment->assign_to_delivery != null)
													<p class="badge f_text-bg-primary">@lang('Delivery In Queue')</p>
												@elseif($shipment->status == 4)
													<p class="badge f_text-bg-danger">@lang('Delivered')</p>
												@endif
											</h5>
										</li>

										@if($shipment->dispatch_time != null)
											<li><h5>: {{ customDateTime($shipment->dispatch_time) }} </h5></li>
										@endif
										@if($shipment->receive_time != null)
											<li><h5>: {{ customDateTime($shipment->receive_time) }} </h5></li>
										@endif
										@if($shipment->status == 5 && $shipment->assign_to_collect != null)
											<li><h5>: {{ optional($shipment->assignToCollect)->name }} </h5></li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- shipment_info_area_end -->

			<!-- shipment_full_details_area_start -->
			{{--			<section class="shipment_full_details_area">--}}
			{{--				<div class="container">--}}
			{{--					<div class="row">--}}
			{{--						<div class="col mx-auto">--}}
			{{--							<div class="section_header text-center">--}}
			{{--								<h4>Summary</h4>--}}
			{{--							</div>--}}
			{{--						</div>--}}
			{{--					</div>--}}
			{{--					<div class="row">--}}
			{{--						<div class="col-12">--}}
			{{--							<div class="table-responsive">--}}
			{{--								<table class="table table-striped">--}}
			{{--									<thead>--}}
			{{--									<tr>--}}
			{{--										<th scope="col">Date & Time</th>--}}
			{{--										<th scope="col">Location</th>--}}
			{{--										<th scope="col">Status</th>--}}
			{{--									</tr>--}}
			{{--									</thead>--}}
			{{--									<tbody>--}}
			{{--									<tr>--}}
			{{--										<td data-label="id" scope="row">19th Feb, 2023 - 22:30 PM</td>--}}
			{{--										<td data-label="name">Dhaka, Bangladesh</td>--}}
			{{--										<td data-label="rate">Ready for Pick Up</td>--}}
			{{--									</tr>--}}
			{{--									<tr>--}}
			{{--										<td data-label="id" scope="row">18th Feb, 2023 - 10:30 PM</td>--}}
			{{--										<td data-label="name">-</td>--}}
			{{--										<td data-label="rate">In Transit</td>--}}
			{{--									</tr>--}}
			{{--									<tr>--}}
			{{--										<td data-label="id" scope="row">5th Feb, 2023 - 15:30 PM</td>--}}
			{{--										<td data-label="name">Dubai, UAE</td>--}}
			{{--										<td data-label="rate">Shipment Received</td>--}}
			{{--									</tr>--}}
			{{--									</tbody>--}}
			{{--								</table>--}}
			{{--							</div>--}}
			{{--						</div>--}}
			{{--					</div>--}}
			{{--				</div>--}}
			{{--			</section>--}}
			<!-- shipment_full_details_area_end -->
		@else
			<!--return shipment tracking_area_start -->
			<section class="tracking_area">
				<div class="container-fluid">
					<div class="row justify-content-center">
						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 11 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="far fa-check" aria-hidden="true"></i>
								</div>
								<div class="text_area">
									<h5>@lang('Return Order Delivered')</h5>
								</div>
							</div>
						</div>

						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 10 || $shipment_status == 11 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="fal fa-hand-receiving" aria-hidden="true"></i>
								</div>
								<div class="text_area">
									<h5>@lang('Return Order Received')</h5>
								</div>
							</div>
						</div>

						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 9 || $shipment_status == 10 || $shipment_status == 11 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="fal fa-truck" aria-hidden="true"></i>
								</div>
								<div class="text_area">
									<h5>@lang('Return Order Shipped')</h5>
								</div>
							</div>
						</div>

						<div class="col-md-2 col-sm-7 col-10 box">
							<div class="cmn_box3 text-center">
								<div
									class="icon_area mx-auto {{ ($shipment_status == 8 || $shipment_status == 9 || $shipment_status == 10 || $shipment_status == 11 ? 'active-tracking' : 'inactive-tracking') }}">
									<i class="fas fa-spinner" aria-hidden="true"></i>
								</div>
								<div class="text_area">
									<h5>@lang('Return In Queue')</h5>
								</div>
							</div>
						</div>

					</div>
				</div>
			</section>
			<!--return shipment tracking_area_end -->

			<section class="shipment_info_area">
				<div class="container">
					<div class="row gy-5">
						{{--												<div class="col-md-5">--}}
						{{--													<div class="estmated_delivery shadow3 text-center">--}}
						{{--														<div class="icon_area">--}}
						{{--															<i class="fal fa-check-circle"></i>--}}
						{{--														</div>--}}
						{{--														<h5>Estmate Delivery</h5>--}}
						{{--														<h5>August 15, 2023</h5>--}}
						{{--														<div class="btn_area mt-25">--}}
						{{--															<a href="" class="cmn_btn">Ready For Pickup</a>--}}
						{{--														</div>--}}
						{{--													</div>--}}
						{{--												</div>--}}
						<div class="col-md-12">
							<div class="shipment_details_area shadow3 text-center">
								<div class="section_subtitle mb-50">
									<h4>@lang('Shipment Details')</h4>
								</div>
								<div class="table_area d-flex text-start">
									<ul>
										<li><h5>@lang('Shipment Tracking Number')</h5></li>
										<li><h5>@lang('Shipment Date')</h5></li>
										<li><h5>@lang('Sender Branch')</h5></li>
										<li><h5>@lang('Receiver Branch')</h5></li>
										<li><h5>@lang('Shipment Status')</h5></li>
									</ul>
									<ul>
										<li><h5>: {{ $shipment->shipment_id }}</h5></li>
										<li><h5>: {{ customDate($shipment->shipment_date) }}</h5></li>
										<li><h5>: @lang(optional($shipment->senderBranch)->branch_name)</h5></li>
										<li><h5>: @lang(optional($shipment->receiverBranch)->branch_name) </h5></li>
										<li>
											<h5>:
												@if($shipment->status == 8)
													<p class="badge f_text-bg-info">@lang('Return In Queue')</p>
												@elseif($shipment->status == 9)
													<p class="badge f_text-bg-warning">@lang('Return In Dispatch')</p>
												@elseif($shipment->status == 10)
													<p class="badge f_text-bg-success">@lang('Return In Received')</p>
												@elseif($shipment->status == 11)
													<p class="badge f_text-bg-danger">@lang('Return In Delivered')</p>
												@endif
											</h5>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		@endif
		<!-- shipment tracking_area_end -->

	@elseif($shipment == null && $initial == false)
		<div class="container shipment_info_area mb-5">
			<div class="row">
				<div class="col-lg-8 mx-auto ">
					<div class="track-not-found text-center">
						<div>
							<img class="img-fluid" src="{{ asset($themeTrue.'images/track-not-found.png') }}" alt="">
						</div>
						<h3 class="section_subtitle">@lang('No Result Found')</h3>
						<h5>@lang('We can’t find any results based on your search.')</h5>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection

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
	<section class="{{ $shipment == null && $initial != true ? 'tracking_id_area_padding' : '' }}  tracking_id_area" >
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
							<label for="exampleInputEmail1" class="form-label"><h5>@lang('Enter your tracking code')</h5></label>
							<div class="mb-3 position-relative d-flex align-items-center">
								<input type="text" name="shipment_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="@lang('Type Shipment Id')">
								<button type="submit" class="cmn_btn">@lang('Search')</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>


	@if($shipment && $initial == false)
		<!-- tracking_area_start -->
		<section class="tracking_area">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-md-2 col-sm-7 col-10 box">
						<div class="cmn_box3 text-center mx-auto">
							<div class="icon_area mx-auto">
								<i class="far fa-shopping-cart"></i>
							</div>
							<div class="text_area">
								<h5>Confirmed Order</h5>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-7 col-10 box">
						<div class="cmn_box3 text-center">
							<div class="icon_area mx-auto">
								<i class="fas fa-cog"></i>
							</div>
							<div class="text_area">
								<h5>Processing Order</h5>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-7 col-10 box">
						<div class="cmn_box3 text-center">
							<div class="icon_area mx-auto">
								<i class="far fa-box-check"></i>
							</div>
							<div class="text_area">
								<h5>Order Shipped</h5>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-7 col-10 box">
						<div class="cmn_box3 text-center">
							<div class="icon_area mx-auto">
								<i class="fal fa-truck"></i>
							</div>
							<div class="text_area">
								<h5>Order En Route</h5>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-7 col-10 box">
						<div class="cmn_box3 text-center">
							<div class="icon_area mx-auto">
								<i class="fal fa-home"></i>
							</div>
							<div class="text_area">
								<h5>Confiemed Order</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- tracking_area_end -->

		<!-- shipment_info_area_start -->
		<section class="shipment_info_area">
			<div class="container">
				<div class="row gy-5">
					<div class="col-md-5">
						<div class="estmated_delivery shadow3 text-center">
							<div class="icon_area">
								<i class="fal fa-check-circle"></i>
							</div>
							<h5>Estmate Delivery</h5>
							<h5>August 15, 2023</h5>
							<div class="btn_area mt-25">
								<a href="" class="cmn_btn">Ready For Pickup</a>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="shipment_details_area shadow3 text-center">
							<div class="section_subtitle mb-50">
								<h4>Shipment Details</h4>
							</div>
							<div class="table_area d-flex text-start">
								<ul>
									<li><h5>Shipment Number</h5></li>
									<li><h5>Shipment Received</h5></li>
									<li><h5>Location</h5></li>
								</ul>
								<ul>
									<li><h5>: #15456</h5></li>
									<li><h5>: 19th Feb, 2023 - 22:30 PM</h5></li>
									<li><h5>: Dhaka, Bangladesh</h5></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- shipment_info_area_end -->

		<!-- shipment_full_details_area_start -->
		<section class="shipment_full_details_area">
			<div class="container">
				<div class="row">
					<div class="col mx-auto">
						<div class="section_header text-center">
							<h4>Summary</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
								<tr>
									<th scope="col">Date & Time</th>
									<th scope="col">Location</th>
									<th scope="col">Status</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td data-label="id" scope="row">19th Feb, 2023 - 22:30 PM</td>
									<td data-label="name">Dhaka, Bangladesh</td>
									<td data-label="rate">Ready for Pick Up</td>
								</tr>
								<tr>
									<td data-label="id" scope="row">18th Feb, 2023 - 10:30 PM</td>
									<td data-label="name">-</td>
									<td data-label="rate">In Transit</td>
								</tr>
								<tr>
									<td data-label="id" scope="row">5th Feb, 2023 - 15:30 PM</td>
									<td data-label="name">Dubai, UAE</td>
									<td data-label="rate">Shipment Received</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- shipment_full_details_area_end -->
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

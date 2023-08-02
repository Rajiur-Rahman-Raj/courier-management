@extends($theme.'layouts.app')
@section('title',trans('Booking'))

@section('banner_main_heading')
	@lang('Order Booking')
@endsection

@section('banner_heading')
	@lang('Booking')
@endsection

@section('content')
	<!-- ride_details_area_start -->
	<div class="ride_details_area pt-100 pb-30">
		<div class="progress_area">
			<div class="container">
				<div class="row gy-4 justify-content-center">
					<div class="col-md-4 col-sm-6">
						<div class="progress_box text-center">
							<div class="number number1 bg_highlight mx-auto">1</div>
							<h5>Enter Ride Details</h5>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="progress_box text-center">
							<div class="number number2 mx-auto">2</div>
							<h5>Personal</h5>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="progress_box text-center">
							<div class="number number3 mx-auto">3</div>
							<h5>Shipment Details</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ride_details_area_end -->

	<!-- cmn_form_area_start -->
	<div class="cmn_form form1 mb-100">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<form action="">
						<div class="section_header text-center">
							Location Details
						</div>
						<div class="row">
							<div class="col-sm-6 mt-20">
								<label>From Country:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>
							<div class="col-sm-6 mt-20">
								<label>To Country:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>
							<div class="col-sm-6 mt-20">
								<label>From Region:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>
							<div class="col-sm-6 mt-20">
								<label>From Region:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>
							<div class="col-sm-6 mt-20">
								<label>From Area:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>
							<div class="col-sm-6 mt-20">
								<label>To Area:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>

						</div>
						<div class="costing_area mt-30">
							<div class="row gy-4">
								<div class="col-lg-3 col-sm-6 mx-auto">
									<div class="costing_box text-center">
										<span><i class="fas fa-dollar-sign"></i></span>
										<p>SHIPPING COST</p>
										<span>$0</span>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 mx-auto">
									<div class="costing_box text-center">
										<span><i class="fas fa-dollar-sign"></i></span>
										<p>TAX COST</p>
										<span>$0</span>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 mx-auto">
									<div class="costing_box text-center">
										<span><i class="fas fa-dollar-sign"></i></span>
										<p>INSURANCE COST</p>
										<span>$0</span>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 mx-auto">
									<div class="costing_box text-center">
										<span><i class="fas fa-dollar-sign"></i></span>
										<p>TOTAL COST</p>
										<span>$0</span>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- cmn_form_area_end -->

	<!-- prev_next_btn_area_start -->
	<div class="prev_next_btn_area mb-100">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="btn_area d-flex justify-content-between">
						<a href="#" class="cmn_btn opacity">Previous</a>
						<a href="{{ route('senderDetails') }}" class="cmn_btn">Next</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- prev_next_btn_area_end -->
@endsection

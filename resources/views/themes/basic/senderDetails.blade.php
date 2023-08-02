@extends($theme.'layouts.app')
@section('title',trans('Booking'))

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
	<div class="cmn_form form2 mb-100">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<form action="">
						<div class="section_header text-center">
							Customer/Sender Details
						</div>
						<div class="row">
							<div class="col-sm-6 mt-20">
								<label class="d-block">Do You Have Account ?:</label>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
									<label class="form-check-label" for="inlineRadio1">Yes</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
									<label class="form-check-label" for="inlineRadio2">No</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 mt-20">
								<label for="email">Email:</label>
								<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter your mail">
							</div>
							<div class="col-sm-6 mt-20">
								<label for="password">Password:</label>
								<input type="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Enter your password">
							</div>

							<div class="col-sm-6 mt-20">
								<label for="name">Full Name:</label>
								<input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Full Name">
							</div>
							<div class="col-sm-6 mt-20">
								<label for="phone">Phone Number:</label>
								<input type="text" class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Phone Number" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
							<div class="col-sm-6 mt-20">
								<label for="national_id">Owner National Id:</label>
								<input type="email" class="form-control" id="national_id" aria-describedby="emailHelp" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
						</div>
						<div class="section_header text-center mt-20 mb-20">
							Receiver Details
						</div>
						<div class="row">
							<div class="col-sm-6 mt-20">
								<label for="name2">Full Name:</label>
								<input type="text" class="form-control" id="name2" aria-describedby="emailHelp" placeholder="Full Name">
							</div>
							<div class="col-sm-6 mt-20">
								<label for="phone2">Phone Number:</label>
								<input type="text" class="form-control" id="phone2" aria-describedby="emailHelp" placeholder="Phone Number" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
						</div>
						<div class="section_header text-center mt-20 mb-20">
							Address Details
						</div>
						<div class="row">
							<div class="col-sm-6 mt-20">
								<label for="customer_address">Customer Address:</label>
								<input type="text" class="form-control" id="customer_address" aria-describedby="emailHelp" placeholder="Customer address">
							</div>
							<div class="col-sm-6 mt-20">
								<label for="receiver_address">Receiver Address:</label>
								<input type="text" class="form-control" id="receiver_address" aria-describedby="emailHelp" placeholder="Receiver address">
							</div>
							<div class="col-sm-6 mt-20">
								<label for="customer_location">Customer Location:</label>
								<input type="text" class="form-control" id="customer_location" aria-describedby="emailHelp" placeholder="Customer Location">
							</div>
							<div class="col-sm-6 mt-20">
								<label for="receiver_location">Receiver Location:</label>
								<input type="text" class="form-control" id="receiver_location" aria-describedby="emailHelp" placeholder="Receiver Location">
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
						<a href="{{ route('booking') }}" class="cmn_btn opacity">Previous</a>
						<a href="{{ route('shippingDetails') }}" class="cmn_btn">Next</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- prev_next_btn_area_end -->
@endsection

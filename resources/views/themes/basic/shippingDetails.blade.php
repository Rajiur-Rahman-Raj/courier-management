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
							Shipment Details
						</div>
						<div class="row">
							<div class="col-lg-6 mt-20">
								<label class="d-block">Shipment Type</label>

								<div class="form-check">
									<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
									<label class="form-check-label" for="inlineRadio1">Pickup (for Door To Door Delivery)</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
									<label class="form-check-label" for="inlineRadio2">Drop Off (for Delivery Package From Branch Directly)</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 mt-20">
								<label for="Shipping_Date">Shipping Date:</label>
								<input type="email" class="form-control" id="Shipping_Date" aria-describedby="emailHelp" placeholder="Shipping Date" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
							<div class="col-md-4 col-sm-6 mt-20">
								<label>Branch:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-6 mt-20">
								<label>Delivery Time:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Select Country</option>
									<option value="1">United States</option>
									<option value="2">United Kingdom</option>
									<option value="3">Bangladesh</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-6 mt-20">
								<label for="Amount_To_Be_Collected">Amount To Be Collected:</label>
								<input type="Amount_To_Be_Collected" class="form-control" id="Amount_To_Be_Collected" aria-describedby="emailHelp" placeholder="Amount To Be Collected:">
							</div>
							<div class="col-md-4 col-sm-6 mt-20">
								<label>Payment Type:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Prepaid</option>
									<option value="1">Postpaid</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-6 mt-20">
								<label>Payment Method:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Cash Payment</option>
									<option value="1">Invoice Payment</option>
								</select>
							</div>
							<div class="col-md-4 col-sm-6 mt-20">
								<label for="Order_Id">Order Id:</label>
								<input type="email" class="form-control" id="Order_Id" aria-describedby="emailHelp" placeholder="Order Id">
							</div>
						</div>
						<div class="section_header text-center mt-20 mb-20">
							Package Info
						</div>
						<div class="row">
							<div class="col-sm-6 mt-20">
								<label>Package Type:</label>
								<select class="form-select" aria-label="Default select example">
									<option selected>Clothes</option>
									<option value="1">Electronics</option>
									<option value="1">Free</option>
									<option value="1">hortfrut</option>
								</select>
							</div>
							<div class="col-sm-6 mt-20">
								<label for="Description">Description:</label>
								<input type="email" class="form-control" id="Description" aria-describedby="emailHelp" placeholder="Description">
							</div>


						</div>
						<div class="row justify-content-between">
							<div class="col-md-2 col-sm-3 mt-20">
								<label for="Quantity">Quantity:</label>
								<input type="text" class="form-control" id="Description" aria-describedby="emailHelp" placeholder="Quantityte" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
							<div class="col-md-2 col-sm-3 mt-20">
								<label for="Weight">Weight:</label>
								<input type="text" class="form-control" id="Weight" aria-describedby="emailHelp" placeholder="Weight" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
							<div class="col-md-2 col-sm-3 mt-20">
								<label for="Length">Length:</label>
								<input type="text" class="form-control" id="Length" aria-describedby="emailHelp" placeholder="Length" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
							<div class="col-md-2 col-sm-3 mt-20">
								<label for="Width">Width:</label>
								<input type="text" class="form-control" id="Width" aria-describedby="emailHelp" placeholder="Width" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
							</div>
							<div class="col-md-2 col-sm-3 mt-20">
								<label for="Height">Height:</label>
								<input type="text" class="form-control" id="Height" aria-describedby="emailHelp" placeholder="Height" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
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
						<a href="{{ route('senderDetails') }}" class="cmn_btn">Previous</a>
						<a href="#" class="cmn_btn">Confirm</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- prev_next_btn_area_end -->

	<!-- shipment_success_icon_section_start -->
	<div class="shipment_success_icon_section mt-50 mb-100">
		<div class="container">
			<div class="row">
				<div class="col-sm-3  mx-auto">
					<h3 class="text-center mb-30">Success !</h3>
					<div class="icon_area justify-content-center d-flex">
						<i class="far fa-check-circle"></i>
					</div>
					<h6 class="text-center mt-20">Created successfully.</h6>
				</div>
			</div>
		</div>
	</div>
	<!-- shipment_success_icon_section_end -->
@endsection

<div class="tab-pane fade show"
	 id="tab2" role="tabpanel">
	<form method="post" action="{{ route('shipmentStore') }}"
		  class="mt-4" enctype="multipart/form-data">
		@csrf
		<div class="row mb-3">
			<div class="col-sm-12 col-md-12 mb-3">
				<h6 for="branch_id"
					class="text-dark font-weight-bold"> @lang('Shipment Type') </h6>
				<div class="custom-control custom-radio">
					<input type="radio" id="shipmentTypeDropOff"
						   name="shipment_type"
						   class="custom-control-input" checked>
					<label class="custom-control-label"
						   for="shipmentTypeDropOff">@lang($shipmentTypeList[0]['shipment_type'])
						(@lang($shipmentTypeList[0]['title']))</label>
				</div>

				<div class="custom-control custom-radio">
					<input type="radio" id="shipmentTypePickup"
						   name="shipment_type"
						   data-resource="{{ $defaultShippingRateOC }}"
						   class="custom-control-input">
					<label class="custom-control-label"
						   for="shipmentTypePickup">@lang($shipmentTypeList[1]['shipment_type'])
						(@lang($shipmentTypeList[1]['title']))</label>
				</div>

				<div class="custom-control custom-radio">
					<input type="radio" id="shipmentTypeCondition"
						   name="shipment_type"
						   class="custom-control-input">
					<label class="custom-control-label"
						   for="shipmentTypeCondition">@lang($shipmentTypeList[2]['shipment_type'])
						(@lang($shipmentTypeList[2]['title']))</label>
				</div>

			</div>
		</div>

		<div class="row get_receive_amount d-none">
			<div class="col-sm-12 col-md-3 mb-3">
				<label for="receive_amount"> @lang('Get Amount From Receiver') </label>
				<div class="input-group">
					<input type="text" class="form-control shipment_date"
						   name="receive_amount"
						   value="{{ old('receive_amount',request()->receive_amount) }}"
						   placeholder="0.00"
						   onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
						   min="0"
						   autocomplete="off"/>
					<div class="input-group-append">
						<div class="form-control">
							{{ $basic->currency_symbol }}
						</div>
					</div>
					<div class="invalid-feedback">
						@error('receive_amount') @lang($message) @enderror
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-3 mb-3">
				<label for="shipment_date"> @lang('Shipment Date') </label>
				<input type="text" class="form-control shipment_date flatpickr"
					   name="shipment_date"
					   value="{{ old('shipment_date',request()->shipment_date) }}"
					   placeholder="@lang('shipment date')" autocomplete="off"/>
				<div class="invalid-feedback">
					@error('shipment_date') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="delivery_date"> @lang('Estimate Delivery Date') </label>
				<input type="date" class="form-control start_date flatpickr2"
					   name="delivery_date"
					   value="{{ old('delivery_date',request()->delivery_date) }}"
					   placeholder="@lang('Delivery date')" autocomplete="off"/>
				<div class="invalid-feedback">
					@error('delivery_date') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="sender_branch"> @lang('Sender Branch') </label>
				<select name="sender_branch"
						class="form-control @error('sender_branch') is-invalid @enderror select2 select-branch">
					<option value="" disabled selected>@lang('Select Branch')</option>
					@foreach($allBranches as $branch)
						<option
							value="{{ $branch->id }}">@lang($branch->branch_name)</option>
					@endforeach
				</select>
				<div class="invalid-feedback">
					@error('sender_branch') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="receiver_branch"> @lang('Receiver Branch')</label>
				<select name="receiver_branch"
						class="form-control @error('receiver_branch') is-invalid @enderror select2 select-branch">
					<option value="" disabled selected>@lang('Select Branch')</option>
					@foreach($allBranches as $branch)
						<option
							value="{{ $branch->id }}">@lang($branch->branch_name)</option>
					@endforeach
				</select>

				<div class="invalid-feedback">
					@error('receiver_branch') @lang($message) @enderror
				</div>
				<div class="valid-feedback"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-3 mb-3">
				<label for="sender_id"> @lang('Sender')</label>
				<select name="sender_id"
						class="form-control @error('sender_id') is-invalid @enderror select2 select-client">
					<option value="" disabled selected>@lang('Select Sender')</option>
					@foreach($senders as $sender)
						<option value="{{ $sender->id }}">@lang($sender->name)</option>
					@endforeach
				</select>

				<div class="invalid-feedback">
					@error('sender_id') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="receiver_id"> @lang('Receiver')</label>
				<select name="receiver_id"
						class="form-control @error('receiver_id') is-invalid @enderror select2 select-client">
					<option value="" disabled selected>@lang('Select Receiver')</option>
					@foreach($receivers as $receiver)
						<option
							value="{{ $receiver->id }}">@lang($receiver->name)</option>
					@endforeach
				</select>

				<div class="invalid-feedback">
					@error('receiver_id') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="from_state_id">@lang('From State') </label>
				<select name="from_state_id"
						class="form-control @error('from_state_id') is-invalid @enderror select2 select2State selectedFromState">
					<option value="" selected disabled>@lang('Select State')</option>
					@foreach(optional($basicControl->operatorCountry)->state() as $state)
						<option value="{{ $state->id }}">@lang($state->name)</option>
					@endforeach
				</select>
				<div class="invalid-feedback">
					@error('from_state_id') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="from_city_id">@lang('Select City') <span
						class="text-dark font-weight-bold">(@lang('optional'))</span></label>
				<select name="from_city_id"
						class="form-control @error('from_city_id') is-invalid @enderror select2 select2City selectedFromCity">
				</select>
				<div class="invalid-feedback">
					@error('from_city_id') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="from_area_id">@lang('Select Area') <span
						class="text-dark font-weight-bold">(@lang('optional'))</span></label>
				<select name="from_area_id"
						class="form-control @error('from_area_id') is-invalid @enderror select2 select2Area selectedFromArea">
				</select>
				<div class="invalid-feedback">
					@error('from_area_id') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="to_state_id">@lang('To State') </label>
				<select name="to_state_id"
						class="form-control @error('to_state_id') is-invalid @enderror select2 select2State selectedToState">
					<option value="" selected disabled>@lang('Select State')</option>
					@foreach(optional($basicControl->operatorCountry)->state() as $state)
						<option value="{{ $state->id }}">@lang($state->name)</option>
					@endforeach
				</select>
				<div class="invalid-feedback">
					@error('to_state_id') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-3 mb-3">
				<label for="to_city_id">@lang('Select City') <span
						class="text-dark font-weight-bold">(@lang('optional'))</span></label>
				<select name="to_city_id"
						class="form-control @error('to_city_id') is-invalid @enderror select2 select2City selectedToCity">
				</select>
				<div class="invalid-feedback">
					@error('to_city_id') @lang($message) @enderror
				</div>
			</div>


			<div class="col-sm-12 col-md-3 mb-3">
				<label for="to_area_id">@lang('Select Area') <span
						class="text-dark font-weight-bold">(@lang('optional'))</span>
				</label>
				<select name="to_area_id"
						class="form-control @error('to_area_id') is-invalid @enderror select2 select2Area selectedToArea">
				</select>
				<div class="invalid-feedback">
					@error('to_area_id') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-4 mb-3">
				<label for="payment_by"> @lang('Payment By')</label>
				<select name="payment_by"
						class="form-control @error('payment_by') is-invalid @enderror">
					<option value="1">@lang('Sender')</option>
					<option value="2">@lang('Receiver')</option>
				</select>

				<div class="invalid-feedback">
					@error('payment_by') @lang($message) @enderror
				</div>
				<div class="valid-feedback"></div>
			</div>

			<div class="col-sm-12 col-md-4 mb-3">
				<label for="payment_type"> @lang('Payment Type')</label>
				<select name="payment_type"
						class="form-control @error('payment_type') is-invalid @enderror select2">
					<option value="" disabled
							selected>@lang('Select Payment Type')</option>
					<option value="wallet">@lang('From Wallet')</option>
					<option value="cash">@lang('Cash')</option>
				</select>

				<div class="invalid-feedback">
					@error('payment_type') @lang($message) @enderror
				</div>
			</div>

			<div class="col-sm-12 col-md-4 mb-3">
				<label for="payment_status"> @lang('Payment Status')</label>
				<select name="payment_status"
						class="form-control @error('payment_status') is-invalid @enderror select2">
					<option value="" disabled
							selected>@lang('Select Payment Status')</option>
					<option value="1">@lang('Paid')</option>
					<option value="2">@lang('Unpaid')</option>
				</select>

				<div class="invalid-feedback">
					@error('payment_status') @lang($message) @enderror
				</div>
			</div>
		</div>


		<div class="row mb-3">
			<div class="col-sm-12 col-md- mt-3">
				<h6 class="text-dark font-weight-bold"> @lang('Packing Service') </h6>
				<div class="custom-control custom-radio">
					<input type="radio" id="packingServiceOn" name="packing_service"
						   class="custom-control-input" value="yes">
					<label class="custom-control-label"
						   for="packingServiceOn">@lang('Yes')</label>
				</div>
				<div class="custom-control custom-radio">
					<input type="radio" id="packingServiceOff" value="no"
						   name="packing_service"
						   class="custom-control-input" checked>
					<label class="custom-control-label"
						   for="packingServiceOff">@lang('No')</label>
				</div>
			</div>

			<div class="col-md-12 addPackingFieldButton d-none">
				<div class="form-group">
					<a href="javascript:void(0)"
					   class="btn btn-success float-right"
					   id="packingGenerate"><i
							class="fa fa-plus-circle"></i> {{ trans('Add More') }}
					</a>
				</div>
			</div>
		</div>

		<div class="addedPackingField d-none">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="input-group">
							<select name="package_id"
									class="form-control @error('package_id') is-invalid @enderror selectedPackage">
								<option value="" disabled
										selected>@lang('Select package')</option>
								@foreach($packageList as $package)
									<option
										value="{{ $package->id }}">@lang($package->package_name)</option>
								@endforeach
							</select>

							<select name="variant_id"
									class="form-control @error('variant_id') is-invalid @enderror selectedVariant">
								<option value="">@lang('Select Variant')</option>
							</select>

							<input type="text" name="variant_price"
								   class="form-control @error('variant_price') is-invalid @enderror variantPrice newVariantPrice"
								   placeholder="@lang('price')">
							<div class="input-group-append" readonly="">
								<div class="form-control">
									{{ config('basic.currency_symbol') }}
								</div>
							</div>

							<input type="text" name="variant_quantity"
								   class="form-control @error('variant_quantity') is-invalid @enderror newVariantQuantity"
								   value="{{ old('variant_quantity') }}"
								   id="variantQuantity"
								   placeholder="@lang('quantity')">

							<input type="text" name="package_cost"
								   class="form-control @error('package_cost') is-invalid @enderror managerEmail totalPackingCost packingCostValue"
								   value="{{ old('package_cost') }}" readonly
								   placeholder="@lang('total cost')">
							<div class="input-group-append" readonly="">
								<div class="form-control">
									{{ config('basic.currency_symbol') }}
								</div>
							</div>
							<span class="input-group-btn">
                                                        <button
															class="btn btn-danger delete_packing_desc custom_delete_desc_padding"
															type="button">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-md-12 d-flex justify-content-between">
				<div>
					<h6 for="branch_id"
						class="text-dark font-weight-bold"> @lang('Shipment Parcel Information') </h6>
				</div>

				<div class="addParcelFieldButton">
					<div class="form-group">
						<a href="javascript:void(0)"
						   class="btn btn-success float-right"
						   id="parcelGenerate"><i
								class="fa fa-plus-circle"></i> {{ trans('Add More') }}
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="add_cod_parcel_info d-none">
			<div class="row">
				<div class="col-sm-12 col-md-12 mb-3">
					<label
						for="parcel_details"> @lang('Parcel Details') </label>
					<textarea type="text" name="parcel_details"
							  class="form-control @error('parcel_details') is-invalid @enderror"
							  id="cod_parcel_details"
							  value="{{ old('parcel_details') }}"
							  placeholder="@lang('parcel details')" rows="20"
							  cols="20"></textarea>
					<div class="invalid-feedback">
						@error('parcel_details') @lang($message) @enderror
					</div>
				</div>
			</div>
		</div>

		<div class="addedParcelField">
			<div class="row">
				<div class="col-sm-12 col-md-3 mb-3">
					<label
						for="parcel_name"> @lang('Parcel Name') </label>
					<input type="text" name="parcel_name"
						   class="form-control @error('parcel_name') is-invalid @enderror"
						   value="{{ old('parcel_name') }}">
					<div class="invalid-feedback">
						@error('parcel_name') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-3 mb-3">
					<label for="parcel_quantity"> @lang('Parcel Quantity')</label>
					<input type="text" name="parcel_quantity"
						   class="form-control @error('parcel_quantity') is-invalid @enderror"
						   value="{{ old('parcel_quantity') }}">
					<div class="invalid-feedback">
						@error('parcel_quantity') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-3 mb-3">
					<label for="parcel_type_id"> @lang('Parcel Type') </label>
					<select name="parcel_type_id"
							class="form-control @error('parcel_type_id') is-invalid @enderror select2 selectedParcelType select2ParcelType OCParcelTypeWiseShippingRate">
						<option value="" disabled
								selected>@lang('Select Parcel Type')</option>
						@foreach($parcelTypes as $parcel_type)
							<option
								value="{{ $parcel_type->id }}">@lang($parcel_type->parcel_type)</option>
						@endforeach
					</select>

					<div class="invalid-feedback">
						@error('parcel_type_id') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-3 mb-3">
					<label for="parcel_unit_id"> @lang('Select Unit') </label>
					<select name="parcel_unit_id"
							class="form-control @error('parcel_unit_id') is-invalid @enderror selectedParcelUnit">
						<option value="" disabled
								selected>@lang('Select Parcel Unit')</option>
					</select>

					<div class="invalid-feedback">
						@error('parcel_unit_id') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-4 mb-3">

					<label for="cost_per_unit"> @lang('Cost per unit')</label>
					<div class="input-group">
						<input type="text" name="cost_per_unit"
							   class="form-control @error('cost_per_unit') is-invalid @enderror unitPrice newCostPerUnit"
							   value="{{ old('cost_per_unit') }}">
						<div class="input-group-append" readonly="">
							<div class="form-control">
								{{ $basic->currency_symbol }}
							</div>
						</div>

						<div class="invalid-feedback">
							@error('cost_per_unit') @lang($message) @enderror
						</div>

					</div>
				</div>

				<div class="col-sm-12 col-md-4 mb-3 new_total_weight_parent">
					<label for="parcel_weight"> @lang('Total Unit')</label>
					<div class="input-group">
						<input type="text" name="parcel_weight"
							   class="form-control @error('parcel_weight') is-invalid @enderror newTotalWeight"
							   value="{{ old('parcel_weight') }}">
						<div class="input-group-append" readonly="">
							<div class="form-control">
								@lang('kg')
							</div>
						</div>
					</div>

					<div class="invalid-feedback">
						@error('parcel_weight') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-4 mb-3">
					<label for="parcel_total_cost"> @lang('Total Cost')</label>
					<div class="input-group">
						<input type="text" name="parcel_total_cost"
							   class="form-control @error('parcel_total_cost') is-invalid @enderror totalParcelCost"
							   value="{{ old('parcel_total_cost') }}">
						<div class="input-group-append" readonly="">
							<div class="form-control">
								{{ $basic->currency_symbol }}
							</div>
						</div>
					</div>

					<div class="invalid-feedback">
						@error('parcel_total_cost') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-12 d-flex justify-content-between">
					<label for="email"> @lang('Dimensions') [Length x Width x Height]
						(cm)
						<span
							class="text-dark font-weight-bold">(@lang('optional')</span></label>
				</div>

				<div class="col-sm-12 col-md-4 mb-3">
					<input type="text" name="parcel_length"
						   class="form-control @error('parcel_length') is-invalid @enderror"
						   value="{{ old('parcel_length') }}">
					<div class="invalid-feedback">
						@error('parcel_length') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-4 mb-3">
					<input type="text" name="parcel_width"
						   class="form-control @error('parcel_width') is-invalid @enderror"
						   value="{{ old('parcel_width') }}">
					<div class="invalid-feedback">
						@error('parcel_width') @lang($message) @enderror
					</div>
				</div>

				<div class="col-sm-12 col-md-4 mb-3">
					<input type="text" name="parcel_height"
						   class="form-control @error('parcel_height') is-invalid @enderror"
						   value="{{ old('parcel_height') }}">
					<div class="invalid-feedback">
						@error('parcel_height') @lang($message) @enderror
					</div>
				</div>

			</div>
		</div>


		<div class="row">
			<div class="col-sm-12 col-md-7">
				<div class="form-group mb-4">
					<label class="col-form-label">@lang("Attatchments")</label>
					<div class="shipment_image"></div>
					@error('shipment_image.*')
					<span class="text-danger">@lang($message)</span>
					@enderror
				</div>
			</div>


			<div class="col-md-5 form-group">
				<label>@lang('Status')</label>
				<div class="selectgroup w-100">
					<label class="selectgroup-item">
						<input type="radio" name="status" value="0"
							   class="selectgroup-input" {{ old('status') == 0 ? 'checked' : ''}}>
						<span class="selectgroup-button">@lang('OFF')</span>
					</label>
					<label class="selectgroup-item">
						<input type="radio" name="status" value="1"
							   class="selectgroup-input" {{ old('status') == 1 ? 'checked' : ''}}>
						<span class="selectgroup-button">@lang('ON')</span>
					</label>
				</div>
			</div>
		</div>


		<div class="border-line-area">
			<h6 class="border-line-title">Summary</h6>
		</div>

		<div class="d-flex justify-content-end shipmentsDiscount">
			<div class="col-md-3">
				<div class="input-group">
					<span class="input-group-text">@lang('Discount')</span>
					<input type="number" name="discount" value=""
						   class="form-control bg-white text-dark OCDiscount"
						   id="discount">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</div>

		<div class=" d-flex justify-content-end mt-2">
			<div class="col-md-3 d-flex justify-content-between">
				<span class="fw-bold">@lang('Discount Amount')</span>
				<div class="input-group w-50">
					<input type="number" name="discount_amount" value="0"
						   class="form-control bg-white text-dark OCDiscountAmount"
						   readonly>
					<div class="input-group-append" readonly="">
						<div class="form-control">
							{{ $basic->currency_symbol }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class=" d-flex justify-content-end mt-2">
			<div class="col-md-3 d-flex justify-content-between">
				<span class="fw-bold">@lang('Subtotal')</span>
				<div class="input-group w-50">
					<input type="number" name="sub_total" value="0"
						   class="form-control bg-white text-dark OCSubTotal" readonly>
					<div class="input-group-append" readonly="">
						<div class="form-control">
							{{ $basic->currency_symbol }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="pickup d-none">
			<div class=" d-flex justify-content-end mt-2">
				<div class="col-md-3 d-flex justify-content-between">
					<span class="fw-bold">@lang('Pickup Cost')</span>
					<div class="input-group w-50">
						<input type="number" name="oc_pickup_cost" value="0"
							   class="form-control bg-white text-dark OCPickupCost"
							   readonly disabled>
						<div class="input-group-append" readonly="">
							<div class="form-control">
								{{ $basic->currency_symbol }}
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class=" d-flex justify-content-end mt-2">
				<div class="col-md-3 d-flex justify-content-between">
					<span class="fw-bold">@lang('Supply Cost')</span>
					<div class="input-group w-50">
						<input type="number" name="oc_supply_cost" value="0"
							   class="form-control bg-white text-dark OCSupplyCost"
							   readonly disabled>
						<div class="input-group-append" readonly="">
							<div class="form-control">
								{{ $basic->currency_symbol }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class=" d-flex justify-content-end mt-2">
			<div class="col-md-3 d-flex justify-content-between">
				<span class="fw-bold">@lang('Shipping Cost')</span>
				<div class="input-group w-50">
					<input type="number" name="oc_shipping_cost" value="0"
						   class="form-control bg-white text-dark OCShippingCost"
						   readonly disabled>
					<div class="input-group-append" readonly="">
						<div class="form-control">
							{{ $basic->currency_symbol }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class=" d-flex justify-content-end mt-2">
			<div class="col-md-3 d-flex justify-content-between">
				<span class="fw-bold">@lang('Tax')</span>
				<div class="input-group w-50">
					<input type="number" name="sub_total" value="0"
						   class="form-control bg-white text-dark OCTax" readonly
						   disabled>
					<div class="input-group-append" readonly="">
						<div class="form-control">
							{{ $basic->currency_symbol }}
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class=" d-flex justify-content-end mt-2">
			<div class="col-md-3 d-flex justify-content-between">
				<span class="fw-bold">@lang('Insurance')</span>
				<div class="input-group w-50">
					<input type="number" name="sub_total" value="0"
						   class="form-control bg-white text-dark OCInsurance" readonly
						   disabled>
					<div class="input-group-append" readonly="">
						<div class="form-control">
							{{ $basic->currency_symbol }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class=" d-flex justify-content-end mt-2">
			<div class="col-md-3 d-flex justify-content-between">
				<span class="fw-bold">@lang('Total Pay')</span>
				<div class="input-group w-50">
					<input type="number" name="total_pay" value="0"
						   class="form-control bg-white text-dark OCtotalPay" readonly>
					<div class="input-group-append" readonly="">
						<div class="form-control">
							{{ $basic->currency_symbol }}
						</div>
					</div>
				</div>
			</div>
		</div>


		<button type="submit"
				class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
	</form>
</div>
